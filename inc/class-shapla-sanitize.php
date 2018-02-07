<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A simple wrapper class for static methods.
 */
class Shapla_Sanitize {

	/**
	 * Sanitize number options.
	 *
	 * @param int|float|double|string $value The value to be sanitized.
	 *
	 * @return integer|double|string
	 */
	public static function number( $value ) {
		return ( is_numeric( $value ) ) ? $value : intval( $value );
	}

	/**
	 * Sanitize float number
	 *
	 * @param mixed $value
	 *
	 * @return float
	 */
	public static function float_number( $value ) {
		return floatval( $value );
	}

	/**
	 * Sanitize integer number
	 *
	 * @param mixed $value
	 *
	 * @return int
	 */
	function int_number( $value ) {
		return intval( $value );
	}

	/**
	 * Sanitizes css dimensions.
	 *
	 * @param string $value The value to be sanitized.
	 *
	 * @return string
	 */
	public static function css_dimension( $value ) {

		// Trim it.
		$value = trim( $value );

		// If the value is round, then return 50%.
		if ( 'round' === $value ) {
			$value = '50%';
		}

		// If the value is empty, return empty.
		if ( '' === $value ) {
			return '';
		}

		// If auto, inherit or initial, return the value.
		if ( 'auto' === $value || 'initial' === $value || 'inherit' === $value ) {
			return $value;
		}

		// Return empty if there are no numbers in the value.
		if ( ! preg_match( '#[0-9]#', $value ) ) {
			return '';
		}

		// If we're using calc() then return the value.
		if ( false !== strpos( $value, 'calc(' ) ) {
			return $value;
		}

		// The raw value without the units.
		$raw_value = self::filter_number( $value );
		$unit_used = '';

		// An array of all valid CSS units. Their order was carefully chosen for this evaluation, don't mix it up!!!
		$units = array( 'rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax' );
		foreach ( $units as $unit ) {
			if ( false !== strpos( $value, $unit ) ) {
				$unit_used = $unit;
			}
		}

		// Hack for rem values.
		if ( 'em' === $unit_used && false !== strpos( $value, 'rem' ) ) {
			$unit_used = 'rem';
		}

		return $raw_value . $unit_used;
	}

	/**
	 * Sanitizes a Hex, RGB or RGBA color
	 *
	 * @param  string $value
	 *
	 * @return string
	 */
	public static function color( $value ) {
		// If the value is empty, then return empty.
		if ( '' === $value ) {
			return '';
		}

		// If transparent, then return 'transparent'.
		if ( is_string( $value ) && 'transparent' === trim( $value ) ) {
			return 'transparent';
		}

		// Trim unneeded whitespace
		$value = str_replace( ' ', '', $value );

		// If this is hex color, validate and return it
		if ( 1 === preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $value ) ) {
			return $value;
		}

		// If this is rgb, validate and return it
		if ( 'rgb(' === substr( $value, 0, 4 ) ) {
			list( $red, $green, $blue ) = sscanf( $value, 'rgb(%d,%d,%d)' );

			if ( ( $red >= 0 && $red <= 255 ) && ( $green >= 0 && $green <= 255 ) && ( $blue >= 0 && $blue <= 255 ) ) {
				return "rgb({$red},{$green},{$blue})";
			}
		}

		// If this is rgba, validate and return it
		if ( 'rgba(' === substr( $value, 0, 5 ) ) {
			list( $red, $green, $blue, $alpha ) = sscanf( $value, 'rgba(%d,%d,%d,%f)' );

			if ( ( $red >= 0 && $red <= 255 ) && ( $green >= 0 && $green <= 255 ) && ( $blue >= 0 && $blue <= 255 ) &&
			     $alpha >= 0 && $alpha <= 1 ) {
				return "rgba({$red},{$green},{$blue},{$alpha})";
			}
		}

		// Not valid color, return empty string
		return '';
	}

	/**
	 * Sanitize email
	 *
	 * @param  mixed $value
	 *
	 * @return string
	 */
	public static function email( $value ) {
		return sanitize_email( $value );
	}

	/**
	 * Sanitize url
	 *
	 * @param  mixed $value
	 *
	 * @return string
	 */
	public static function url( $value ) {
		return esc_url_raw( $value );
	}

	/**
	 * Sanitizes a string
	 *
	 * - Checks for invalid UTF-8,
	 * - Converts single `<` characters to entities
	 * - Strips all tags
	 * - Removes line breaks, tabs, and extra whitespace
	 * - Strips octets
	 *
	 * @param  mixed $value
	 *
	 * @return string
	 */
	public static function text( $value ) {
		return sanitize_text_field( $value );
	}

	/**
	 * Sanitizes a multiline string
	 *
	 * The function is like sanitize_text_field(), but preserves
	 * new lines (\n) and other whitespace, which are legitimate
	 * input in textarea elements.
	 *
	 * @param  mixed $value
	 *
	 * @return string
	 */
	public static function textarea( $value ) {
		return _sanitize_text_fields( $value, true );
	}

	/**
	 * If a field has been 'checked' or not, meaning it contains
	 * one of the following values: 'yes', 'on', '1', 1, true, or 'true'.
	 * This can be used for determining if an HTML checkbox has been checked.
	 *
	 * @param  mixed $value
	 *
	 * @return boolean
	 */
	public static function checked( $value ) {
		return in_array( $value, [ 'yes', 'on', '1', 1, true, 'true' ], true );
	}

	/**
	 * Sanitize short block html input
	 *
	 * @param $value
	 *
	 * @return string
	 */
	public static function html( $value ) {
		$allowed_html = array(
			'div'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'span'   => array(
				'class' => array(),
				'id'    => array(),
			),
			'ol'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'ul'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'li'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'p'      => array(
				'class' => array(),
				'id'    => array(),
			),
			'a'      => array(
				'href'   => array(),
				'class'  => array(),
				'id'     => array(),
				'rel'    => array(),
				'title'  => array(),
				'target' => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
		);

		return wp_kses( $value, $allowed_html );
	}

	/**
	 * Filters numeric values.
	 *
	 * @param string $value The value to be sanitized.
	 *
	 * @return int|float
	 */
	public static function filter_number( $value ) {
		return filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	}
}