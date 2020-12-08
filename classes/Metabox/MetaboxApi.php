<?php

namespace Shapla\Metabox;

defined( 'ABSPATH' ) || exit;

class MetaboxApi {
	/**
	 * Metabox config
	 *
	 * @var array
	 */
	protected $config = [];

	/**
	 * Metabox panels
	 *
	 * @var array
	 */
	protected $panels = [];

	/**
	 * Metabox sections
	 *
	 * @var array
	 */
	protected $sections = [];

	/**
	 * Metabox fields
	 *
	 * @var array
	 */
	protected $fields = [];

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
		$default = [
			'id'       => 'shapla_meta_box_options',
			'title'    => __( 'Page Options', 'shapla' ),
			'screen'   => 'page',
			'context'  => 'advanced',
			'priority' => 'low',
		];
		foreach ( $default as $key => $value ) {
			$this->config[ $key ] = isset( $config[ $key ] ) ? $config[ $key ] : $value;
		}

		return $this;
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
		$default        = [
			'id'          => '',
			'title'       => '',
			'description' => '',
			'class'       => '',
			'priority'    => 200,
		];
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
		$default          = [
			'id'          => '',
			'title'       => '',
			'description' => '',
			'panel'       => '',
			'priority'    => 200,
		];
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
		$default        = [
			'type'        => 'text',
			'id'          => '',
			'section'     => 'default',
			'label'       => '',
			'description' => '',
			'priority'    => 200,
			'default'     => '',
		];
		$this->fields[] = wp_parse_args( $options, $default );

		return $this;
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
		usort( $array_copy, function ( $a, $b ) {
			return $a['priority'] - $b['priority'];
		} );

		return $array_copy;
	}
}
