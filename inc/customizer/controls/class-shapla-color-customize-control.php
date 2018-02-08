<?php
/**
 * Customizer Control: color.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Shapla_Color_Customize_Control' ) ) {
	/**
	 * Adds a color & color-alpha control
	 */
	class Shapla_Color_Customize_Control extends Shapla_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'shapla-color';

		/**
		 * Colorpicker palette
		 *
		 * @access public
		 * @var bool
		 */
		public $palette = array(
			'#000000', // black
			'#FFFFFF', // white
			'#9E9E9E', // grey
			'#2196F3', // blue
			'#4CAF50', // green
			'#FFC107', // amber
			'#009688', // teal
			'#F44336', // red
			'#E91E63', // pink
			'#9C27B0', // purple
		);

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			parent::enqueue();
			wp_enqueue_script(
				'alpha-color-picker',
				get_template_directory_uri() . '/assets/js/customize/color.js',
				array( 'jquery', 'wp-color-picker' ),
				'1.0.0',
				true
			);
		}


		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			parent::to_json();
			$this->json['palette']     = $this->palette;
			$this->json['alpha']    = 'true';
		}

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

            <div class="customize-control-content">
                <label>
                    <span class="screen-reader-text">{{{ data.label }}}</span>
                    <input type="text" {{{ data.inputAttrs }}}
                           data-palette="{{ data.palette }}"
                           data-default-color="{{ data.default }}"
                           data-alpha="{{ data.alpha }}"
                           value="{{ data.value }}"
                           class="shapla-color-control color-picker" {{{ data.link }}}/>
                </label>
            </div>
			<?php
		}
	}
}