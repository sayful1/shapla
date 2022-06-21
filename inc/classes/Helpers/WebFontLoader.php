<?php
/**
 * Download webfonts locally.
 *
 * @package WPTT/webfont-loader
 * @license https://opensource.org/licenses/MIT
 *
 * @since 3.6.0
 */

namespace Shapla\Helpers;

use WP_Filesystem_Base;

/**
 * Download webfonts locally.
 */
class WebFontLoader {

	/**
	 * The font-format.
	 *
	 * Use "woff" or "woff2".
	 * This will change the user-agent user to make the request.
	 *
	 * @var string
	 */
	protected $font_format = 'woff2';

	/**
	 * The remote URL.
	 *
	 * @var string
	 */
	protected $remote_url;

	/**
	 * Base path.
	 *
	 * @var string
	 */
	protected $base_path;

	/**
	 * Base URL.
	 *
	 * @var string
	 */
	protected $base_url;

	/**
	 * Subfolder name.
	 *
	 * @var string
	 */
	protected $subfolder_name;

	/**
	 * The fonts folder.
	 *
	 * @var string
	 */
	protected $fonts_folder;

	/**
	 * The local stylesheet's path.
	 *
	 * @var string
	 */
	protected $local_stylesheet_path;

	/**
	 * The local stylesheet's URL.
	 *
	 * @var string
	 */
	protected $local_stylesheet_url;

	/**
	 * The remote CSS.
	 *
	 * @var string
	 */
	protected $remote_styles;

	/**
	 * The final CSS.
	 *
	 * @var string
	 */
	protected $css;

	/**
	 * Cleanup routine frequency.
	 */
	const CLEANUP_FREQUENCY = 'monthly';

	/**
	 * Constructor.
	 *
	 * Get a new instance of the object for a new URL.
	 *
	 * @param string $url The remote URL.
	 */
	public function __construct( $url = '' ) {
		$this->remote_url = $url;

		// Add a cleanup routine.
		$this->schedule_cleanup();
		add_action( 'delete_fonts_folder', array( $this, 'delete_fonts_folder' ) );
	}

	/**
	 * Get the local URL which contains the styles.
	 *
	 * Fallback to the remote URL if we were unable to write the file locally.
	 *
	 * @return string
	 */
	public function get_url() {

		// Check if the local stylesheet exists.
		if ( $this->local_file_exists() ) {

			// Attempt to update the stylesheet. Return the local URL on success.
			if ( $this->write_stylesheet() ) {
				return $this->get_local_stylesheet_url();
			}
		}

		// If the local file exists, return its URL, with a fallback to the remote URL.
		$font_url = file_exists( $this->get_local_stylesheet_path() )
			? $this->get_local_stylesheet_url()
			: $this->remote_url;

		update_site_option( 'shapla_webfont_url', wp_json_encode( $font_url ) );

		return $font_url;
	}

	/**
	 * Get the local stylesheet URL.
	 *
	 * @return string
	 */
	public function get_local_stylesheet_url() {
		if ( ! $this->local_stylesheet_url ) {
			$this->local_stylesheet_url = str_replace(
				$this->get_base_path(),
				$this->get_base_url(),
				$this->get_local_stylesheet_path()
			);
		}

		return $this->local_stylesheet_url;
	}

	/**
	 * Get styles with fonts downloaded locally.
	 *
	 * @return string
	 */
	public function get_styles() {

		// If we already have the local file, return its contents.
		$local_stylesheet_contents = $this->get_local_stylesheet_contents();
		if ( $local_stylesheet_contents ) {
			return $local_stylesheet_contents;
		}

		// Get the remote URL contents.
		$this->remote_styles = $this->get_remote_url_contents();

		// Get an array of locally-hosted files.
		$files = $this->get_local_files_from_css();

		// Convert paths to URLs.
		foreach ( $files as $remote => $local ) {
			$files[ $remote ] = str_replace(
				$this->get_base_path(),
				$this->get_base_url(),
				$local
			);
		}

		$this->css = str_replace(
			array_keys( $files ),
			array_values( $files ),
			$this->remote_styles
		);

		$this->write_stylesheet();

		return $this->css;
	}

