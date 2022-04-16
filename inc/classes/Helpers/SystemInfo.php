<?php

namespace Shapla\Helpers;

class SystemInfo {
	/**
	 * @return string[]
	 */
	public static function all() {
		return [
			'server_id'    => static::get_server_ip(),
			'host_name'    => static::get_host_name(),
			'gd_extension' => static::get_gd_extension_info(),
		];
	}

	/**
	 * Get server environment
	 *
	 * @return array
	 */
	public static function get_server_environment() {
		return [
			'os'                 => static::get_os(),
			'server_software'    => static::get_server_software(),
			'server_id'          => static::get_server_ip(),
			'host_name'          => static::get_host_name(),
			'php_version'        => static::get_php_version(),
			'database_version'   => static::get_database_version(),
			'max_post_size'      => static::get_php_max_post_size(),
			'max_execution_time' => static::get_php_time_limit(),
			'max_input_vars'     => static::get_max_input_vars(),
			'max_upload_size'    => static::get_max_upload_size(),
			'gd_library'         => static::get_gd_extension_info(),
		];
	}

	/**
	 * Get WordPress environment
	 *
	 * @return array
	 */
	public static function get_wordpress_environment() {
		return [
			'permalink_structure' => static::get_permalink_structure(),
			'timezone_string'     => static::get_timezone_string(),
		];
	}

	/**
	 * Get server IP address
	 *
	 * @return string
	 */
	public static function get_server_ip() {
		$server_ip = '';
		if ( array_key_exists( 'SERVER_ADDR', $_SERVER ) ) {
			$server_ip = $_SERVER['SERVER_ADDR'];
		} elseif ( array_key_exists( 'LOCAL_ADDR', $_SERVER ) ) {
			$server_ip = $_SERVER['LOCAL_ADDR'];
		}

		return $server_ip;
	}

	/**
	 * Get Host Name
	 *
	 * @return string
	 */
	public static function get_host_name() {
		return gethostbyaddr( static::get_server_ip() );
	}

	/**
	 * Get gd extension info
	 *
	 * @return string
	 */
	public static function get_gd_extension_info() {
		$info = 'Not Installed';

		if ( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) {
			$gd_info = gd_info();
			$info    = isset( $gd_info['GD Version'] ) ? $gd_info['GD Version'] : 'Installed';
		}

		return $info;
	}

	/**
	 * Get operation system
	 *
	 * @return string
	 */
	public static function get_os() {
		return PHP_OS;
	}

	/**
	 * Get server info
	 *
	 * @return string
	 */
	public static function get_server_software() {
		return $_SERVER['SERVER_SOFTWARE'];
	}

	/**
	 * Get database version
	 *
	 * @return string
	 */
	public static function get_database_version() {
		return $GLOBALS['wpdb']->db_version();
	}

	/**
	 * Get php version
	 *
	 * @return string
	 */
	public static function get_php_version() {
		return phpversion();
	}

	/**
	 * Get php maximum post size
	 *
	 * @return string
	 */
	public static function get_php_max_post_size() {
		return size_format( wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) ) );
	}

	/**
	 * Get php time limit
	 *
	 * @return int
	 */
	public static function get_php_time_limit() {
		return wp_convert_hr_to_bytes( ini_get( 'max_execution_time' ) );
	}

	/**
	 * Get maximum input vars
	 *
	 * @return int
	 */
	public static function get_max_input_vars() {
		return wp_convert_hr_to_bytes( ini_get( 'max_input_vars' ) );
	}

	/**
	 * Get maximum upload size limit
	 *
	 * @return string
	 */
	public static function get_max_upload_size() {
		return size_format( wp_max_upload_size() );
	}

	/**
	 * Get Permalink Structure
	 *
	 * @return string
	 */
	public static function get_permalink_structure() {
		$permalink = $GLOBALS['wp_rewrite']->permalink_structure;

		return ! empty( $permalink ) ? $permalink : 'Plain';
	}

	/**
	 * Get timezone string
	 *
	 * @return string
	 */
	public static function get_timezone_string() {
		if ( function_exists( 'wp_timezone_string' ) ) {
			return wp_timezone_string();
		}
		$timezone_string = get_option( 'timezone_string' );

		if ( $timezone_string ) {
			return $timezone_string;
		}

		$offset  = (float) get_option( 'gmt_offset' );
		$hours   = (int) $offset;
		$minutes = ( $offset - $hours );

		$sign     = ( $offset < 0 ) ? '-' : '+';
		$abs_hour = abs( $hours );
		$abs_mins = abs( $minutes * 60 );

		return sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );
	}

	/**
	 * Get site url
	 *
	 * @return string
	 */
	public static function get_site_url() {
		return site_url();
	}

	/**
	 * Get home page url
	 *
	 * @return string
	 */
	public static function get_home_url() {
		return home_url();
	}

	/**
	 * Check if debug mode enabled
	 *
	 * @return bool
	 */
	public static function is_debug_mode() {
		return defined( 'WP_DEBUG' ) && WP_DEBUG;
	}

	/**
	 * Get site language
	 *
	 * @return string
	 */
	public static function get_site_language() {
		return get_bloginfo( 'language' );
	}

	/**
	 * Get WordPress version
	 *
	 * @return string
	 */
	public static function get_wordpress_version() {
		return get_bloginfo( 'version' );
	}

	/**
	 * Check if is multisite
	 *
	 * @return bool
	 */
	public static function is_multisite() {
		return is_multisite();
	}

	/**
	 * Check if cron is disabled
	 *
	 * @return bool
	 */
	public static function is_cron_disabled() {
		return defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON;
	}

	/**
	 * Get wordpress memory limit
	 *
	 * @return false|string
	 */
	public static function get_wordpress_memory_limit() {
		return size_format( wp_convert_hr_to_bytes( WP_MEMORY_LIMIT ) );
	}
}
