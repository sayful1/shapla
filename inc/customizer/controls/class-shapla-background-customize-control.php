<?php

class Shapla_Background_Customize_Control extends Shapla_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'shapla-background';

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
	 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 */
	protected function render_content() {
		$name = '_customize-background-' . $this->id;

		$value   = $this->value();
		$default = $this->setting->default;
		if ( ! empty( $this->default ) ) {
			$default = $this->default;
		}

		// Input attributes.
		$inputAttrs = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$inputAttrs .= $attr . '="' . esc_attr( $value ) . '" ';
		}

		$default_background_color = isset( $default['background-color'] ) ? esc_attr( $default['background-color'] ) : '';

		$value_background_color      = isset( $value['background-color'] ) ? esc_attr( $value['background-color'] ) : '';
		$value_background_repeat     = isset( $value['background-repeat'] ) ? esc_attr( $value['background-repeat'] ) : 'no-repeat';
		$value_background_position   = isset( $value['background-position'] ) ? esc_attr( $value['background-position'] ) : 'center center';
		$value_background_size       = isset( $value['background-size'] ) ? esc_attr( $value['background-size'] ) : 'cover';
		$value_background_attachment = isset( $value['background-attachment'] ) ? esc_attr( $value['background-attachment'] ) : 'fixed';
		?>

        <span class="customize-control-title">
			<?php echo esc_attr( $this->label ); ?>
		</span>

		<?php if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

        <div class="background-wrapper">
            <!-- background-color -->
            <div class="background-color">
                <h4><?php esc_attr_e( 'Background Color', 'shapla' ); ?></h4>
                <input type="text"
                       data-default-color="<?php echo $default_background_color; ?>"
                       value="<?php echo $value_background_color; ?>"
                       data-alpha="true"
                       class="shapla-color-control"/>
            </div>

            <!-- background-image -->
            <div class="background-image">
                <h4><?php esc_attr_e( 'Background Image', 'shapla' ); ?></h4>
                <div class="attachment-media-view background-image-upload">
					<?php if ( ! empty( $value['background-image'] ) ): ?>
                        <div class="thumbnail thumbnail-image">
                            <img src="<?php echo $value['background-image']; ?>" alt=""/>
                        </div>
					<?php else: ?>
                        <div class="placeholder"><?php esc_attr_e( 'No File Selected', 'shapla' ); ?></div>
					<?php endif; ?>
                    <div class="actions">
                        <button class="button background-image-upload-remove-button<?php echo empty( $value['background-image'] ) ? 'hidden' : null; ?>">
							<?php esc_attr_e( 'Remove', 'shapla' ); ?>
                        </button>
                        <button type="button" class="button background-image-upload-button">
							<?php esc_attr_e( 'Select File', 'shapla' ); ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- background-repeat -->
            <div class="background-repeat">
                <h4><?php esc_attr_e( 'Background Repeat', 'shapla' ); ?></h4>
                <select <?php echo $inputAttrs; ?>>
					<?php
					foreach ( $this->background_repeat() as $repeat_key => $repeat_value ) {
						$repeat_selected = ( $repeat_key === $value_background_repeat ) ? ' selected' : '';
						echo '<option value="' . $repeat_key . '" ' . $repeat_selected . '>' . $repeat_value . '</option>';
					}
					?>
                </select>
            </div>

            <!-- background-position -->
            <div class="background-position">
                <h4><?php esc_attr_e( 'Background Position', 'shapla' ); ?></h4>
                <select <?php echo $inputAttrs; ?>>
					<?php
					foreach ( $this->background_position() as $position_key => $position_value ) {
						$position_selected = ( $position_key === $value_background_position ) ? ' selected' : '';
						echo '<option value="' . $position_key . '" ' . $position_selected . '>' . $position_value . '</option>';
					}
					?>
                </select>
            </div>

            <!-- background-size -->
            <div class="background-size">
                <h4><?php esc_attr_e( 'Background Size', 'shapla' ); ?></h4>
                <select <?php echo $inputAttrs; ?>>
					<?php
					foreach ( $this->background_size() as $size_key => $size_value ) {
						$size_selected = ( $size_key === $value_background_size ) ? ' selected' : '';
						echo '<option value="' . $size_key . '" ' . $size_selected . '>' . $size_value . '</option>';
					}
					?>
                </select>
            </div>

            <!-- background-attachment -->
            <div class="background-attachment">
                <h4><?php esc_attr_e( 'Background Attachment', 'shapla' ); ?></h4>
                <select name="<?php echo esc_attr( $name . '[background-attachment]' ); ?>">
					<?php
					foreach ( $this->background_attachment() as $attachment_key => $attachment_value ) {
						$attachment_selected = ( $attachment_key === $value_background_attachment ) ? ' selected' : '';
						echo '<option value="' . $attachment_key . '" ' . $attachment_selected . '>' . $attachment_value . '</option>';
					}
					?>
                </select>
            </div>

        </div>

        <input class="background-hidden-value" type="hidden" <?php $this->link(); ?>>
		<?php
	}

	/**
	 * @return array
	 */
	private function background_repeat() {
		return array(
			'no-repeat' => esc_attr__( 'No Repeat', 'shapla' ),
			'repeat'    => esc_attr__( 'Repeat All', 'shapla' ),
			'repeat-x'  => esc_attr__( 'Repeat Horizontally', 'shapla' ),
			'repeat-y'  => esc_attr__( 'Repeat Vertically', 'shapla' ),
		);
	}

	/**
	 * @return array
	 */
	private function background_position() {
		return array(
			'left top'      => esc_attr__( 'Left Top', 'shapla' ),
			'left center'   => esc_attr__( 'Left Center', 'shapla' ),
			'left bottom'   => esc_attr__( 'Left Bottom', 'shapla' ),
			'right top'     => esc_attr__( 'Right Top', 'shapla' ),
			'right center'  => esc_attr__( 'Right Center', 'shapla' ),
			'right bottom'  => esc_attr__( 'Right Bottom', 'shapla' ),
			'center top'    => esc_attr__( 'Center Top', 'shapla' ),
			'center center' => esc_attr__( 'Center Center', 'shapla' ),
			'center bottom' => esc_attr__( 'Center Bottom', 'shapla' ),
		);
	}

	/**
	 * @return array
	 */
	private function background_size() {
		return array(
			'cover'   => esc_attr__( 'Cover', 'shapla' ),
			'contain' => esc_attr__( 'Contain', 'shapla' ),
			'auto'    => esc_attr__( 'Auto', 'shapla' ),
		);
	}

	/**
	 * @return array
	 */
	private function background_attachment() {
		return array(
			'fixed'  => esc_attr__( 'Fixed', 'shapla' ),
			'scroll' => esc_attr__( 'Scroll', 'shapla' ),
		);
	}
}