	/**
	 * Get local stylesheet contents.
	 *
	 * @return string|false Returns the remote URL contents.
	 */
	public function get_local_stylesheet_contents() {
		$local_path = $this->get_local_stylesheet_path();

		// Check if the local stylesheet exists.
		if ( $this->local_file_exists() ) {

			// Attempt to update the stylesheet. Return false on fail.
			if ( ! $this->write_stylesheet() ) {
				return false;
			}
		}

		ob_start();
		include $local_path;

		return ob_get_clean();
	}

	/**
	 * Get remote file contents.
	 *
	 * @return string Returns the remote URL contents.
	 */
	public function get_remote_url_contents() {

		/**
		 * The user-agent we want to use.
		 *
		 * The default user-agent is the only one compatible with woff (not woff2)
		 * which also supports unicode ranges.
		 */
		$user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8';

		// Switch to a user-agent supporting woff2 if we don't need to support IE.
		if ( 'woff2' === $this->font_format ) {
			$user_agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0';
		}

		// Get the response.
		$response = wp_remote_get( $this->remote_url, array( 'user-agent' => $user_agent ) );

		// Early exit if there was an error.
		if ( is_wp_error( $response ) ) {
			return '';
		}

		// Get the CSS from our response.
		$contents = wp_remote_retrieve_body( $response );

		return $contents;
	}

	/**
	 * Download files mentioned in our CSS locally.
	 *
	 * @return array Returns an array of remote URLs and their local counterparts.
	 */
	public function get_local_files_from_css() {
		$font_files = $this->get_remote_files_from_css();
		$stored     = get_site_option( 'downloaded_font_files', array() );
		$change     = false; // If in the end this is true, we need to update the cache option.

		if ( ! defined( 'FS_CHMOD_DIR' ) ) {
			define( 'FS_CHMOD_DIR', ( 0755 & ~umask() ) );
		}

		// If the fonts folder don't exist, create it.
		if ( ! file_exists( $this->get_fonts_folder() ) ) {
			$this->get_filesystem()->mkdir( $this->get_fonts_folder(), FS_CHMOD_DIR );
		}

		foreach ( $font_files as $font_family => $font_weights ) {

			// The folder path for this font-family.
			$folder_path = $this->get_fonts_folder() . '/' . $font_family;

			// If the folder doesn't exist, create it.
			if ( ! file_exists( $folder_path ) ) {
				$this->get_filesystem()->mkdir( $folder_path, FS_CHMOD_DIR );
			}

			foreach ( $font_weights as $files ) {
				foreach ( $files as $url ) {

					// Get the filename.
					$filename  = basename( wp_parse_url( $url, PHP_URL_PATH ) );
					$font_path = $folder_path . '/' . $filename;

					// Check if the file already exists.
					if ( file_exists( $font_path ) ) {

						// Skip if already cached.
						if ( isset( $stored[ $url ] ) ) {
							continue;
						}

						// Add file to the cache and change the $changed var to indicate we need to update the option.
						$stored[ $url ] = $font_path;
						$change         = true;

						// Since the file exists we don't need to proceed with downloading it.
						continue;
					}

					/**
					 * If we got this far, we need to download the file.
					 */

					// require file.php if the download_url function doesn't exist.
					if ( ! function_exists( 'download_url' ) ) {
						require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
					}

					// Download file to temporary location.
					$tmp_path = download_url( $url );

					// Make sure there were no errors.
					if ( is_wp_error( $tmp_path ) ) {
						continue;
					}

					// Move temp file to final destination.
					$success = $this->get_filesystem()->move( $tmp_path, $font_path, true );
					if ( $success ) {
						$stored[ $url ] = $font_path;
						$change         = true;
					}
				}
			}
		}

		// If there were changes, update the option.
		if ( $change ) {

			// Cleanup the option and then save it.
			foreach ( $stored as $url => $path ) {
				if ( ! file_exists( $path ) ) {
					unset( $stored[ $url ] );
				}
			}
			update_site_option( 'downloaded_font_files', $stored );
		}

		return $stored;
	}

