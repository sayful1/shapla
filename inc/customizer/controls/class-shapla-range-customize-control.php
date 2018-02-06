<?php

class Shapla_Range_Customize_Control extends Shapla_Customize_Control {
	/**
	 * Official control name.
	 */
	public $type = 'range-slider';

	public function enqueue() {
		parent::enqueue();
		wp_enqueue_script(
			'range-slider',
			get_template_directory_uri() . '/assets/js/customize/range-slider.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
	}


	/**
	 * Render the control's content.
	 *
	 * @author soderlind
	 * @version 1.2.0
	 */
	public function render_content() {
		?>
        <label>
            <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
            </span>
			<?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
            <div class="range-slider" style="width:100%; display:flex;flex-direction: row;justify-content: flex-start;">
				<span style="width:100%; flex: 1 0 0; vertical-align: middle;">
                    <input class="range-slider__range"
                           type="range"
                           value="<?php echo esc_attr( $this->value() ); ?>"
	                    <?php $this->input_attrs();
	                    $this->link(); ?>>
				<span class="range-slider__value">0</span></span>
            </div>
        </label>
		<?php
	}
}