<?php
/**
 * Customizer Control: radio-buttonset.
 *
 * This class incorporates code from the Kirki Customizer Framework
 *
 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
 * is licensed under the terms of the GNU GPL, Version 2 (or later).
 *
 * @link https://wordpress.org/plugins/kirki/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Shapla_Radio_Button_Customize_Control' ) ) {
	/**
	 * The radio image class.
	 */
	class Shapla_Radio_Button_Customize_Control extends Shapla_Customize_Control {

		/**
		 * Declare the control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'shapla-radio-buttonset';

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
            <# if ( data.label ) { #>
            <span class="customize-control-title">{{{ data.label }}}</span>
            <# } #>
            <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
            <div id="input_{{ data.id }}" class="buttonset">
                <# for ( key in data.choices ) { #>
                <input {{{ data.inputAttrs }}}
                       class="switch-input"
                       type="radio"
                       value="{{ key }}"
                       name="_customize-radio-button-{{{ data.id }}}"
                       id="{{ data.id }}{{ key }}" {{{ data.link }}}
                <# if ( key === data.value ) { #> checked="checked" <# } #>>
                <label class="switch-label switch-label-<# if ( key === data.value ) { #>on <# } else { #>off<# } #>"
                       for="{{ data.id }}{{ key }}">
                    {{ data.choices[ key ] }}
                </label>
                </input>
                <# } #>
            </div>
			<?php
		}
	}
}
