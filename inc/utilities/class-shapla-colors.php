<?php

defined( 'ABSPATH' ) || exit;

class Shapla_Colors {

	/**
	 * List of default colors
	 *
	 * @var array
	 */
	protected static $default_colors = [
		'primary'        => '#00d1b2',
		'secondary'      => '#3273dc',
		'success'        => '#48c774',
		'error'          => '#f14668',
		'surface'        => '#ffffff',
		'text_primary'   => 'rgba(0, 0, 0, 0.87)',
		'text_secondary' => 'rgba(0, 0, 0, 0.54)',
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
	 * Find RGB color from a color
	 *
	 * @param string $color
	 *
	 * @return string|array
	 */
	public static function find_rgb_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// Trim unneeded whitespace
		$color = str_replace( ' ', '', $color );

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			// Format the hex color string.
			$hex = str_replace( '#', '', $color );

			if ( 3 == strlen( $hex ) ) {
				$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) .
				       str_repeat( substr( $hex, 1, 1 ), 2 ) .
				       str_repeat( substr( $hex, 2, 1 ), 2 );
			}

			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );

			return array( $r, $g, $b, 1 );
		}

		// If this is rgb color
		if ( 'rgb(' === substr( $color, 0, 4 ) ) {
			list( $r, $g, $b ) = sscanf( $color, 'rgb(%d,%d,%d)' );

			return array( $r, $g, $b, 1 );
		}

		// If this is rgba color
		if ( 'rgba(' === substr( $color, 0, 5 ) ) {
			list( $r, $g, $b, $alpha ) = sscanf( $color, 'rgba(%d,%d,%d,%f)' );

			return array( $r, $g, $b, $alpha );
		}

		return '';
	}

	/**
	 * Calculate the luminance for a color.
	 * @link https://www.w3.org/TR/WCAG20-TECHS/G17.html#G17-tests
	 *
	 * @param string $color
	 *
	 * @return float|string
	 */
	public static function calculate_color_luminance( $color ) {
		$rgb_color = static::find_rgb_color( $color );

		if ( ! is_array( $rgb_color ) ) {
			return '';
		}

		$colors = [];
		list( $colors['red'], $colors['green'], $colors['blue'] ) = $rgb_color;

		foreach ( $colors as $name => $value ) {
			$value = $value / 255;
			if ( $value < 0.03928 ) {
				$value = $value / 12.92;
			} else {
				$value = ( $value + .055 ) / 1.055;
				$value = pow( $value, 2 );
			}

			$colors[ $name ] = $value;
		}

		return ( $colors['red'] * .2126 + $colors['green'] * .7152 + $colors['blue'] * .0722 );
	}

	/**
	 * Find light or dark color for given color
	 *
	 * @param $color
	 *
	 * @return string
	 */
	public static function find_color_invert( $color ) {
		$luminance = static::calculate_color_luminance( $color );

		if ( $luminance > 0.55 ) {
			//bright color, use dark font
			return '#000000';
		} else {
			//dark color, use bright font
			return '#ffffff';
		}
	}

	/**
	 * Adjust a hex color brightness
	 * Allows us to create hover styles for custom link colors
	 *
	 * @param string $color color e.g. #111111.
	 * @param integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
	 *
	 * @return string        brightened/darkened hex color
	 */
	public static function adjust_color_brightness( $color, $steps ) {
		// Steps should be between -255 and 255. Negative = darker, positive = lighter.
		$steps = max( - 255, min( 255, $steps ) );

		$rgb_color = static::find_rgb_color( $color );

		if ( ! is_array( $rgb_color ) ) {
			return '';
		}
		list( $r, $g, $b ) = $rgb_color;

		// Adjust number of steps and keep it inside 0 to 255.
		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );
		$b = max( 0, min( 255, $b + $steps ) );

		$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return '#' . $r_hex . $g_hex . $b_hex;
	}

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
	protected static function calculate_colors() {
		if ( static::$read && ! is_customize_preview() ) {
			return;
		}
		self::$colors['primary']         = static::get_color_option( 'primary' );
		self::$colors['primary-variant'] = static::adjust_color_brightness( self::$colors['primary'], - 25 );
		self::$colors['on-primary']      = static::find_color_invert( self::$colors['primary'] );
		list( $r, $g, $b ) = static::find_rgb_color( self::$colors['primary'] );
		self::$colors['primary-alpha'] = sprintf( "rgba(%s, %s, %s, 0.25)", $r, $g, $b );

		$secondary                         = static::get_color_option( 'secondary' );
		self::$colors['secondary']         = ! empty( $secondary ) ? $secondary : self::$colors['primary'];
		self::$colors['secondary-variant'] = static::adjust_color_brightness( self::$colors['secondary'], - 25 );
		self::$colors['on-secondary']      = static::find_color_invert( self::$colors['secondary'] );
		list( $r, $g, $b ) = static::find_rgb_color( self::$colors['secondary'] );
		self::$colors['secondary-alpha'] = sprintf( "rgba(%s, %s, %s, 0.25)", $r, $g, $b );

		self::$colors['success']    = static::get_color_option( 'success' );
		self::$colors['on-success'] = static::find_color_invert( self::$colors['success'] );
		list( $r, $g, $b ) = static::find_rgb_color( self::$colors['success'] );
		self::$colors['success-alpha'] = sprintf( "rgba(%s, %s, %s, 0.25)", $r, $g, $b );

		self::$colors['error']    = static::get_color_option( 'error' );
		self::$colors['on-error'] = static::find_color_invert( self::$colors['error'] );
		list( $r, $g, $b ) = static::find_rgb_color( self::$colors['error'] );
		self::$colors['error-alpha'] = sprintf( "rgba(%s, %s, %s, 0.25)", $r, $g, $b );

		self::$colors['surface']    = static::get_color_option( 'surface' );
		self::$colors['on-surface'] = static::find_color_invert( self::$colors['surface'] );

		self::$colors['background'] = self::$colors['surface'];

		self::$colors['text-primary']   = static::get_color_option( 'text_primary' );
		self::$colors['text-secondary'] = static::get_color_option( 'text_secondary' );

		list( $r, $g, $b ) = static::find_rgb_color( self::$colors['text-primary'] );

		self::$colors['text-hint']     = sprintf( "rgba(%s, %s, %s, 0.38)", $r, $g, $b );
		self::$colors['text-disabled'] = sprintf( "rgba(%s, %s, %s, 0.38)", $r, $g, $b );
		self::$colors['text-icon']     = sprintf( "rgba(%s, %s, %s, 0.38)", $r, $g, $b );

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

	/**
	 * Customize colors settings
	 *
	 * @return array
	 */
	public static function customizer_colors_settings() {
		return [
			'shapla_primary_color'        => [
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Primary Color', 'shapla' ),
				'description' => __( 'A primary color is the color displayed most frequently across your site.', 'shapla' ),
				'default'     => static::get_default_color( 'primary' ),
				'priority'    => 10,
			],
			'shapla_secondary_color'      => [
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Secondary Color', 'shapla' ),
				'description' => __( 'Color for Links, Actions buttons, Highlighting text', 'shapla' ),
				'default'     => static::get_default_color( 'secondary' ),
				'priority'    => 20,
			],
			'shapla_success_color'        => [
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Success Color', 'shapla' ),
				'description' => __( 'Color for success in components.', 'shapla' ),
				'default'     => static::get_default_color( 'success' ),
				'priority'    => 30,
			],
			'shapla_error_color'          => [
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Error Color', 'shapla' ),
				'description' => __( 'Color for error in components.', 'shapla' ),
				'default'     => static::get_default_color( 'error' ),
				'priority'    => 40,
			],
			'shapla_surface_color'        => [
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Surface Color', 'shapla' ),
				'description' => __( 'Color for surfaces of components such as cards, modal.', 'shapla' ),
				'default'     => static::get_default_color( 'surface' ),
				'priority'    => 50,
			],
			'shapla_text_primary_color'   => [
				'type'        => 'alpha-color',
				'section'     => 'theme_colors',
				'label'       => __( 'Text Primary Color', 'shapla' ),
				'description' => __( 'Used for most text.', 'shapla' ),
				'default'     => static::get_default_color( 'text_primary' ),
				'priority'    => 60,
			],
			'shapla_text_secondary_color' => [
				'type'        => 'alpha-color',
				'section'     => 'theme_colors',
				'label'       => __( 'Text Secondary Color', 'shapla' ),
				'description' => __( 'Used for text which is lower in the visual hierarchy.', 'shapla' ),
				'default'     => static::get_default_color( 'text_secondary' ),
				'priority'    => 60,
			],
		];
	}
}