	/**
	 * Get the font files and preload them.
	 *
	 * @access public
	 */
	public function preload_local_fonts() {
		// Make sure variables are set.
		// Get the remote URL contents.
		$styles = $this->get_styles();

		// Get an array of locally-hosted files.
		$local_font = array();
		$font_files = $this->get_remote_files_from_css( $styles );

		foreach ( $font_files as $font_family => $font_weights ) {
			foreach ( $font_weights as $files ) {
				if ( is_array( $files ) ) {
					$local_font[] = end( $files );
				}
			}
		}

		// Caching this for further optimization.
		update_site_option( 'shapla_local_font_files', $local_font );
	}

	/**
	 * Get font files from the CSS.
	 *
	 * @return array Returns an array of font-families and the font-files used.
	 */
	public function get_remote_files_from_css( $remote_styles = '' ) {

		if ( '' === $remote_styles ) {
			$remote_styles = $this->remote_styles;
		}

		$font_faces = explode( '@font-face', $remote_styles );

		$result = array();

		// Loop all our font-face declarations.
		foreach ( $font_faces as $font_face ) {

			// Make sure we only process styles inside this declaration.
			$style = explode( '}', $font_face )[0];

			// Sanity check.
			if ( false === strpos( $style, 'font-family' ) ) {
				continue;
			}

			// Get an array of our font-families.
			preg_match_all( '/font-family.*?\;/', $style, $matched_font_families );

			// Get an array of our font-weights.
			preg_match( '/font-weight:\s?(?P<font_weight>.*?)\;/', $style, $matched_font_weights );

			if ( isset( $matched_font_weights['font_weight'] ) ) {
				$font_weight = $matched_font_weights['font_weight'];
			} else {
				$font_weight = 'normal';
			}

			// Get an array of our font-files.
			preg_match_all( '/url\(.*?\)/i', $style, $matched_font_files );

			// Get the font-family name.
			$font_family = 'unknown';
			if ( isset( $matched_font_families[0] ) && isset( $matched_font_families[0][0] ) ) {
				$font_family = rtrim( ltrim( $matched_font_families[0][0], 'font-family:' ), ';' );
				$font_family = trim( str_replace( array( "'", ';' ), '', $font_family ) );
				$font_family = sanitize_key( strtolower( str_replace( ' ', '-', $font_family ) ) );
			}

			// Make sure the font-family is set in our array.
			if ( ! isset( $result[ $font_family ] ) ) {
				$result[ $font_family ] = array(
					"$font_weight" => []
				);
			}

			// Get files for this font-family and add them to the array.
			foreach ( $matched_font_files as $match ) {

				// Sanity check.
				if ( ! isset( $match[0] ) ) {
					continue;
				}

				// Add the file URL.
				$result[ $font_family ][ $font_weight ][] = rtrim( ltrim( $match[0], 'url(' ), ')' );
			}

			// Make sure we have unique items.
			// We're using array_flip here instead of array_unique for improved performance.
			$result[ $font_family ][ $font_weight ] = array_flip( array_flip( $result[ $font_family ][ $font_weight ] ) );
		}

		return $result;
	}

	/**
	 * Write the CSS to the filesystem.
	 *
	 * @return string|false Returns the absolute path of the file on success, or false on fail.
	 */
	protected function write_stylesheet() {
		$file_path  = $this->get_local_stylesheet_path();
		$filesystem = $this->get_filesystem();

		if ( ! defined( 'FS_CHMOD_DIR' ) ) {
			define( 'FS_CHMOD_DIR', ( 0755 & ~umask() ) );
		}

		// If the folder doesn't exist, create it.
		if ( ! file_exists( $this->get_fonts_folder() ) ) {
			$this->get_filesystem()->mkdir( $this->get_fonts_folder(), FS_CHMOD_DIR );
		}

		// If the file doesn't exist, create it. Return false if it can not be created.
		if ( ! $filesystem->exists( $file_path ) && ! $filesystem->touch( $file_path ) ) {
			return false;
		}

		// If we got this far, we need to write the file.
		// Get the CSS.
		if ( ! $this->css ) {
			$this->get_styles();
		}

		// Put the contents in the file. Return false if that fails.
		if ( ! $filesystem->put_contents( $file_path, $this->css ) ) {
			return false;
		}

		return $file_path;
	}

