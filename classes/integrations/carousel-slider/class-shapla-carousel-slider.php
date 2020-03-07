<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Shapla_Carousel_Slider' ) ) {

	class Shapla_Carousel_Slider {

		/**
		 * The instance of the class
		 *
		 * @var self
		 */
		private static $instance;

		/**
		 * Only one instance of the class can be loaded
		 *
		 * @return self
		 */
		public static function init() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				add_filter( 'carousel_slider_post', array( self::$instance, 'carousel_slider_post' ) );
				add_filter( 'carousel_slider_default_settings', array( self::$instance, 'default_settings' ) );

				// Load Carousel Slider related scripts
				add_action( 'wp_enqueue_scripts', array( self::$instance, 'scripts' ), 60 );
			}

			return self::$instance;
		}

		/**
		 * Load carousel slider scripts
		 */
		public function scripts() {
			wp_enqueue_style( 'shapla-carousel-slider',
				get_template_directory_uri() . '/assets/css/carousel-slider.css',
				array(), SHAPLA_THEME_VERSION, 'all' );
		}

		/**
		 * Carousel Slider Post Carousel
		 */
		public function carousel_slider_post() {
			( new Shapla_Blog() )->get_loop_post_for_grid();
		}

		/**
		 * Set carousel slider default options
		 *
		 * @param array $options
		 *
		 * @return mixed
		 */
		public function default_settings( $options ) {
			$options['product_title_color']       = Shapla_Colors::get_color( 'text-primary' );
			$options['product_button_bg_color']   = Shapla_Colors::get_color( 'primary' );
			$options['product_button_text_color'] = Shapla_Colors::get_color( 'on-primary' );
			$options['nav_color']                 = Shapla_Colors::get_color( 'primary' );
			$options['nav_active_color']          = Shapla_Colors::get_color( 'primary-variant' );
			$options['margin_right']              = 30;
			$options['lazy_load_image']           = 'on';

			return $options;
		}
	}
}
