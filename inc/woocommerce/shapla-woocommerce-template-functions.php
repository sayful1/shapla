<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WooCommerce Template Functions.
 *
 * @package shapla
 */

if ( ! function_exists( 'shapla_before_content' ) ):
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function shapla_before_content() {
		?>
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
		<?php
	}

endif;

if ( ! function_exists( 'shapla_after_content' ) ):
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function shapla_after_content() {
		?>
        </main><!-- #main -->
        </div><!-- #primary -->
		<?php
	}

endif;


if ( ! function_exists( 'shapla_wc_product_search' ) ) {
	/**
	 * WooCommerce Product Search
	 *
	 * @since   1.3.0
	 * @return  void
	 */
	function shapla_wc_product_search() {
		if ( ! shapla_is_woocommerce_activated() ) {
			return;
		}

		$header_layout = get_theme_mod( 'header_layout', 'layout-1' );
		if ( $header_layout != 'layout-3' ) {
			return;
		}

		shapla_search_form();
	}
}


if ( ! function_exists( 'shapla_add_to_cart_fragments' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 *
	 * @since   1.3.0
	 * @return array            Fragments to refresh via AJAX
	 */
	function shapla_add_to_cart_fragments( $fragments ) {
		ob_start();
		shapla_cart_link();
		$fragments['a.shapla-cart-contents'] = ob_get_clean();

		return $fragments;
	}
}


if ( ! function_exists( 'shapla_cart_link' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @since  1.3.0
	 * @return void
	 */
	function shapla_cart_link() {
		?>
        <a class="shapla-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>"
           title="<?php esc_attr_e( 'View your shopping cart', 'shapla' ); ?>">
            <span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
        </a>
		<?php
	}
}

if ( ! function_exists( 'shapla_header_cart' ) ) {
	/**
	 * Display Header Cart
	 *
	 * @since  1.3.0
	 * @return void
	 */
	function shapla_header_cart() {

		if ( ! shapla_is_woocommerce_activated() ) {
			return;
		}

		$show_cart_icon = get_theme_mod( 'show_cart_icon', true );
		if ( ! $show_cart_icon ) {
			return;
		}

		$header_layout = get_theme_mod( 'header_layout', 'layout-1' );
		if ( $header_layout != 'layout-3' ) {
			return;
		}

		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
        <ul id="site-header-cart" class="site-header-cart menu">
            <li class="<?php echo esc_attr( $class ); ?>">
				<?php shapla_cart_link(); ?>
            </li>
            <li>
				<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
            </li>
        </ul>
		<?php
	}
}
