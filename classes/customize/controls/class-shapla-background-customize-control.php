<?php
/**
 * Customizer Control: background.
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

if ( ! class_exists( 'Shapla_Background_Customize_Control' ) ) {

	class Shapla_Background_Customize_Control extends Shapla_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'shapla-background';

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
                <span class="customize-control-title">{{{ data.label }}}</span>
                <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
            </label>
            <div class="background-wrapper">

            <!-- background-color -->
            <div class="background-color">
                <h4><?php esc_attr_e( 'Background Color', 'shapla' ); ?></h4>
                <input type="text" data-default-color="{{ data.default['background-color'] }}" data-alpha="true"
                       value="{{ data.value['background-color'] }}" class="shapla-color-control"/>
            </div>

            <!-- background-image -->
            <div class="background-image">
                <h4><?php esc_attr_e( 'Background Image', 'shapla' ); ?></h4>
                <div class="attachment-media-view background-image-upload">
                    <# if ( data.value['background-image'] ) { #>
                    <div class="thumbnail thumbnail-image"><img src="{{ data.value['background-image'] }}" alt=""/>
                    </div>
                    <# } else { #>
                    <div class="placeholder"><?php esc_attr_e( 'No File Selected', 'shapla' ); ?></div>
                    <# } #>
                    <div class="actions">
                        <button class="button background-image-upload-remove-button<# if ( ! data.value['background-image'] ) { #> hidden <# } #>"><?php esc_attr_e( 'Remove', 'shapla' ); ?></button>
                        <button type="button"
                                class="button background-image-upload-button"><?php esc_attr_e( 'Select File', 'shapla' ); ?></button>
                    </div>
                </div>
            </div>

            <!-- background-repeat -->
            <div class="background-repeat">
                <h4><?php esc_attr_e( 'Background Repeat', 'shapla' ); ?></h4>
                <select {{{ data.inputAttrs }}}>
					<?php foreach ( $this->background_repeat() as $repeat_key => $repeat_label ): ?>
                        <option value="<?php echo $repeat_key; ?>"
                        <# if ( '<?php echo $repeat_key; ?>' === data.value['background-repeat'] ) { #> selected <# } #>
                        ><?php echo esc_attr( $repeat_label ); ?></option>
					<?php endforeach; ?>
                </select>
            </div>

            <!-- background-position -->
            <div class="background-position">
                <h4><?php esc_attr_e( 'Background Position', 'shapla' ); ?></h4>
                <select {{{ data.inputAttrs }}}>
					<?php foreach ( $this->background_position() as $position_key => $position_label ): ?>
                        <option value="<?php echo $position_key; ?>"
                        <# if ( '<?php echo $position_key; ?>' === data.value['background-position'] ) { #> selected <# } #>
                        ><?php echo esc_attr( $position_label ); ?></option>
					<?php endforeach; ?>
                </select>
            </div>

            <!-- background-size -->
            <div class="background-size">
                <h4><?php esc_attr_e( 'Background Size', 'shapla' ); ?></h4>
                <div class="buttonset">
					<?php foreach ( $this->background_size() as $size_key => $size_label ): ?>
                        <input {{{ data.inputAttrs }}}
                               class="switch-input screen-reader-text"
                               type="radio"
                               value="<?php echo $size_key; ?>"
                               name="_customize-bg-{{{ data.id }}}-size"
                               id="{{ data.id }}<?php echo $size_key; ?>"
                        <# if ( '<?php echo $size_key; ?>' === data.value['background-size'] ) { #> checked="checked" <# } #>
                        >
                        <label
                                class="switch-label switch-label-<# if ( '<?php echo $size_key; ?>' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>"
                                for="{{ data.id }}<?php echo $size_key; ?>">
							<?php echo esc_attr( $size_label ); ?>
                        </label>
                        </input>
					<?php endforeach; ?>
                </div>
            </div>

            <!-- background-attachment -->
            <div class="background-attachment">
                <h4><?php esc_attr_e( 'Background Attachment', 'shapla' ); ?></h4>
                <div class="buttonset">
					<?php foreach ( $this->background_attachment() as $attachment_key => $attachment ): ?>
                        <input {{{ data.inputAttrs }}}
                               class="switch-input screen-reader-text"
                               type="radio"
                               value="<?php echo $attachment_key; ?>"
                               name="_customize-bg-{{{ data.id }}}-attachment"
                               id="{{ data.id }}<?php echo $attachment_key; ?>"
                        <# if ( '<?php echo $attachment_key; ?>' === data.value['background-attachment'] ) { #> checked="checked" <# } #>
                        >
                        <label
                                class="switch-label switch-label-<# if ( '<?php echo $attachment_key; ?>' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>"
                                for="{{ data.id }}<?php echo $attachment_key; ?>">
							<?php echo $attachment; ?>
                        </label>
                        </input>
					<?php endforeach; ?>
                </div>
            </div>
            <input class="background-hidden-value" type="hidden" {{{ data.link }}}>
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
}