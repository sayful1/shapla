<?php

namespace Shapla\Metabox;

use Shapla\Helpers\CssGenerator;

defined( 'ABSPATH' ) || exit;

class MetaboxApi {

	/**
	 * Metabox field name
	 *
	 * @var string
	 */
	protected $option_name = '_single_post_settings';

	/**
	 * Metabox config
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Metabox panels
	 *
	 * @var array
	 */
	protected $panels = array();

	/**
	 * Metabox sections
	 *
	 * @var array
	 */
	protected $sections = array();

	/**
	 * Metabox fields
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * @return array
	 */
	public function get_config() {
		return $this->config;
	}

	/**
	 * @param array $config
	 *
	 * @return static
	 */
	public function set_config( array $config ) {
		$default = array(
			'id'       => 'shapla_meta_box_options',
			'title'    => __( 'Page Options', 'shapla' ),
			'screen'   => 'page',
			'context'  => 'advanced',
			'priority' => 'low',
		);
		foreach ( $default as $key => $value ) {
			$this->config[ $key ] = isset( $config[ $key ] ) ? $config[ $key ] : $value;
		}

		return $this;
	}

	/**
	 * Get sections by panel
	 *
	 * @param string $panel
	 *
	 * @return array
	 */
	public function get_sections_by_panel( $panel ) {
		$sections = array();
		foreach ( $this->get_sections() as $section ) {
			if ( $section['panel'] == $panel ) {
				$sections[] = $section;
			}
		}

		return $sections;
	}

	/**
	 * Get fields by section
	 *
	 * @param string $section
	 *
	 * @return array
	 */
	public function get_fields_by_section( $section ) {
		$current_field = array();
		foreach ( $this->get_fields() as $field ) {
			if ( $field['section'] == $section ) {
				$current_field[] = $field;
			}
		}

		return $current_field;
	}

	/**
	 * @return array
	 */
	public function get_panels() {
		return $this->sort_by_priority( $this->panels );
	}

	/**
	 * @param array $panels
	 *
	 * @return static
	 */
	public function set_panels( array $panels ) {
		foreach ( $panels as $panel ) {
			$this->set_panel( $panel );
		}

		return $this;
	}

	/**
	 * Set panel
	 *
	 * @param array $options
	 *
	 * @return static
	 */
	public function set_panel( array $options ) {
		$default        = array(
			'id'          => '',
			'title'       => '',
			'description' => '',
			'class'       => '',
			'priority'    => 200,
		);
		$this->panels[] = wp_parse_args( $options, $default );

		return $this;
	}

	/**
	 * @return array
	 */
	public function get_sections() {
		return $this->sort_by_priority( $this->sections );
	}

	/**
	 * @param array $sections
	 *
	 * @return static
	 */
	public function set_sections( array $sections ) {
		foreach ( $sections as $section ) {
			$this->set_section( $section );
		}

		return $this;
	}

	/**
	 * Set section
	 *
	 * @param array $options
	 *
	 * @return static
	 */
	public function set_section( array $options ) {
		$default          = array(
			'id'          => '',
			'title'       => '',
			'description' => '',
			'panel'       => '',
			'priority'    => 200,
		);
		$this->sections[] = wp_parse_args( $options, $default );

		return $this;
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return $this->sort_by_priority( $this->fields );
	}

	/**
	 * @param array $fields
	 *
	 * @return static
	 */
	public function set_fields( array $fields ) {
		foreach ( $fields as $field ) {
			$this->set_field( $field );
		}

		return $this;
	}

	/**
	 * Set field
	 *
	 * @param array $options
	 *
	 * @return static
	 */
	public function set_field( array $options ) {
		$default        = array(
			'type'        => 'text',
			'id'          => '',
			'section'     => 'default',
			'label'       => '',
			'description' => '',
			'priority'    => 200,
			'default'     => '',
		);
		$this->fields[] = wp_parse_args( $options, $default );

		return $this;
	}

	/**
	 * Gets all our styles for current page and returns them as a string.
	 *
	 * @return string
	 */
	public function get_styles() {
		global $post;
		$fields = $this->get_fields();

		// Check if we need to exit early
		if ( empty( $fields ) || ! is_array( $fields ) ) {
			return '';
		}

		// initially we're going to format our styles as an array.
		// This is going to make processing them a lot easier
		// and make sure there are no duplicate styles etc.
		$css    = array();
		$values = get_post_meta( $post->ID, $this->option_name, true );

		// start parsing our fields
		foreach ( $fields as $field ) {
			// If no setting id, then exist
			if ( ! isset( $field['id'] ) ) {
				continue;
			}

			// Get the default value of this field
			$default = isset( $field['default'] ) ? $field['default'] : '';
			$value   = isset( $values[ $field['id'] ] ) ? $values[ $field['id'] ] : $default;

			CssGenerator::css( $css, $field, $value );
		}

		return CssGenerator::styles_parse( $css );
	}

	/**
	 * Sort by priority
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	protected function sort_by_priority( array $array ) {
		$array_copy = $array;
		usort(
			$array_copy,
			function ( $a, $b ) {
				return $a['priority'] - $b['priority'];
			} 
		);

		return $array_copy;
	}
}
