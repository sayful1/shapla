<?php

namespace Shapla\Integrations\WooCommerce;

use Shapla\Helpers\SvgIcon;

defined( 'ABSPATH' ) || exit;

class WooCommerce {

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

			self::$instance->init_hooks();
		}

		return self::$instance;
	}

	/**
	 * Init hooks
	 */
	public function init_hooks() {
		// Declare WooCommerce support
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', array( $this, 'before_main_content' ), 10 );
		add_action( 'woocommerce_after_main_content', array( $this, 'after_main_content' ), 10 );

		// Declare WooCommerce support.
		add_action( 'after_setup_theme', array( $this, 'woocommerce_setup' ) );
		// Remove each style one by one
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'dequeue_wc_styles' ) );
		// Load WooCommerce related scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 15 );
		// WooCommerce Products per page
		add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 99 );
		// WooCommerce cross sells columns
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'cross_sells_columns' ), 99 );
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

		// Replace woocommerce_pagination() with the_posts_pagination() WordPress function
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
		add_action( 'woocommerce_after_shop_loop', 'shapla_pagination', 10 );

		// Remove WooCommerce default breadcrumb
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// Change WooCommerce cross sell display after cart
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );

		add_action( 'shapla_search_form_before_submit', array( $this, 'product_search_form_post_type' ), 25 );
		add_action( 'shapla_header_inner', array( $this, 'product_search_form' ), 25 );
		add_action( 'shapla_header_extras', array( $this, 'header_cart' ), 30 );

		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );
	}

	/**
	 * Before main Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @return  void
	 * @since   1.6.0
	 */
	function before_main_content() {
		?>
		<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
	}

	/**
	 * After main Content
	 * Closes the wrapping divs
	 *
	 * @return  void
	 * @since   1.6.0
	 */
	public function after_main_content() {
		?>
		</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}

	/**
	 * Hide WooCommerce default page title
	 *
	 * @return bool
	 * @version 1.4.0
	 */
	public function hide_default_page_title() {
		return false;
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 * @since  1.1.3
	 */
	public function body_classes( $classes ) {
		$cols = shapla_get_option( 'wc_products_per_row', 4 );
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
				SHAPLA_THEME_VERSION,
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
		$cols = shapla_get_option( 'wc_products_per_page', 12 );

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
		$cols = shapla_get_option( 'wc_products_per_row', 4 );

		return apply_filters( 'shapla_wc_products_per_row', intval( $cols ) );
	}

	/**
	 * WooCommerce cross sells columns
	 *
	 * @param int $cols
	 *
	 * @return int
	 */
	public function cross_sells_columns( $cols ) {
		$cols = shapla_get_option( 'wc_products_per_row', 4 );

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
		$cols                   = shapla_get_option( 'wc_products_per_row', 4 );
		$args['posts_per_page'] = apply_filters( 'shapla_wc_related_products_per_page', intval( $cols ) );

		return $args;
	}

	/**
	 * Set up sales display
	 */
	public function output_upsells() {
		$cols = shapla_get_option( 'wc_products_per_row', 4 );
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

	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 *
	 * @return array            Fragments to refresh via AJAX
	 * @since   1.6.0
	 */
	public function add_to_cart_fragments( $fragments ) {
		$fragments['.item-count'] = '<span class="item-count">' . wp_kses_data( WC()->cart->get_cart_contents_count() ) . '</span>';

		return $fragments;
	}

	/**
	 * Display Header Cart
	 *
	 * @return void
	 * @since  1.6.0
	 */
	public function header_cart() {
		$show_cart_icon = shapla_get_option( 'show_cart_icon', true );
		if ( ! $show_cart_icon ) {
			return;
		}

		$this->my_account_link();
		$this->shapla_cart_link();
		add_action( 'wp_footer', array( $this, 'cart_sidenav' ), 1 );
	}

	public function cart_sidenav() {
		$show_cart_icon = shapla_get_option( 'show_cart_icon', true );
		if ( ! $show_cart_icon || is_cart() || is_checkout() ) {
			return;
		}
		?>
		<div id="drawer-cart" class="shapla-drawer shapla-drawer--right drawer-cart" tabindex="-1"
			 aria-hidden="true">
			<div class="shapla-drawer__background"></div>
			<div class="shapla-drawer__body">
				<div class="shapla-drawer__content">
					<div class="drawer-cart-content">
						<div class="drawer-cart-heading">
							<h4 class="drawer-cart-title"><?php esc_html_e( 'Cart', 'shapla' ); ?></h4>
							<button class="is-icon drawer-cart-close" data-dismiss="drawer"
									aria-label="<?php esc_attr_e( 'Close sidebar', 'shapla' ); ?>"
									title="<?php esc_attr_e( 'Close sidebar', 'shapla' ); ?>">
								<?php echo SvgIcon::get_svg( 'close', 24, 'ui' ) ?>
							</button>
						</div>
						<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.6.0
	 */
	public function shapla_cart_link() {
		?>
		<button id="header__cart-toggle" class="header__cart-toggle" data-toggle="drawer" data-target="#drawer-cart"
				title="<?php esc_attr_e( 'View cart', 'shapla' ); ?>">
			<?php echo SvgIcon::get_svg( 'shopping_cart', 24, 'ui' ); ?>
			<span class="item-count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
		</button>
		<?php
	}

	/**
	 * My account page link
	 *
	 * @return void
	 */
	public function my_account_link() {
		?>
		<a id="header__my-account" class="button is-icon" title="<?php esc_attr_e( 'View dashboard', 'shapla' ); ?>"
		   href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
			<?php echo SvgIcon::get_svg( 'person', 24, 'ui' ); ?>
		</a>
		<?php
	}

	/**
	 * WooCommerce Product Search
	 *
	 * @return  void
	 * @since   1.6.0
	 */
	function product_search_form() {
		$header_layout = shapla_get_option( 'header_layout', 'layout-1' );
		if ( $header_layout != 'layout-3' ) {
			return;
		}

		shapla_search_form();
	}

	/**
	 * Add post type hidden field for WooCommerce search form
	 *
	 * @return void
	 */
	public function product_search_form_post_type() {
		?><input type="hidden" name="post_type" value="product"/><?php
	}
}
