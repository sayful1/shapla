<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Shapla_Customize_Control extends WP_Customize_Control {

	/**
	 * Control's Type.
	 * @var string
	 */
	public $type = 'text';

	/**
	 * Enqueue scripts and styles for the custom control.
	 *
	 * Scripts are hooked at {@see 'customize_controls_enqueue_scripts'}.
	 *
	 * Note, you can also enqueue stylesheets here as well. Stylesheets are hooked
	 * at 'customize_controls_print_styles'.
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script(
			'alpha-color-picker',
			get_template_directory_uri() . '/assets/libs/alpha-color-picker/alpha-color-picker.js',
			array( 'jquery', 'wp-color-picker' ),
			'1.0.0',
			true
		);
		wp_enqueue_style(
			'alpha-color-picker',
			get_template_directory_uri() . '/assets/css/customizer.css',
			array( 'wp-color-picker' ),
			'1.0.0'
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {
		parent::to_json();
	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
	 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 */
	protected function render_content() {
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Control::to_json().
	 *
	 * @see WP_Customize_Control::print_template()
	 */
	protected function content_template() {
	}
}