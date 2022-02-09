<?php

namespace Shapla\Metabox\Fields;

defined( 'ABSPATH' ) || exit;

abstract class Base {
	/**
	 * Field settings
	 *
	 * @var array
	 */
	protected $settings = [];

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * Render field
	 *
	 * @return string
	 */
	abstract public function render();

	/**
	 * Sanitize meta value
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function sanitize( $value ) {
		if ( is_null( $value ) || empty( $value ) ) {
			return $value;
		}
		if ( is_scalar( $value ) ) {
			if ( is_numeric( $value ) ) {
				return is_float( $value ) ? floatval( $value ) : intval( $value );
			}

			return sanitize_text_field( $value );
		}

		$sanitized_value = [];
		if ( is_array( $value ) ) {
			foreach ( $value as $index => $item ) {
				$sanitized_value[ $index ] = $this->sanitize( $item );
			}
		}

		return $sanitized_value;
	}

	/**
	 * Get setting
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public function get_setting( $key, $default = null ) {
		return isset( $this->settings[ $key ] ) ? $this->settings[ $key ] : $default;
	}

	/**
	 * Get settings
	 *
	 * @return array
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Set Settings
	 *
	 * @param array $settings
	 *
	 * @return static
	 */
	public function set_settings( $settings ) {
		$default        = [
			'type'        => 'text',
			'id'          => '',
			'section'     => 'default',
			'label'       => '',
			'description' => '',
			'priority'    => 10,
			'default'     => '',
			'choices'     => [],
			'field_class' => '',
			'label_class' => '',
		];
		$this->settings = wp_parse_args( $settings, $default );

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return static
	 */
	public function set_name( $name ) {
		if ( is_string( $name ) ) {
			$this->name = $name;
		}

		return $this;
	}

	/**
	 * Get value
	 *
	 * @return mixed
	 */
	public function get_value() {
		return $this->value;
	}

	/**
	 * Set value
	 *
	 * @param mixed $value
	 *
	 * @return static
	 */
	public function set_value( $value ) {
		$this->value = $value;

		return $this;
	}

	/**
	 * Generate input attribute
	 *
	 * @param bool $string
	 *
	 * @return array|string
	 */
	protected function build_attributes( $string = true ) {
		$input_type = $this->get_setting( 'type' );
		$attributes = array(
			'id'          => $this->get_setting( 'id' ),
			'class'       => $this->get_setting( 'field_class' ),
			'name'        => $this->get_name(),
			'placeholder' => $this->get_setting( 'placeholder' ),
		);

		if ( ! in_array( $input_type, array( 'textarea', 'select' ) ) ) {
			$attributes['type'] = $input_type;
		}

		if ( 'textarea' === $input_type ) {
			$attributes['rows'] = $this->get_setting( 'rows' );
		}

		if ( ! in_array( $input_type, array( 'textarea', 'file' ) ) ) {
			$attributes['autocomplete'] = $this->get_setting( 'autocomplete' );
		}

		if ( ! in_array( $input_type, array( 'textarea', 'file', 'password', 'select' ) ) ) {
			$attributes['value'] = $this->get_value();
		}

		if ( 'file' === $input_type ) {
			$attributes['accept'] = $this->get_setting( 'accept' );
		}

		if ( 'number' === $input_type ) {
			$attributes['max']  = $this->get_setting( 'max' );
			$attributes['min']  = $this->get_setting( 'min' );
			$attributes['step'] = $this->get_setting( 'step' );
		}

		if ( 'date' === $input_type ) {
			$attributes['max'] = $this->get_setting( 'max' );
			$attributes['min'] = $this->get_setting( 'min' );
		}

		if ( 'hidden' === $input_type ) {
			$attributes['spellcheck']   = false;
			$attributes['tabindex']     = '-1';
			$attributes['autocomplete'] = 'off';
		}

		if ( 'email' === $input_type || 'file' === $input_type ) {
			$attributes['multiple'] = $this->get_setting( 'multiple' );
		}

		if ( ! in_array( $input_type, array( 'hidden', 'image', 'submit', 'reset', 'button' ) ) ) {
			$attributes['required'] = $this->get_setting( 'required' );
		}

		if ( $string ) {
			return $this->array_to_attributes( $attributes );
		}

		return array_filter( $attributes );
	}

	/**
	 * Convert array to input attributes
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	protected function array_to_attributes( $attributes ) {
		$string = array_map( function ( $key, $value ) {
			if ( empty( $value ) && 'value' !== $key ) {
				return null;
			}
			if ( in_array( $key, array( 'required', 'checked', 'multiple' ) ) && $value ) {
				return $key;
			}

			// If boolean value
			if ( is_bool( $value ) ) {
				return sprintf( '%s="%s"', $key, $value ? 'true' : 'false' );
			}

			// If array value
			if ( is_array( $value ) ) {
				return sprintf( '%s="%s"', $key, implode( " ", $value ) );
			}

			// If string value
			return sprintf( '%s="%s"', $key, esc_attr( $value ) );

		}, array_keys( $attributes ), array_values( $attributes ) );

		return implode( ' ', array_filter( $string ) );
	}
}
