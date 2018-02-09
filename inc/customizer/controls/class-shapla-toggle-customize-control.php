<?php
/**
 * Customizer Control: toggle
 *
 * This class incorporates code from the Kirki Customizer Framework
 *
 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
 * is licensed under the terms of the GNU GPL, Version 2 (or later).
 *
 * @link https://wordpress.org/plugins/kirki/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Shapla_Toggle_Customize_Control' ) ) {
	class Shapla_Toggle_Customize_Control extends Shapla_Customize_Control {
		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'shapla-toggle';

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
                <input class="screen-reader-text" {{{ data.inputAttrs }}}
                       name="toggle_{{ data.id }}"
                       id="toggle_{{ data.id }}"
                       type="checkbox"
                       value="{{ data.value }}" {{{ data.link }}}
                <# if ( '1' == data.value ) { #> checked<# } #> hidden />
                <span class="switch"></span>
            </label>
			<?php
		}
	}
}