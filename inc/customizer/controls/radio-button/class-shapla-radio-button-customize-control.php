<?php
/**
 * Create a Radio-Button control
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

/**
 * The radio image class.
 */
class Shapla_Radio_Button_Customize_Control extends WP_Customize_Control {

	/**
	 * Declare the control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'radio-button';

	/**
	 * Enqueue scripts and styles for the custom control.
	 *
	 * Scripts are hooked at {@see 'customize_controls_enqueue_scripts'}.
	 *
	 * Note, you can also enqueue stylesheets here as well. Stylesheets are hooked
	 * at 'customize_controls_print_styles'.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_style(
			'shapla-radio-button-control',
			get_template_directory_uri() . '/inc/customizer/controls/radio-button/radio-button.css'
		);

	}

	/**
	 * Render the control to be displayed in the Customizer.
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-button-' . $this->id; ?>

        <span class="customize-control-title">
			<?php echo esc_attr( $this->label ); ?>
		</span>

		<?php if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

        <div id="input_<?php echo esc_attr( $this->id ); ?>" class="shapla-radio-buttonset buttonset">
	        <?php foreach ( $this->choices as $value => $label ) : ?>
                <input
                       class="switch-input screen-reader-text"
                       type="radio"
                       value="<?php echo esc_attr( $value ); ?>"
                       name="<?php echo esc_attr( $name ); ?>"
                       id="<?php echo esc_attr( $this->id . $value ); ?>"
	                <?php $this->link(); checked( $this->value(), $value ); ?>
                >
                        <label
                                class="switch-label switch-label-<?php echo ($value == $this->value()) ? 'on' : 'off'; ?>"
                                for="<?php echo esc_attr( $this->id ) . esc_attr( $value ); ?>"
                        ><?php echo esc_attr( $label ); ?></label>
                </input>
            <?php endforeach; ?>
        </div>

        <script>jQuery(document).ready(function ($) {
                $('[id="input_<?php echo esc_attr( $this->id ); ?>"]').buttonset();
            });</script>
		<?php
	}
}
