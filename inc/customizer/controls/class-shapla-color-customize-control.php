<?php
/**
 * Create a Radio-Image control
 *
 * This class incorporates code from the Kirki Customizer Framework.
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
class Shapla_Color_Customize_Control extends WP_Customize_Control {

	/**
	 * Declare the control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'alpha-color';

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
		wp_enqueue_style(
			'wp-color-picker-alpha',
			get_template_directory_uri() . '/assets/css/customizer/color-picker.css',
			array( 'wp-color-picker' ),
			'all'
		);
		wp_enqueue_script(
			'wp-color-picker-alpha',
			get_template_directory_uri() . '/assets/js/vendors/wp-color-picker-alpha.js',
			array( 'jquery', 'wp-color-picker' ),
			'1.2.2',
			true
		);
		wp_enqueue_script(
			'shapla-alpha-color',
			get_template_directory_uri() . '/assets/js/vendors/alpha-color.js',
			array( 'wp-color-picker-alpha' ),
			'1.2.2',
			true
		);
	}

	/**
	 * Render the control to be displayed in the Customizer.
	 */
	public function render_content() {
		$name = '_customize-alpha-color-' . $this->id; ?>

        <span class="customize-control-title">
			<?php echo esc_attr( $this->label ); ?>
		</span>

		<?php if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>
        <div class="customize-control-content">
            <label>
                <span class="screen-reader-text"><?php echo esc_attr( $this->label ); ?></span>
                <input
                        name="<?php echo esc_attr( $name ); ?>"
                        type="text"
                        maxlength="7"
                        data-default-color="<?php $this->setting->default; ?>"
                        placeholder="<?php $this->setting->default; ?>"
                        data-alpha="true"
                        class="shapla-color-picker"
					<?php $this->input_attrs(); ?>
					<?php if ( ! isset( $this->input_attrs['value'] ) ) : ?>
                        value="<?php echo esc_attr( $this->value() ); ?>"
					<?php endif; ?>
					<?php $this->link(); ?>
                />
        </div>
		<?php
	}
}
