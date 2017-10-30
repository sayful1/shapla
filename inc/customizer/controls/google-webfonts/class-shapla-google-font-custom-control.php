<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * A class to create a dropdown for all google fonts
 */
class Shapla_Google_Font_Customize_Control extends WP_Customize_Control {

	private $fonts = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$this->fonts = $this->get_fonts();
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the content of the category dropdown
	 *
	 * @return void
	 */
	public function render_content() {
		if ( empty( $this->fonts ) ) {
			return;
		}

		$name = '_customize-fonts-' . $this->id; ?>
        <label>
			<?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif;
			if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>

            <select name="<?php echo esc_attr( $name ); ?>"
                    id="<?php echo esc_attr( $this->id . $this->value() ); ?>" <?php $this->link(); ?>>
				<?php
				echo '<option value="sans-serif" ' . selected( $this->value(), 'sans-serif', false ) . '>' . esc_attr__( 'Standard Sans Serif', 'shapla' ) . '</option>';
				foreach ( $this->fonts as $font ) {
					echo '<option value="' . esc_attr( $font->family ) . '" ' . selected( $this->value(), $font->family, false ) . '>' . $font->family . '</option>';
				}
				?>
            </select>
        </label>
		<?php
	}

	/**
	 * Get the google fonts from the API or in the cache
	 *
	 * @return array
	 */
	public function get_fonts() {
		ob_start();
		include_once 'google-webfonts.json';
		$content = ob_get_clean();

		$content = json_decode( $content );

		return $content;
	}
}

?>