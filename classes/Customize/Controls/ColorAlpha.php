<?php
/**
 * Customize API: ColorAlpha class
 *
 * @package WordPress
 * @subpackage Customize
 */

namespace Shapla\Customize\Controls;

use WP_Customize_Color_Control;

/**
 * Customize Color Control class.
 *
 * @see WP_Customize_Control
 */
class ColorAlpha extends WP_Customize_Color_Control {

	/**
	 * Type.
	 *
	 * @var string
	 */
	public $type = 'color-alpha';

	/**
	 * @inheritDoc
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$args = array(
			'settings'    => $id,
			'label'       => isset( $args['label'] ) ? $args['label'] : '',
			'description' => isset( $args['description'] ) ? $args['description'] : '',
			'section'     => isset( $args['section'] ) ? $args['section'] : '',
			'priority'    => isset( $args['priority'] ) ? $args['priority'] : 10,
		);
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue scripts/styles for the color picker.
	 *
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script(
			'shapla-control-color-picker-alpha',
			SHAPLA_THEME_URI . '/assets/js/color-control.js',
			// We're including wp-color-picker for localized strings, nothing more.
			[
				'customize-controls',
				'wp-element',
				'wp-components',
				'jquery',
				'customize-base',
				'wp-color-picker'
			],
			'1.1',
			true
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['choices'] = $this->choices;
	}

	/**
	 * Empty JS template.
	 *
	 * @access public
	 * @return void
	 * @since 1.0.0
	 */
	public function content_template() {
	}
}
