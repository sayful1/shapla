<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_System_Status' ) ) {

	class Shapla_System_Status {

		/**
		 * The instance of the class
		 *
		 * @var static
		 */
		private static $instance;

		/**
		 * Only one instance of the class can be loaded
		 *
		 * @return static
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Get html
		 *
		 * @return string
		 */
		public static function get_html() {
			$data = [
				[ 'section_title' => 'WordPress Environment', 'data' => static::wp_environment(), ],
				[ 'section_title' => 'Server Environment', 'data' => static::server_environment(), ],
				[ 'section_title' => 'Active Plugins', 'data' => static::active_plugins(), ],
			];

			$html = '';
			foreach ( $data as $item ) {
				$html .= '<table class="widefat table-shapla-system-status">';
				$html .= '<thead><tr><th colspan="3">' . esc_html( $item['section_title'] ) . '</th></tr></thead>';
				$html .= '<tbody>';
				foreach ( $item['data'] as $info ) {
					$html .= '<tr>';
					$html .= '<td>' . esc_html( $info['title'] ) . '</td>';
					if ( ! empty( $info['desc'] ) ) {
						$html .= '<td class="help">';
						$html .= '<a href="#" class="shapla-tooltip" data-tip="' . esc_attr( $info['desc'] ) . '">[?]</a>';
						$html .= '</td>';
					} else {
						$html .= '<td class="help"></td>';
					}
					$html .= '<td>' . esc_html( $info['value'] ) . '</td>';
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				$html .= '</table>';
			}

			return $html;
		}

		/**
		 * Get server information
		 *
		 * @return array
		 */
		public static function server_environment() {
			return [
				[
					'title' => 'Operating System:',
					'desc'  => 'Display server operating system.',
					'value' => Shapla_System_Info::get_os(),
				],
				[
					'title' => 'Server info:',
					'desc'  => 'Information about the web server that is currently hosting your site.',
					'value' => Shapla_System_Info::get_server_software(),
				],
				[
					'title' => 'Server IP Address:',
					'desc'  => 'Information about server IP address for your site.',
					'value' => Shapla_System_Info::get_server_ip(),
				],
				[
					'title' => 'Host Name:',
					'desc'  => 'Information about server host name for your site.',
					'value' => Shapla_System_Info::get_host_name(),
				],
				[
					'title' => 'MySQL Version:',
					'desc'  => 'The version of MySQL installed on your hosting server.',
					'value' => Shapla_System_Info::get_database_version(),
				],
				[
					'title' => 'PHP Version:',
					'desc'  => 'The version of PHP installed on your hosting server.',
					'value' => Shapla_System_Info::get_php_version(),
				],
				[
					'title' => 'PHP Max Post Size:',
					'desc'  => 'The largest file size that can be contained in one post.',
					'value' => Shapla_System_Info::get_php_max_post_size(),
				],
				[
					'title' => 'PHP Time Limit:',
					'desc'  => 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups).',
					'value' => Shapla_System_Info::get_php_time_limit(),
				],
				[
					'title' => 'PHP Max Input Vars:',
					'desc'  => 'The maximum number of variables your server can use for a single function to avoid overloads.',
					'value' => Shapla_System_Info::get_max_input_vars(),
				],
				[
					'title' => 'Max Upload Size:',
					'desc'  => 'The largest file size that can be uploaded to your WordPress installation.',
					'value' => Shapla_System_Info::get_max_upload_size(),
				],
				[
					'title' => 'GD Library:',
					'desc'  => 'GD library is used to resize images and speed up your site\'s loading time.',
					'value' => Shapla_System_Info::get_gd_extension_info()
				],
			];
		}

		/**
		 * Get WordPress environment information
		 *
		 * @return array
		 */
		public static function wp_environment() {
			return [
				[
					'title' => 'Site URL:',
					'desc'  => 'The root URL of your site.',
					'value' => esc_url_raw( Shapla_System_Info::get_site_url() ),
				],
				[
					'title' => 'Home URL:',
					'desc'  => 'The URL of your site\'s homepage.',
					'value' => esc_url_raw( Shapla_System_Info::get_home_url() ),
				],
				[
					'title' => 'WP Version:',
					'desc'  => 'The version of WordPress installed on your site.',
					'value' => Shapla_System_Info::get_wordpress_version(),
				],
				[
					'title' => 'WP Multisite:',
					'desc'  => 'Whether or not you have WordPress Multisite enabled.',
					'value' => Shapla_System_Info::is_multisite() ? "&#10004;" : "&ndash;",
				],
				[
					'title' => 'WP cron:',
					'desc'  => 'Displays whether or not WP Cron Jobs are enabled.',
					'value' => ! Shapla_System_Info::is_cron_disabled() ? "&#10004;" : "&ndash;",
				],
				[
					'title' => 'WP Memory Limit:',
					'desc'  => 'The maximum amount of memory (RAM) that your site can use at one time.',
					'value' => Shapla_System_Info::get_wordpress_memory_limit(),
				],
				[
					'title' => 'Language:',
					'desc'  => 'The current language used by WordPress. Default = English',
					'value' => Shapla_System_Info::get_site_language(),
				],
				[
					'title' => 'Timezone:',
					'desc'  => 'The current timezone used by WordPress.',
					'value' => Shapla_System_Info::get_timezone_string(),
				],
				[
					'title' => 'Permalink Structure:',
					'desc'  => 'The current URL structure for your permalink.',
					'value' => Shapla_System_Info::get_permalink_structure(),
				],
				[
					'title' => 'WP Debug Mode:',
					'desc'  => 'Displays whether or not WordPress is in Debug Mode.',
					'value' => Shapla_System_Info::is_debug_mode() ? '&#10004;' : '&ndash;',
				],
			];
		}

		/**
		 * Get WordPress theme information
		 *
		 * @return array
		 */
		public static function theme() {
			$theme        = wp_get_theme();
			$parent_theme = $theme->parent();
			$theme_info   = array(
				'Name'        => $theme->get( 'Name' ),
				'Version'     => $theme->get( 'Version' ),
				'Author'      => $theme->get( 'Author' ),
				'Child Theme' => is_child_theme() ? 'Yes' : 'No',
			);
			if ( $parent_theme ) {
				$parent_fields = array(
					'Parent Theme Name'    => $parent_theme->get( 'Name' ),
					'Parent Theme Version' => $parent_theme->get( 'Version' ),
					'Parent Theme Author'  => $parent_theme->get( 'Author' ),
				);
				$theme_info    = array_merge( $theme_info, $parent_fields );
			}

			return $theme_info;
		}

		/**
		 * Get active plugins list
		 *
		 * @return array
		 */
		public static function active_plugins() {

			// Ensure get_plugins function is loaded
			if ( ! function_exists( 'get_plugins' ) ) {
				include ABSPATH . '/wp-admin/includes/plugin.php';
			}

			$active_plugins = get_option( 'active_plugins' );

			$plugins = array_intersect_key( get_plugins(), array_flip( $active_plugins ) );
			$items   = [];
			foreach ( $plugins as $plugin ) {
				$items[] = [
					'title' => $plugin['Name'],
					'value' => sprintf( 'by %s - %s', $plugin['AuthorName'], $plugin['Version'] ),
				];
			}

			return $items;
		}
	}
}
