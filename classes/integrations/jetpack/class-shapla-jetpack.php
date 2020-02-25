<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 *
 * @package Shapla
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Shapla_Jetpack' ) ) {

	class Shapla_Jetpack {

		/**
		 * The instance of the class
		 *
		 * @var self
		 */
		protected static $instance = null;

		/**
		 * Only one instance of the class can be loaded
		 *
		 * @return self
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				add_action( 'after_setup_theme', array( self::$instance, 'shapla_jetpack_setup' ) );
			}

			return self::$instance;
		}

		/**
		 * Jetpack setup function.
		 *
		 * See: https://jetpack.com/support/infinite-scroll/
		 * See: https://jetpack.com/support/responsive-videos/
		 */
		public function shapla_jetpack_setup() {
			// Add theme support for Infinite Scroll.
			add_theme_support( 'infinite-scroll', array(
				'container'      => 'main',
				'footer'         => 'page',
				'type'           => 'click',
				'posts_per_page' => '12',
				'render'         => array( $this, 'infinite_scroll_render' ),
			) );

			// Add theme support for Responsive Videos.
			add_theme_support( 'jetpack-responsive-videos' );
		}

		/**
		 * Custom render function for Infinite Scroll.
		 */
		function infinite_scroll_render() {
			while ( have_posts() ) {
				the_post();
				if ( is_search() ) :
					get_template_part( 'template-parts/content', 'search' );
				else :
					get_template_part( 'template-parts/content', get_post_format() );
				endif;
			}
		}
	}
}
