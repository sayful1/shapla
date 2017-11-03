<?php

if ( ! class_exists( 'Shapla_Carousel_Slider' ) ) {

	class Shapla_Carousel_Slider {

		private static $instance;

		/**
		 * @return Shapla_Carousel_Slider
		 */
		public static function init() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Shapla_Carousel_Slider constructor.
		 */
		public function __construct() {
			add_filter( 'carousel_slider_post', array( $this, 'carousel_slider_post' ) );
			add_filter( 'carousel_slider_default_settings', array( $this, 'default_settings' ) );

			// Load Carousel Slider related scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 60 );
		}

		/**
		 * Load carousel slider scripts
		 */
		public function scripts() {
			wp_enqueue_style(
				'shapla-carousel-slider',
				get_template_directory_uri() . '/assets/css/carousel-slider.css',
				array(),
				null,
				'all'
			);
		}

		/**
		 * Carousel Slider Post Carousel
		 */
		public function carousel_slider_post() {
			$blog = new Shapla_Blog();
			?>
			<div class="blog-grid-inside">
				<?php $blog->post_thumbnail(); ?>
				<header class="entry-header">
					<?php
					$blog->post_category();
					$blog->post_title();
					?>
				</header>
				<div class="entry-summary"><?php echo get_the_excerpt(); ?></div>
				<?php $blog->post_tag(); ?>
				<footer class="entry-footer">
					<?php
					$blog->post_author();
					$blog->post_date();
					?>
				</footer>
			</div>
			<?php
		}

		/**
		 * Set carousel slider default options
		 *
		 * @param array $options
		 *
		 * @return mixed
		 */
		public function default_settings( $options ) {
			$options['product_title_color']       = shapla_default_options()->heading_color;
			$options['product_button_bg_color']   = shapla_default_options()->primary_button->background;
			$options['product_button_text_color'] = shapla_default_options()->primary_button->text;
			$options['nav_color']                 = shapla_adjust_color_brightness(
				shapla_default_options()->primary_button->text,
				- 14
			);
			$options['nav_active_color']          = shapla_default_options()->primary_button->background;
			$options['margin_right']              = 30;
			$options['lazy_load_image']           = 'on';

			return $options;
		}
	}
}

return Shapla_Carousel_Slider::init();
