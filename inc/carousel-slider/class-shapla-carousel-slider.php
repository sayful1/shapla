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
			$blog->blog();
		}
	}
}

return Shapla_Carousel_Slider::init();
