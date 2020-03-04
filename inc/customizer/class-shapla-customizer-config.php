<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Shapla_Customizer_Config {

	/**
	 * Customize panels
	 *
	 * @var array
	 */
	protected static $panels = array();

	/**
	 * Customize sections
	 *
	 * @var array
	 */
	protected static $sections = array();

	/**
	 * Customize fields
	 *
	 * @var array
	 */
	protected static $fields = [];

	/**
	 * Customize settings configuration
	 *
	 * @var array
	 */
	protected static $setting = array(
		'option_type' => 'theme_mod',
		'capability'  => 'edit_theme_options',
	);

	/**
	 * @return array
	 */
	public static function get_panels() {
		return self::$panels;
	}

	/**
	 * Set customize panel
	 *
	 * @param string $id Unique id for panel
	 * @param array $panel Panel arguments
	 */
	public static function set_panel( $id, array $panel ) {
		self::$panels[ $id ] = wp_parse_args( $panel, [
			'title'       => '',
			'description' => '',
			'priority'    => 30,
			'capability'  => static::$setting['capability'],
		] );
	}

	/**
	 * @param string $id
	 * @param array $panel
	 */
	public static function add_panel( $id, array $panel ) {
		static::set_panel( $id, $panel );
	}

	/**
	 * Get customize sections
	 *
	 * @return array
	 */
	public static function get_sections() {
		return self::$sections;
	}

	/**
	 * Set customize section
	 *
	 * @param string $id Unique id for section
	 * @param array $section Section arguments
	 */
	public static function set_section( $id, array $section ) {
		self::$sections[ $id ] = wp_parse_args( $section, [
			'title'       => '',
			'description' => '',
			'priority'    => 30,
			'panel'       => '',
		] );
	}

	/**
	 * @param string $id
	 * @param array $section
	 */
	public static function add_section( $id, array $section ) {
		static::set_section( $id, $section );
	}

	/**
	 * Get customize fields
	 *
	 * @return array
	 */
	public static function get_fields() {
		return self::$fields;
	}

	/**
	 * Set customize field
	 *
	 * @param string $id Unique id for field
	 * @param array $field Field arguments
	 */
	public static function set_field( $id, array $field ) {
		$_field = wp_parse_args( $field, [
			'default'     => '',
			'transport'   => 'refresh',
			'label'       => '',
			'description' => '',
			'section'     => '',
			'priority'    => 10,
			'type'        => 'text',
			'choices'     => [],
			'input_attrs' => [],
		] );

		$_field['settings']          = $id;
		$_field['sanitize_callback'] = static::get_sanitize_callback( $field );

		self::$fields[ $id ] = $_field;
	}

	/**
	 * @param string $id
	 * @param array $field
	 */
	public static function add_field( $id, array $field ) {
		static::set_field( $id, $field );
	}


	/**
	 * Get customize sanitize method
	 *
	 * @param array $field
	 *
	 * @return array|string
	 */
	public static function get_sanitize_callback( array $field ) {
		if ( isset( $field['sanitize_callback'] ) && is_callable( $field['sanitize_callback'] ) ) {
			return $field['sanitize_callback'];
		}

		$type = isset( $field['type'] ) ? $field['type'] : 'text';
		$type = str_replace( '-', '_', $type );

		$methods = [
			'typography'  => [ Shapla_Sanitize::class, 'typography' ],
			'background'  => [ Shapla_Sanitize::class, 'background' ],
			'number'      => [ Shapla_Sanitize::class, 'number' ],
			'image'       => [ Shapla_Sanitize::class, 'url' ],
			'url'         => [ Shapla_Sanitize::class, 'url' ],
			'email'       => [ Shapla_Sanitize::class, 'email' ],
			'checkbox'    => [ Shapla_Sanitize::class, 'checked' ],
			'textarea'    => [ Shapla_Sanitize::class, 'html' ],
			'alpha_color' => [ Shapla_Sanitize::class, 'color' ],
			'color'       => [ Shapla_Sanitize::class, 'color' ],
		];

		if ( isset( $methods[ $type ] ) ) {
			return $methods[ $type ];
		}

		return [ Shapla_Sanitize::class, 'text' ];
	}
}
