<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Shapla_Toggle_Customize_Control extends Shapla_Customize_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'shapla-toggle';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script(
			'shapla-toggle',
			get_template_directory_uri() . '/assets/js/customize/toggle.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
        <label for="toggle_{{ data.id }}">
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
            <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
            <input class="screen-reader-text" {{{ data.inputAttrs }}} name="toggle_{{ data.id }}"
                   id="toggle_{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' ==
            data.value ) { #> checked<# } #> hidden />
            <span class="switch"></span>
        </label>
		<?php
	}
}