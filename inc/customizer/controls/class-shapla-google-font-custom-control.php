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
				echo '<option value="sans-serif" ' . selected( $this->value(), 'sans-serif',
						false ) . '>' . esc_attr__( 'Standard Sans Serif', 'shapla' ) . '</option>';
				foreach ( $this->fonts as $font ) {
					echo '<option value="' . esc_attr( $font->family ) . '" ' . selected( $this->value(), $font->family,
							false ) . '>' . $font->family . '</option>';
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

		$content = json_decode( json_encode( $this->google_fonts() ), false );

		return $content;
	}

	public function google_fonts() {
		$fonts = array(
			array(
				'family'   => 'Roboto',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Open Sans',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Lato',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Roboto Condensed',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Oswald',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Montserrat',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Source Sans Pro',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Raleway',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'PT Sans',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Open Sans Condensed',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Ubuntu',
				'category' => 'sans-serif',
			),
			array(
				'family'   => 'Noto Sans',
				'category' => 'sans-serif',
			),
			// Serif Fonts
			array(
				'family'   => 'Slabo 27px',
				'category' => 'serif',
			),
			array(
				'family'   => 'Roboto Slab',
				'category' => 'serif',
			),
			array(
				'family'   => 'Merriweather',
				'category' => 'serif',
			),
			array(
				'family'   => 'Lora',
				'category' => 'serif',
			),
			array(
				'family'   => 'Playfair Display',
				'category' => 'serif',
			),
			array(
				'family'   => 'PT Serif',
				'category' => 'serif',
			),
			array(
				'family'   => 'Noto Serif',
				'category' => 'serif',
			),
			array(
				'family'   => 'Bitter',
				'category' => 'serif',
			),
		);

		return $fonts;
	}
}

?>