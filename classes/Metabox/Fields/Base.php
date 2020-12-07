<?php

namespace Shapla\Metabox\Fields;

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
			'field_class' => 'regular-text',
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
}
