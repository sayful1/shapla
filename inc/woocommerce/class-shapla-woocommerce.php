<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_WooCommerce' ) ) {

	class Shapla_WooCommerce {

		private static $instance;

		/**
		 * @return Shapla_WooCommerce
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			// Declare WooCommerce support.
			add_action( 'after_setup_theme', array( $this, 'woocommerce_setup' ) );
			// Remove each style one by one
			add_filter( 'woocommerce_enqueue_styles', array( $this, 'dequeue_wc_styles' ) );
			// Load WooCommerce related scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 15 );
			// WooCommerce Products per page
			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 99 );
			// WooCommerce Products per row
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ), 99 );
			// WooCommerce Related products per page
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			// Add body classes for shop columns
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			// WooCommerce upsell product per columns
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'output_upsells' ), 15 );

			// Add wrapper inside product
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'wc_before_shop_loop_item' ), 1 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'wc_after_shop_loop_item' ), 100 );

			// Hide default page title
			add_filter( 'woocommerce_show_page_title', array( $this, 'hide_default_page_title' ) );
		}

		/**
		 * Hide WooCommerce default page title
		 *
		 * @version 1.4.0
		 * @return bool
		 */
		public function hide_default_page_title() {
			return false;
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 *
		 * @since  1.1.3
		 * @return array
		 */
		public function body_classes( $classes ) {
			$cols = get_theme_mod( 'wc_products_per_row', 4 );
			$cols = apply_filters( 'shapla_wc_products_per_row', intval( $cols ) );

			if ( in_array( $cols, array( 3, 4, 5, 6 ) ) ) {
				$classes[] = sprintf( 'columns-%s', $cols );
			}

			return $classes;
		}

		/**
		 * Add support for WooCommerce
		 */
		public function woocommerce_setup() {
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}

		/**
		 * Disable WooCommerce default styles
		 *
		 * @param $enqueue_styles
		 *
		 * @return mixed
		 */
		public function dequeue_wc_styles( $enqueue_styles ) {
			// Remove the gloss
			unset( $enqueue_styles['woocommerce-general'] );
			// Remove the layout
			unset( $enqueue_styles['woocommerce-layout'] );
			// Remove the smallscreen optimisation
			unset( $enqueue_styles['woocommerce-smallscreen'] );

			return $enqueue_styles;
		}

		/**
		 * Load scripts for WooCommerce
		 */
		public function woocommerce_scripts() {
			wp_enqueue_style(
				'shapla-woocommerce-style',
				get_template_directory_uri() . '/assets/css/woocommerce.css',
				array(),
				SHAPLA_VERSION,
				'all'
			);

			$font_path   = WC()->plugin_url() . '/assets/fonts/';
			$inline_font = '@font-face {
				font-family: "star";
				src: url("' . $font_path . 'star.eot");
				src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
					url("' . $font_path . 'star.woff") format("woff"),
					url("' . $font_path . 'star.ttf") format("truetype"),
					url("' . $font_path . 'star.svg#star") format("svg");
				font-weight: normal;
				font-style: normal;
			}';

			wp_add_inline_style( 'shapla-woocommerce-style', $inline_font );
		}

		/**
		 * Set number of products to show per page
		 *
		 * @param $cols
		 *
		 * @return int
		 */
		public function loop_shop_per_page( $cols ) {
			$cols = get_theme_mod( 'wc_products_per_page', 12 );

			return apply_filters( 'shapla_wc_products_per_page', intval( $cols ) );
		}

		/**
		 * Set number of products to show per column
		 *
		 * @param $cols
		 *
		 * @return int
		 */
		public function loop_shop_columns( $cols ) {
			$cols = get_theme_mod( 'wc_products_per_row', 4 );

			return apply_filters( 'shapla_wc_products_per_row', intval( $cols ) );
		}

		/**
		 * Set number of related products per row
		 *
		 * @param $args
		 *
		 * @return mixed
		 */
		public function related_products_args( $args ) {
			$cols                   = get_theme_mod( 'wc_products_per_row', 4 );
			$args['posts_per_page'] = apply_filters( 'shapla_wc_related_products_per_page', intval( $cols ) );

			return $args;
		}

		/**
		 * Set up sales display
		 */
		public function output_upsells() {
			$cols = get_theme_mod( 'wc_products_per_row', 4 );
			$cols = apply_filters( 'shapla_wc_upsell_products_per_page', intval( $cols ) );
			// Display 3 products in rows of 3
			woocommerce_upsell_display( $cols, $cols );
		}

		/**
		 * Add custom div before show loop item
		 */
		public function wc_before_shop_loop_item() {
			echo '<div class="product-item-inner">';
		}

		/**
		 * Close custom div after shop loop item
		 */
		public function wc_after_shop_loop_item() {
			echo '</div>';
		}
	}

}

return Shapla_WooCommerce::init();