	/**
	 * Get the stylesheet path.
	 *
	 * @return string
	 */
	public function get_local_stylesheet_path() {
		if ( ! $this->local_stylesheet_path ) {
			$this->local_stylesheet_path = $this->get_fonts_folder() . '/' . $this->get_local_stylesheet_filename() . '.css';
		}

		return $this->local_stylesheet_path;
	}

	/**
	 * Get the local stylesheet filename.
	 *
	 * This is a hash, generated from the site-URL, the wp-content path and the URL.
	 * This way we can avoid issues with sites changing their URL, or the wp-content path etc.
	 *
	 * @return string
	 */
	public function get_local_stylesheet_filename() {
		return md5( $this->get_base_url() . $this->get_base_path() . $this->remote_url . $this->font_format );
	}

	/**
	 * Set the font-format to be used.
	 *
	 * @param string $format The format to be used. Use "woff" or "woff2".
	 *
	 * @return void
	 */
	public function set_font_format( $format = 'woff2' ) {
		$this->font_format = $format;
	}

	/**
	 * Check if the local stylesheet exists.
	 *
	 * @return bool
	 */
	public function local_file_exists() {
		return ( ! file_exists( $this->get_local_stylesheet_path() ) );
	}

	/**
	 * Get the base path.
	 *
	 * @return string
	 */
	public function get_base_path() {
		if ( ! $this->base_path ) {
			$dir = Filesystem::get_uploads_dir();
			Filesystem::maybe_create_uploads_dir( $dir['path'] );
			$this->base_path = apply_filters( 'shapla_get_local_fonts_base_path', $dir['path'] );
		}

		return $this->base_path;
	}

	/**
	 * Get the base URL.
	 *
	 * @return string
	 */
	public function get_base_url() {
		if ( ! $this->base_url ) {
			$dir            = Filesystem::get_uploads_dir();
			$this->base_url = apply_filters( 'shapla_get_local_fonts_base_url', $dir['url'] );
		}

		return $this->base_url;
	}

	/**
	 * Get the subfolder name.
	 *
	 * @return string
	 */
	public function get_subfolder_name() {
		if ( ! $this->subfolder_name ) {
			$this->subfolder_name = apply_filters( 'shapla_get_local_fonts_subfolder_name', 'fonts' );
		}

		return $this->subfolder_name;
	}

	/**
	 * Get the folder for fonts.
	 *
	 * @return string
	 */
	public function get_fonts_folder() {
		if ( ! $this->fonts_folder ) {
			$this->fonts_folder = $this->get_base_path();
			if ( $this->get_subfolder_name() ) {
				$this->fonts_folder .= '/' . $this->get_subfolder_name();
			}
		}

		return $this->fonts_folder;
	}

	/**
	 * Schedule a cleanup.
	 *
	 * Deletes the fonts files on a regular basis.
	 * This way font files will get updated regularly,
	 * and we avoid edge cases where unused files remain in the server.
	 *
	 * @return void
	 */
	public function schedule_cleanup() {
		if ( ! is_multisite() || ( is_multisite() && is_main_site() ) ) {
			if ( ! wp_next_scheduled( 'delete_fonts_folder' ) && ! wp_installing() ) {
				wp_schedule_event( time(), self::CLEANUP_FREQUENCY, 'delete_fonts_folder' );
			}
		}
	}

	/**
	 * Delete the fonts folder.
	 *
	 * This runs as part of a cleanup routine.
	 *
	 * @return bool
	 */
	public function delete_fonts_folder() {
		delete_site_option( 'shapla_local_font_files' );
		delete_site_option( 'shapla_webfont_url' );

		return $this->get_filesystem()->delete( $this->get_fonts_folder(), true );
	}

	/**
	 * Get the filesystem.
	 *
	 * @return WP_Filesystem_Base
	 */
	protected function get_filesystem() {
		return Filesystem::get_filesystem();
	}
}
