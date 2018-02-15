<?php
/**
 * Customizer Control: dimensions.
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

if ( ! class_exists( 'Shapla_Dimensions_Customize_Control' ) ) {
	/**
	 * Dimensions control.
	 * multiple fields with CSS units validation.
	 */
	class Shapla_Dimensions_Customize_Control extends Shapla_Customize_Control {
		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'shapla-dimensions';

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @see WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();

			if ( is_array( $this->choices ) ) {
				foreach ( $this->choices as $choice => $value ) {
					if ( 'labels' !== $choice && true === $value ) {
						$this->json['choices'][ $choice ] = true;
					}
				}
			}
			if ( is_array( $this->json['default'] ) ) {
				foreach ( $this->json['default'] as $key => $value ) {
					if ( isset( $this->json['choices'][ $key ] ) && ! isset( $this->json['value'][ $key ] ) ) {
						$this->json['value'][ $key ] = $value;
					}
				}
			}
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
            <label>
                <# if ( data.label ) { #>
                <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
                <div class="wrapper">
                    <div class="control">
                        <# for ( choiceKey in data.default ) { #>
                        <div class="{{ choiceKey }}">
                            <h5>
                                <# if ( ! _.isUndefined( data.choices.labels ) && ! _.isUndefined( data.choices.labels[
                                choiceKey ] ) ) { #>
                                {{ data.choices.labels[ choiceKey ] }}
                                <# } else if ( ! _.isUndefined( data.l10n[ choiceKey ] ) ) { #>
                                {{ data.l10n[ choiceKey ] }}
                                <# } else { #>
                                {{ choiceKey }}
                                <# } #>
                            </h5>
                            <div class="{{ choiceKey }} input-wrapper">
                                <input {{{ data.inputAttrs }}} type="text" value="{{ data.value[ choiceKey ] }}"/>
                            </div>
                        </div>
                        <# } #>
                    </div>
                </div>
            </label>
			<?php
		}

		/**
		 * Returns an array of translation strings.
		 *
		 * @access protected
		 * @return array
		 */
		protected function l10n() {
			return array(
				'left-top'       => esc_attr__( 'Left Top', 'shapla' ),
				'left-center'    => esc_attr__( 'Left Center', 'shapla' ),
				'left-bottom'    => esc_attr__( 'Left Bottom', 'shapla' ),
				'right-top'      => esc_attr__( 'Right Top', 'shapla' ),
				'right-center'   => esc_attr__( 'Right Center', 'shapla' ),
				'right-bottom'   => esc_attr__( 'Right Bottom', 'shapla' ),
				'center-top'     => esc_attr__( 'Center Top', 'shapla' ),
				'center-center'  => esc_attr__( 'Center Center', 'shapla' ),
				'center-bottom'  => esc_attr__( 'Center Bottom', 'shapla' ),
				'font-size'      => esc_attr__( 'Font Size', 'shapla' ),
				'font-weight'    => esc_attr__( 'Font Weight', 'shapla' ),
				'line-height'    => esc_attr__( 'Line Height', 'shapla' ),
				'font-style'     => esc_attr__( 'Font Style', 'shapla' ),
				'letter-spacing' => esc_attr__( 'Letter Spacing', 'shapla' ),
				'word-spacing'   => esc_attr__( 'Word Spacing', 'shapla' ),
				'top'            => esc_attr__( 'Top', 'shapla' ),
				'bottom'         => esc_attr__( 'Bottom', 'shapla' ),
				'left'           => esc_attr__( 'Left', 'shapla' ),
				'right'          => esc_attr__( 'Right', 'shapla' ),
				'center'         => esc_attr__( 'Center', 'shapla' ),
				'size'           => esc_attr__( 'Size', 'shapla' ),
				'height'         => esc_attr__( 'Height', 'shapla' ),
				'spacing'        => esc_attr__( 'Spacing', 'shapla' ),
				'width'          => esc_attr__( 'Width', 'shapla' ),
				'invalid-value'  => esc_attr__( 'Invalid Value', 'shapla' ),
			);
		}
	}
}