<?php

namespace Shapla\Helpers;

/**
 * A simple wrapper class of static methods sanitizing value.
 */
class Sanitize {

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
	public static function int_number( $value ) {
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
		$units = array(
			'rem',
			'em',
			'ex',
			'%',
			'px',
			'cm',
			'mm',
			'in',
			'pt',
			'pc',
			'ch',
			'vh',
			'vw',
			'vmin',
			'vmax',
		);
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
	 * @param string $value
	 *
	 * @return string
	 */
	public static function color( $value ) {
		// If the value is empty, then return empty.
		if ( '' === $value || ! is_string( $value ) ) {
			return '';
		}

		// Trim unneeded whitespace.
		$value = str_replace( ' ', '', $value );

		// This pattern will check and match 3/6/8-character hex, rgb, rgba, hsl, & hsla colors.
		$pattern  = '/^(\#[\da-f]{3}|\#[\da-f]{6}|\#[\da-f]{8}|';
		$pattern .= 'rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|';
		$pattern .= 'hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|';
		$pattern .= 'rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)\)|';
		$pattern .= 'hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/';

		// Return the 1st match found.
		if ( 1 === preg_match( $pattern, $value ) ) {
			return $value;
		}

		// If no match was found, return an empty string.
		return '';
	}

	/**
	 * Sanitize email
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	public static function email( $value ) {
		return sanitize_email( $value );
	}

	/**
	 * Sanitize url
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	public static function url( $value ) {
		return esc_url_raw( $value );
	}

	/**
	 * Sanitizes a string
	 * - Checks for invalid UTF-8,
	 * - Converts single `<` characters to entities
	 * - Strips all tags
	 * - Removes line breaks, tabs, and extra whitespace
	 * - Strips octets
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	public static function text( $value ) {
		return sanitize_text_field( $value );
	}

	/**
	 * Sanitizes a multiline string
	 * The function is like sanitize_text_field(), but preserves
	 * new lines (\n) and other whitespace, which are legitimate
	 * input in textarea elements.
	 *
	 * @param mixed $value
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
	 * @param mixed $value
	 *
	 * @return boolean
	 */
	public static function checked( $value ) {
		return in_array( $value, array( 'yes', 'on', '1', 1, true, 'true' ), true );
	}

	/**
	 * Sanitize short block html input
	 *
	 * @param $value
	 *
	 * @return string
	 */
	public static function html( $value ) {
		return wp_kses_post( $value );
	}

	/**
	 * Sanitize a value from a list of allowed values.
	 *
	 * @param mixed  $input
	 * @param object $setting
	 *
	 * @return mixed
	 */
	public static function customize_choices( $input, $setting ) {
		// get the list of possible select options
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// return input if valid or return default option
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Sanitize background control
	 *
	 * @param $value
	 *
	 * @return array
	 */
	public static function background( $value ) {
		if ( ! is_array( $value ) ) {
			return array();
		}

		return array(
			'background-color'      => ( isset( $value['background-color'] ) ) ? esc_attr( $value['background-color'] ) : '',
			'background-image'      => ( isset( $value['background-image'] ) ) ? esc_url_raw( $value['background-image'] ) : '',
			'background-repeat'     => ( isset( $value['background-repeat'] ) ) ? esc_attr( $value['background-repeat'] ) : '',
			'background-position'   => ( isset( $value['background-position'] ) ) ? esc_attr( $value['background-position'] ) : '',
			'background-size'       => ( isset( $value['background-size'] ) ) ? esc_attr( $value['background-size'] ) : '',
			'background-attachment' => ( isset( $value['background-attachment'] ) ) ? esc_attr( $value['background-attachment'] ) : '',
		);
	}

	/**
	 * Sanitizes typography controls
	 *
	 * @param array $value The value.
	 *
	 * @return array
	 */
	public static function typography( $value ) {

		if ( ! is_array( $value ) ) {
			return array();
		}

		foreach ( $value as $key => $val ) {
			switch ( $key ) {
				case 'font-family':
					$value['font-family']   = esc_attr( $val );
					$value['font-category'] = ShaplaFonts::get_google_font_category( $value['font-family'] );
					break;
				case 'font-weight':
					if ( isset( $value['variant'] ) ) {
						break;
					}
					$value['variant'] = $val;
					if ( isset( $value['font-style'] ) && 'italic' === $value['font-style'] ) {
						$value['variant'] = ( '400' !== $val || 400 !== $val ) ? $value['variant'] . 'italic' : 'italic';
					}
					break;
				case 'variant':
					// Use 'regular' instead of 400 for font-variant.
					$value['variant'] = ( 400 === $val || '400' === $val ) ? 'regular' : $val;
					// Get font-weight from variant.
					$value['font-weight'] = filter_var( $value['variant'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value['font-weight'] = ( 'regular' === $value['variant'] || 'italic' === $value['variant'] ) ? 400 : absint( $value['font-weight'] );
					// Get font-style from variant.
					if ( ! isset( $value['font-style'] ) ) {
						$value['font-style'] = ( false === strpos( $value['variant'], 'italic' ) ) ? 'normal' : 'italic';
					}
					break;
				case 'font-size':
				case 'letter-spacing':
				case 'word-spacing':
				case 'line-height':
					$value[ $key ] = self::css_dimension( $val );
					break;
				case 'text-align':
					if ( ! in_array( $val, array( 'inherit', 'left', 'center', 'right', 'justify' ), true ) ) {
						$value['text-align'] = 'inherit';
					}
					break;
				case 'text-transform':
					if ( ! in_array(
						$val,
						array(
							'none',
							'capitalize',
							'uppercase',
							'lowercase',
							'initial',
							'inherit',
						),
						true
					) ) {
						$value['text-transform'] = 'none';
					}
					break;
				case 'text-decoration':
					if ( ! in_array(
						$val,
						array(
							'none',
							'underline',
							'overline',
							'line-through',
							'initial',
							'inherit',
						),
						true
					) ) {
						$value['text-transform'] = 'none';
					}
					break;
				case 'color':
					$value['color'] = self::color( $val );
					break;
			} // End switch().
		} // End foreach().

		return $value;
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

	/**
	 * Sanitize mixed content
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public static function deep( $value ) {
		if ( is_null( $value ) || empty( $value ) ) {
			return $value;
		}
		if ( is_scalar( $value ) ) {
			if ( is_numeric( $value ) ) {
				return is_float( $value ) ? floatval( $value ) : intval( $value );
			}

			return static::text( $value );
		}

		$sanitized_value = array();
		if ( is_array( $value ) ) {
			foreach ( $value as $index => $item ) {
				$sanitized_value[ $index ] = static::deep( $item );
			}
		}

		return $sanitized_value;
	}
}
