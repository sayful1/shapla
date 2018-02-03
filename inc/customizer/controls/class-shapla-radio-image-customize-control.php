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
class Shapla_Radio_Image_Customize_Control extends Shapla_Customize_Control {

	/**
	 * Declare the control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'radio-image';

	/**
	 * Render the control to be displayed in the Customizer.
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-image-' . $this->id; ?>

        <span class="customize-control-title">
			<?php echo esc_attr( $this->label ); ?>
		</span>

		<?php if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

        <div id="input_<?php echo esc_attr( $this->id ); ?>" class="shapla-radio-image image">
			<?php foreach ( $this->choices as $value => $label ) : ?>
                <input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>"
                       id="<?php echo esc_attr( $this->id . $value ); ?>"
                       name="<?php echo esc_attr( $name ); ?>" <?php $this->link();
				checked( $this->value(), $value ); ?>>
                <label for="<?php echo esc_attr( $this->id ) . esc_attr( $value ); ?>">
                    <img src="<?php echo esc_html( $label ); ?>" alt="<?php echo esc_attr( $value ); ?>">
                    <span class="image-label">
                        <span class="inner">
                            <?php
                            $inner_title = str_replace( array( '-', '_' ), ' ', $value );
                            echo esc_attr( $inner_title );
                            ?>
                        </span>
                    </span>
                    <span class="image-clickable"></span>
                </label>
                </input>
			<?php endforeach; ?>
        </div>

        <script>jQuery(document).ready(function ($) {
                $('[id="input_<?php echo esc_attr( $this->id ); ?>"]').buttonset();
            });</script>
		<?php
	}
}