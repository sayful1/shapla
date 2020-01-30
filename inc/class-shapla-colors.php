<?php

defined( 'ABSPATH' ) || exit;

class Shapla_Colors {

	/**
	 * List of default colors
	 *
	 * @var array
	 */
	protected static $default_colors = [
		'primary'   => '#00d1b2',
		'secondary' => '#3273dc',
		'success'   => '#48c774',
		'error'     => '#f14668',
		'surface'   => '#ffffff',
	];

	/**
	 * List of all colors
	 *
	 * @var array
	 */
	protected static $colors = [];

	/**
	 * Check if color has been read already
	 *
	 * @var bool
	 */
	protected static $read = false;

	/**
	 * Get default color
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public static function get_default_color( $name ) {
		return isset( self::$default_colors[ $name ] ) ? self::$default_colors[ $name ] : '';
	}

	/**
	 * Get color option
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public static function get_color_option( $name ) {
		$default     = static::get_default_color( $name );
		$option_name = sprintf( 'shapla_%s_color', $name );

		return get_theme_mod( $option_name, $default );
	}

	/**
	 * Calculate colors for site
	 */
	public static function calculate_colors() {
		if ( static::$read ) {
			return;
		}
		self::$colors['primary']         = static::get_color_option( 'primary' );
		self::$colors['primary-variant'] = shapla_adjust_color_brightness( self::$colors['primary'], - 25 );
		self::$colors['on-primary']      = shapla_find_color_invert( self::$colors['primary'] );
		list( $r, $g, $b ) = shapla_find_rgb_color( self::$colors['primary'] );
		self::$colors['primary-alpha'] = sprintf( "rgba(%s, %s, %s, 0.25)", $r, $g, $b );

		$secondary                         = static::get_color_option( 'secondary' );
		self::$colors['secondary']         = ! empty( $secondary ) ? $secondary : self::$colors['primary'];
		self::$colors['secondary-variant'] = shapla_adjust_color_brightness( self::$colors['secondary'], - 25 );
		self::$colors['on-secondary']      = shapla_find_color_invert( self::$colors['secondary'] );
		list( $r, $g, $b ) = shapla_find_rgb_color( self::$colors['secondary'] );
		self::$colors['secondary-alpha'] = sprintf( "rgba(%s, %s, %s, 0.25)", $r, $g, $b );

		self::$colors['success']    = static::get_color_option( 'success' );
		self::$colors['on-success'] = shapla_find_color_invert( self::$colors['success'] );
		list( $r, $g, $b ) = shapla_find_rgb_color( self::$colors['success'] );
		self::$colors['success-alpha'] = sprintf( "rgba(%s, %s, %s, 0.25)", $r, $g, $b );

		self::$colors['error']    = static::get_color_option( 'error' );
		self::$colors['on-error'] = shapla_find_color_invert( self::$colors['error'] );
		list( $r, $g, $b ) = shapla_find_rgb_color( self::$colors['error'] );
		self::$colors['error-alpha'] = sprintf( "rgba(%s, %s, %s, 0.25)", $r, $g, $b );

		self::$colors['surface']    = static::get_color_option( 'surface' );
		self::$colors['on-surface'] = shapla_find_color_invert( self::$colors['surface'] );
		list( $r, $g, $b ) = shapla_find_rgb_color( self::$colors['on-surface'] );

		self::$colors['background'] = self::$colors['surface'];

		self::$colors['text-primary']   = sprintf( "rgba(%s, %s, %s, 0.87)", $r, $g, $b );
		self::$colors['text-secondary'] = sprintf( "rgba(%s, %s, %s, 0.54)", $r, $g, $b );
		self::$colors['text-hint']      = sprintf( "rgba(%s, %s, %s, 0.38)", $r, $g, $b );
		self::$colors['text-disabled']  = sprintf( "rgba(%s, %s, %s, 0.38)", $r, $g, $b );
		self::$colors['text-icon']      = sprintf( "rgba(%s, %s, %s, 0.38)", $r, $g, $b );

		static::$read = true;
	}

	/**
	 * Get colors
	 *
	 * @return array
	 */
	public static function get_colors() {
		static::calculate_colors();

		return self::$colors;
	}

	/**
	 * Get color by name
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public static function get_color( $name ) {
		$colors = static::get_colors();

		return isset( $colors[ $name ] ) ? $colors[ $name ] : '';
	}
}
