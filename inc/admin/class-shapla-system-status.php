<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_System_Status' ) ) {

	class Shapla_System_Status {

		private static $instance;

		/**
		 * @return Shapla_System_Status
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Get server information
		 *
		 * @return array
		 */
		public static function server_environment() {
			global $wpdb;

			$server_ip = '';
			if ( array_key_exists( 'SERVER_ADDR', $_SERVER ) ) {
				$server_ip = $_SERVER['SERVER_ADDR'];
			} elseif ( array_key_exists( 'LOCAL_ADDR', $_SERVER ) ) {
				$server_ip = $_SERVER['LOCAL_ADDR'];
			}

			// GD library
			$gd_info = esc_attr__( 'Not Installed', 'shapla' );
			if ( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) {
				$gd_info  = esc_attr__( 'Installed', 'shapla' );
				$_gd_info = gd_info();
				if ( isset( $_gd_info['GD Version'] ) ) {
					$gd_info = $_gd_info['GD Version'];
				}
			}

			$info = array(
				array(
					'title' => esc_attr__( 'Operating System:', 'shapla' ),
					'desc'  => esc_attr__( 'Display server operating system.', 'shapla' ),
					'value' => esc_attr( PHP_OS ),
				),
				array(
					'title' => esc_attr__( 'Server info:', 'shapla' ),
					'desc'  => esc_attr__( 'Information about the web server that is currently hosting your site.', 'shapla' ),
					'value' => esc_attr( $_SERVER['SERVER_SOFTWARE'] ),
				),
				array(
					'title' => esc_attr__( 'Server IP Address:', 'shapla' ),
					'desc'  => esc_attr__( 'Information about server IP address for your site.', 'shapla' ),
					'value' => esc_attr( $server_ip ),
				),
				array(
					'title' => esc_attr__( 'Host Name:', 'shapla' ),
					'desc'  => esc_attr__( 'Information about server host name for your site.', 'shapla' ),
					'value' => esc_attr( gethostbyaddr( $server_ip ) ),
				),
				array(
					'title' => esc_attr__( 'MySQL Version:', 'shapla' ),
					'desc'  => esc_attr__( 'The version of MySQL installed on your hosting server.', 'shapla' ),
					'value' => esc_attr( $wpdb->db_version() ),
				),
				array(
					'title' => esc_attr__( 'PHP Version:', 'shapla' ),
					'desc'  => esc_attr__( 'The version of PHP installed on your hosting server.', 'shapla' ),
					'value' => esc_attr( phpversion() ),
				),
				array(
					'title' => esc_attr__( 'PHP Max Post Size:', 'shapla' ),
					'desc'  => esc_attr__( 'The largest file size that can be contained in one post.', 'shapla' ),
					'value' => esc_attr( size_format( wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) ) ) ),
				),
				array(
					'title' => esc_attr__( 'PHP Time Limit:', 'shapla' ),
					'desc'  => esc_attr__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups).', 'shapla' ),
					'value' => esc_attr( wp_convert_hr_to_bytes( ini_get( 'max_execution_time' ) ) ),
				),
				array(
					'title' => esc_attr__( 'PHP Max Input Vars:', 'shapla' ),
					'desc'  => esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'shapla' ),
					'value' => esc_attr( wp_convert_hr_to_bytes( ini_get( 'max_input_vars' ) ) ),
				),
				array(
					'title' => esc_attr__( 'Max Upload Size:', 'shapla' ),
					'desc'  => esc_attr__( 'The largest file size that can be uploaded to your WordPress installation.', 'shapla' ),
					'value' => esc_attr( size_format( wp_max_upload_size() ) ),
				),
				array(
					'title' => esc_attr__( 'GD Library:', 'shapla' ),
					'desc'  => esc_attr__( 'GD library is used to resize images and speed up your site\'s loading time.', 'shapla' ),
					'value' => esc_attr( $gd_info ),
				),
			);

			return $info;
		}

		/**
		 * Get WordPress environment information
		 *
		 * @return array
		 */
		public static function wp_environment() {
			global $wp_rewrite;

			// Permalink Structure
			$permalink = $wp_rewrite->permalink_structure;
			if ( ! $permalink ) {
				$permalink = 'Plain';
			}

			// Default Timezone
			$timezone = get_option( 'timezone_string' );
			if ( ! $timezone ) {
				$timezone = get_option( 'gmt_offset' );
			}

			$info = array(
				array(
					'title' => esc_attr__( 'Site URL:', 'shapla' ),
					'desc'  => esc_attr__( 'The root URL of your site.', 'shapla' ),
					'value' => esc_url_raw( site_url() ),
				),
				array(
					'title' => esc_attr__( 'Home URL:', 'shapla' ),
					'desc'  => esc_attr__( 'The URL of your site\'s homepage.', 'shapla' ),
					'value' => esc_url_raw( home_url() ),
				),
				array(
					'title' => esc_attr__( 'WP Version:', 'shapla' ),
					'desc'  => esc_attr__( 'The version of WordPress installed on your site.', 'shapla' ),
					'value' => get_bloginfo( 'version' ),
				),
				array(
					'title' => esc_attr__( 'WP Multisite:', 'shapla' ),
					'desc'  => esc_attr__( 'Whether or not you have WordPress Multisite enabled.', 'shapla' ),
					'value' => is_multisite() ? "&#10004;" : "&ndash;",
				),
				array(
					'title' => esc_attr__( 'WP cron:', 'shapla' ),
					'desc'  => esc_attr__( 'Displays whether or not WP Cron Jobs are enabled.', 'shapla' ),
					'value' => ! ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) ? "&#10004;" : "&ndash;",
				),
				array(
					'title' => esc_attr__( 'WP Memory Limit:', 'shapla' ),
					'desc'  => esc_attr__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'shapla' ),
					'value' => esc_attr( size_format( wp_convert_hr_to_bytes( WP_MEMORY_LIMIT ) ) ),
				),
				array(
					'title' => esc_attr__( 'Language:', 'shapla' ),
					'desc'  => esc_attr__( 'The current language used by WordPress. Default = English', 'shapla' ),
					'value' => esc_attr( get_bloginfo( 'language' ) ),
				),
				array(
					'title' => esc_attr__( 'Timezone:', 'shapla' ),
					'desc'  => esc_attr__( 'The current timezone used by WordPress.', 'shapla' ),
					'value' => esc_attr( $timezone ),
				),
				array(
					'title' => esc_attr__( 'Permalink Structure:', 'shapla' ),
					'desc'  => esc_attr__( 'The current URL structure for your permalink.', 'shapla' ),
					'value' => esc_attr( $permalink ),
				),
				array(
					'title' => esc_attr__( 'WP Debug Mode:', 'shapla' ),
					'desc'  => esc_attr__( 'Displays whether or not WordPress is in Debug Mode.', 'shapla' ),
					'value' => defined( 'WP_DEBUG' ) && WP_DEBUG ? '&#10004;' : '&ndash;',
				),
			);

			return $info;
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
			$plugins        = array_intersect_key( get_plugins(), array_flip( $active_plugins ) );

			return $plugins;
		}
	}
}