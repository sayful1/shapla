<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Shapla_Filesystem {

	/**
	 * Get WordPress file system
	 *
	 * @return bool|WP_Filesystem_Base
	 */
	public static function get_filesystem() {
		global $wp_filesystem;
		if ( ! $wp_filesystem instanceof WP_Filesystem_Base ) {
			/**
			 * you can safely run request_filesystem_credentials() without any issues and don't need
			 * to worry about passing in a URL
			 */
			$credentials = request_filesystem_credentials( site_url(), '', false, false, array() );

			/* initialize the API */
			if ( ! WP_Filesystem( $credentials ) ) {
				/* any problems and we exit */
				return false;
			}
		}

		// Set the permission constants if not already set.
		if ( ! defined( 'FS_CHMOD_DIR' ) ) {
			define( 'FS_CHMOD_DIR', 0755 );
		}

		if ( ! defined( 'FS_CHMOD_FILE' ) ) {
			define( 'FS_CHMOD_FILE', 0644 );
		}

		return $wp_filesystem;
	}

	/**
	 * Create uploads directory if it does not exist.
	 *
	 * @param String $dir directory path to be created.
	 *
	 * @return boolean True of the directory is created. False if directory is not created.
	 */
	public static function maybe_create_uploads_dir( $dir ) {
		$filesystem = static::get_filesystem();
		// Create the upload dir if it doesn't exist.
		if ( ! $filesystem->is_dir( $dir ) ) {
			// Create the directory.
			if ( ! $filesystem->mkdir( $dir ) ) {
				return false;
			}

			// Add an index file for security.
			$filesystem->put_contents( rtrim( $dir, '/' ) . '/index.php', "<?php\n# Silence is golden." );
		}

		return true;
	}

	/**
	 * Returns an array of paths for the upload directory of the current site.
	 *
	 * @param String $assets_dir directory name to be created in the WordPress uploads directory.
	 *
	 * @return array
	 */
	public static function get_uploads_dir( $assets_dir = 'shapla' ) {
		$upload_dir = wp_get_upload_dir();

		// SSL workaround.
		if ( static::is_ssl() ) {
			$upload_dir['baseurl'] = str_ireplace( 'http://', 'https://', $upload_dir['baseurl'] );
		}

		// Build the paths.
		$dir_info = array(
			'path' => $upload_dir['basedir'] . '/' . $assets_dir,
			'url'  => $upload_dir['baseurl'] . '/' . $assets_dir,
		);

		return apply_filters( 'shapla_get_assets_uploads_dir', $dir_info );
	}

	/**
	 * Re-create CSS file
	 *
	 * @param string $styles
	 *
	 * @return bool|array
	 */
	public static function update_customize_css( $styles ) {
		$filesystem = static::get_filesystem();
		if ( ! $filesystem instanceof WP_Filesystem_Base ) {
			return false;
		}

		$assets_dir    = static::get_uploads_dir( 'shapla' );
		$theme_css_dir = $assets_dir['path'] . '/css';

		// Create assets directory if not exists
		static::maybe_create_uploads_dir( $assets_dir['path'] );

		// Create CSS directory if not exists
		static::maybe_create_uploads_dir( $theme_css_dir );

		$css_file_name  = 'customize-style-' . uniqid() . '.css';
		$theme_css_file = $theme_css_dir . '/' . $css_file_name;

		// Remove old files
		array_map( 'unlink', glob( $theme_css_dir . '/customize-style-*.css' ) );

		$created_at = time();

		// Create Theme css file
		if ( ! $filesystem->exists( $theme_css_file ) ) {
			$filesystem->touch( $theme_css_file, $created_at );
		}

		if ( $filesystem->put_contents( $theme_css_file, $styles, 0644 ) ) {
			return array(
				'name'    => $css_file_name,
				'path'    => $theme_css_file,
				'url'     => $assets_dir['url'] . '/css/' . $css_file_name,
				'created' => $created_at,
			);
		}

		return false;
	}

	/**
	 * Checks to see if the site has SSL enabled or not.
	 *
	 * @return bool
	 */
	public static function is_ssl() {
		if ( is_ssl() ) {
			return true;
		} elseif ( 0 === stripos( get_option( 'siteurl' ), 'https://' ) ) {
			return true;
		} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
			return true;
		}

		return false;
	}
}