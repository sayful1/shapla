<?php

namespace Shapla\Helpers;

/**
 * Colors class
 */
class Colors {

	/**
	 * List of default colors
	 *
	 * @var array
	 */
	protected static $default_colors = array(
		'primary'        => '#0d6efd', // Blue color.
		'secondary'      => '#6c757d', // Gray 600 color.
		'success'        => '#198754', // Green color.
		'warning'        => '#ffc107', // Yellow color.
		'error'          => '#dc3545', // Red color.
		'surface'        => '#ffffff', // White color.
		'text_primary'   => '#000000de', // Black with 87 opacity.
		'text_secondary' => '#0000008a', // Black with 54 opacity.
		'text_tertiary'  => '#00000061', // Black with 38 opacity.
	);

	/**
	 * List of all colors
	 *
	 * @var array
	 */
	protected static $colors = array();

	/**
	 * List of colors for dark mode
	 *
	 * @var array
	 */
	protected static $dark_colors = array();

	/**
	 * Check if color has been read already
	 *
	 * @var bool
	 */
	protected static $read = false;

	/**
	 * Find RGB color from a color
	 *
	 * @param  string  $color
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
		if ( preg_match( '/^(\#[\da-f]{3}|\#[\da-f]{6}|\#[\da-f]{8})$/', $color ) ) {
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
	 *
	 * @link https://www.w3.org/TR/WCAG20-TECHS/G17.html#G17-tests
	 *
	 * @param  string  $color
	 *
	 * @return float|string
	 */
	public static function calculate_color_luminance( $color ) {
		$rgb_color = static::find_rgb_color( $color );

		if ( ! is_array( $rgb_color ) ) {
			return '';
		}

		$colors = array();
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
			// bright color, use dark font.
			return '#000000';
		} else {
			// dark color, use bright font.
			return '#ffffff';
		}
	}

	/**
	 * Adjust a hex color brightness
	 * Allows us to create hover styles for custom link colors
	 *
	 * @param  string  $color  color e.g. #111111.
	 * @param  integer  $steps  factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
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
	 * @param  string  $name
	 *
	 * @return string
	 */
	public static function get_default_color( $name ) {
		return self::$default_colors[ $name ] ?? '';
	}

	/**
	 * Get color option
	 *
	 * @param  string  $name
	 *
	 * @return string
	 */
	public static function get_color_option( $name ) {
		$default     = static::get_default_color( $name );
		$option_name = sprintf( 'shapla_%s_color', $name );

		return shapla_get_option( $option_name, $default );
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
		self::$colors['primary-rgb']   = sprintf( '%s, %s, %s', $r, $g, $b );
		self::$colors['primary-alpha'] = sprintf( 'rgba(%s, %s, %s, 0.25)', $r, $g, $b );

		$secondary                         = static::get_color_option( 'secondary' );
		self::$colors['secondary']         = ! empty( $secondary ) ? $secondary : self::$colors['primary'];
		self::$colors['secondary-variant'] = static::adjust_color_brightness( self::$colors['secondary'], - 25 );
		self::$colors['on-secondary']      = static::find_color_invert( self::$colors['secondary'] );
		list( $r, $g, $b ) = static::find_rgb_color( self::$colors['secondary'] );
		self::$colors['secondary-rgb']   = sprintf( '%s, %s, %s', $r, $g, $b );
		self::$colors['secondary-alpha'] = sprintf( 'rgba(%s, %s, %s, 0.25)', $r, $g, $b );

		self::$colors['success']    = static::get_color_option( 'success' );
		self::$colors['on-success'] = static::find_color_invert( self::$colors['success'] );
		list( $r, $g, $b ) = static::find_rgb_color( self::$colors['success'] );
		self::$colors['success-rgb']   = sprintf( '%s, %s, %s', $r, $g, $b );
		self::$colors['success-alpha'] = sprintf( 'rgba(%s, %s, %s, 0.25)', $r, $g, $b );

		self::$colors['error']    = static::get_color_option( 'error' );
		self::$colors['on-error'] = static::find_color_invert( self::$colors['error'] );
		list( $r, $g, $b ) = static::find_rgb_color( self::$colors['error'] );
		self::$colors['error-rgb']   = sprintf( '%s, %s, %s', $r, $g, $b );
		self::$colors['error-alpha'] = sprintf( 'rgba(%s, %s, %s, 0.25)', $r, $g, $b );

		self::$colors['surface']    = static::get_color_option( 'surface' );
		self::$colors['on-surface'] = static::find_color_invert( self::$colors['surface'] );

		self::$colors['white-rgb']         = '255, 255, 255';
		self::$colors['black-rgb']         = '0, 0, 0';
		self::$colors['background']        = '#ffffff';
		self::$colors['surface-secondary'] = '#f9f9fb';
		self::$colors['text-rgb']          = 'var(--shapla-black-rgb)';
		self::$colors['text-primary']      = 'rgba(var(--shapla-text-rgb), 0.87)';
		self::$colors['text-secondary']    = 'rgba(var(--shapla-text-rgb), 0.60)';
		self::$colors['text-tertiary']     = 'rgba(var(--shapla-text-rgb), 0.38)';
		self::$colors['border-color']      = 'rgba(var(--shapla-text-rgb), 0.12)';
		self::$colors['border-color-dark'] = 'rgba(var(--shapla-text-rgb), 0.38)';

		static::$read = true;
	}

	/**
	 * Get dark colors
	 *
	 * @return array
	 */
	public static function get_dark_colors(): array {
		if ( empty( static::$dark_colors ) ) {
			self::$dark_colors['background']        = '#121212';
			self::$dark_colors['surface']           = '#343434';
			self::$dark_colors['surface-secondary'] = '#4e4e4e';
			self::$dark_colors['text-rgb']          = 'var(--shapla-white-rgb)';
		}

		return static::$dark_colors;
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

	public static function get_dark_color_scheme_css(): string {
		$style = '<style id="shapla-color-scheme-dark-css" type="text/css">' . PHP_EOL;
		$style .= '@media (prefers-color-scheme: dark) {:root:not(.light) {' . PHP_EOL;
		foreach ( static::get_dark_colors() as $key => $color ) {
			$style .= '--shapla-' . $key . ':' . $color . ';';
		}
		$style .= '}}' . PHP_EOL;
		$style .= ':root.dark {' . PHP_EOL;
		foreach ( static::get_dark_colors() as $key => $color ) {
			$style .= '--shapla-' . $key . ':' . $color . ';';
		}
		$style .= '</style>' . PHP_EOL;

		return $style;
	}

	public static function get_color_scheme_css(): string {
		$style = '<style id="shapla-color-scheme-css" type="text/css">' . PHP_EOL;
		$style .= ':root {';
		foreach ( static::get_colors() as $key => $color ) {
			$style .= '--shapla-' . $key . ':' . $color . ';';
		}
		$style .= '}' . PHP_EOL;
		$style .= '</style>' . PHP_EOL;

		return $style;
	}

	/**
	 * Get color by name
	 *
	 * @param  string  $name
	 *
	 * @return string
	 */
	public static function get_color( $name ) {
		$colors = static::get_colors();

		return $colors[ $name ] ?? '';
	}

	/**
	 * Customize colors settings
	 *
	 * @return array
	 */
	public static function customizer_colors_settings() {
		return array(
			'shapla_primary_color'        => array(
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Primary Color', 'shapla' ),
				'description' => __(
					'A primary color is the color displayed most frequently across your site.',
					'shapla'
				),
				'default'     => static::get_default_color( 'primary' ),
				'priority'    => 10,
			),
			'shapla_secondary_color'      => array(
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Secondary Color', 'shapla' ),
				'description' => __( 'Color for Links, Actions buttons, Highlighting text', 'shapla' ),
				'default'     => static::get_default_color( 'secondary' ),
				'priority'    => 20,
			),
			'shapla_success_color'        => array(
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Success Color', 'shapla' ),
				'description' => __( 'Color for success in components.', 'shapla' ),
				'default'     => static::get_default_color( 'success' ),
				'priority'    => 30,
			),
			'shapla_error_color'          => array(
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Error Color', 'shapla' ),
				'description' => __( 'Color for error in components.', 'shapla' ),
				'default'     => static::get_default_color( 'error' ),
				'priority'    => 40,
			),
			'shapla_surface_color'        => array(
				'type'        => 'color',
				'section'     => 'theme_colors',
				'label'       => __( 'Surface Color', 'shapla' ),
				'description' => __( 'Color for surfaces of components such as cards, modal.', 'shapla' ),
				'default'     => static::get_default_color( 'surface' ),
				'priority'    => 50,
			),
			'shapla_text_primary_color'   => array(
				'type'        => 'alpha-color',
				'section'     => 'theme_colors',
				'label'       => __( 'Text Primary Color', 'shapla' ),
				'description' => __( 'Used for most text.', 'shapla' ),
				'default'     => static::get_default_color( 'text_primary' ),
				'priority'    => 60,
			),
			'shapla_text_secondary_color' => array(
				'type'        => 'alpha-color',
				'section'     => 'theme_colors',
				'label'       => __( 'Text Secondary Color', 'shapla' ),
				'description' => __( 'Used for text which is lower in the visual hierarchy.', 'shapla' ),
				'default'     => static::get_default_color( 'text_secondary' ),
				'priority'    => 60,
			),
			'shapla_text_tertiary_color'  => array(
				'type'        => 'alpha-color',
				'section'     => 'theme_colors',
				'label'       => __( 'Text Tertiary Color', 'shapla' ),
				'description' => __( 'Used for text which is lower in the visual hierarchy.', 'shapla' ),
				'default'     => static::get_default_color( 'text_tertiary' ),
				'priority'    => 60,
			),
		);
	}
}
