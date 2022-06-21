<?php

namespace Shapla\Customize;

use Shapla\Helpers\Sanitize;

defined( 'ABSPATH' ) || exit;

/**
 * Customize config class
 */
class BaseConfig {
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
	protected static $fields = array();

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
	 * @param array  $panel Panel arguments
	 */
	public static function set_panel( $id, array $panel ) {
		self::$panels[ $id ] = wp_parse_args(
			$panel,
			array(
				'title'       => '',
				'description' => '',
				'priority'    => 30,
				'capability'  => static::$setting['capability'],
			) 
		);
	}

	/**
	 * Set multiple panels
	 *
	 * @param array $panels List of panels
	 *
	 * @return void
	 */
	public static function set_panels( array $panels ) {
		foreach ( $panels as $panel_id => $settings ) {
			self::set_panel( $panel_id, $settings );
		}
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
	 * @param array  $section Section arguments
	 */
	public static function set_section( $id, array $section ) {
		self::$sections[ $id ] = wp_parse_args(
			$section,
			array(
				'title'       => '',
				'description' => '',
				'priority'    => 30,
				'panel'       => '',
			) 
		);
	}

	/**
	 * Set sections
	 *
	 * @param array $sections List of sections.
	 *
	 * @return void
	 */
	public static function set_sections( array $sections ) {
		foreach ( $sections as $id => $section ) {
			self::set_section( $id, $section );
		}
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
	 * @param array  $field Field arguments
	 */
	public static function set_field( $id, array $field ) {
		$_field = wp_parse_args(
			$field,
			array(
				'default'     => '',
				'transport'   => 'refresh',
				'label'       => '',
				'description' => '',
				'section'     => '',
				'priority'    => 10,
				'type'        => 'text',
				'choices'     => array(),
				'input_attrs' => array(),
			) 
		);

		$_field['settings']          = $id;
		$_field['sanitize_callback'] = static::get_sanitize_callback( $field );

		self::$fields[ $id ] = $_field;
	}

	/**
	 * Set fields
	 *
	 * @param array $fields List of fields
	 *
	 * @return void
	 */
	public static function set_fields( array $fields ) {
		foreach ( $fields as $id => $field ) {
			self::set_field( $id, $field );
		}
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

		$methods = array(
			'typography'  => array( Sanitize::class, 'typography' ),
			'background'  => array( Sanitize::class, 'background' ),
			'number'      => array( Sanitize::class, 'number' ),
			'image'       => array( Sanitize::class, 'url' ),
			'url'         => array( Sanitize::class, 'url' ),
			'email'       => array( Sanitize::class, 'email' ),
			'checkbox'    => array( Sanitize::class, 'checked' ),
			'textarea'    => array( Sanitize::class, 'html' ),
			'alpha_color' => array( Sanitize::class, 'color' ),
			'color'       => array( Sanitize::class, 'color' ),
		);

		if ( isset( $methods[ $type ] ) ) {
			return $methods[ $type ];
		}

		return array( Sanitize::class, 'text' );
	}
}
