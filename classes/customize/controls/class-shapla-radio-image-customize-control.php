<?php
/**
 * Customizer Control: radio-image.
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

if ( ! class_exists( 'Shapla_Radio_Image_Customize_Control' ) ) {
	/**
	 * The radio image class.
	 */
	class Shapla_Radio_Image_Customize_Control extends Shapla_Customize_Control {

		/**
		 * Declare the control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'shapla-radio-image';

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
            <label class="customizer-text">
                <# if ( data.label ) { #>
                <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
            </label>
            <div id="input_{{ data.id }}" class="image">
                <# for ( key in data.choices ) { #>
                <input {{{ data.inputAttrs }}}
                       class="image-select"
                       type="radio"
                       value="{{ key }}"
                       name="_customize-radio-image-{{ data.id }}"
                       id="{{ data.id }}{{ key }}" {{{ data.link }}}
                <# if ( data.value === key ) { #> checked="checked"<# } #> >
                <label for="{{ data.id }}{{ key }}" class="image-item">
                    <img src="{{ data.choices[ key ] }}">
                    <span class="image-clickable"></span>
                </label>
                </input>
                <# } #>
            </div>
			<?php
		}
	}
}
