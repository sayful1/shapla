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
	 * @since   1.2.3
	 * @return  void
	 */
	function shapla_wc_product_search() {
		if ( ! shapla_is_woocommerce_activated() ) {
			return;
		}

		$header_layout = get_theme_mod( 'header_layout', 'default' );
		if ( $header_layout != 'widget' ) {
			return;
		}

		$q_var    = get_query_var( 'product_cat' );
		$selected = empty( $q_var ) ? '' : $q_var;
		$args     = array(
			'show_option_none'  => __( 'All', 'shapla' ),
			'option_none_value' => '',
			'orderby'           => 'name',
			'taxonomy'          => 'product_cat',
			'name'              => 'product_cat',
			'class'             => 'shapla-cat-list',
			'value_field'       => 'slug',
			'selected'          => $selected,
			'hide_if_empty'     => 1,
			'echo'              => 1,
			'show_count'        => 0,
			'hierarchical'      => 1,
		);
		?>
        <div class="shapla-product-search">
            <form role="search" method="get" class="shapla-product-search-form"
                  action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="nav-left">
                    <div class="nav-search-facade" data-value="search-alias=aps">
                        <span class="nav-search-label" data-default="<?php esc_html_e( 'All', 'shapla' ); ?>">
                            <?php esc_html_e( 'All', 'shapla' ); ?>
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </div>
					<?php wp_dropdown_categories( $args ); ?>
                </div>
                <div class="nav-right">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
                <div class="nav-fill">
                    <input type="hidden" name="post_type" value="product"/>
                    <input name="s" type="text" value="<?php echo get_search_query(); ?>"
                           placeholder="<?php esc_attr_e( 'Search for products', 'shapla' ); ?>"/>
                </div>
            </form>
        </div>
		<?php
	}
}


if ( ! function_exists( 'shapla_add_to_cart_fragments' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 *
	 * @since   1.2.3
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
	 * @since  1.2.3
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
	 * @since  1.2.3
	 * @return void
	 */
	function shapla_header_cart() {
		if ( ! shapla_is_woocommerce_activated() ) {
			return;
		}
		$header_layout = get_theme_mod( 'header_layout', 'default' );
		if ( $header_layout != 'widget' ) {
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

if ( ! function_exists( 'shapla_wc_breadcrumb' ) ) {
	/**
	 * Display breadcrumb
	 *
	 * @since  2.2.3
	 * @return array
	 */
	function shapla_wc_breadcrumb() {
		$args = apply_filters( 'shapla_wc_breadcrumb', array(
			'delimiter'   => '',
			'wrap_before' => '<nav class="breadcrumb has-succeeds-separator"><ul>',
			'wrap_after'  => '</ul></nav>',
			'before'      => '<li>',
			'after'       => '</li>',
			'home'        => _x( 'Home', 'breadcrumb', 'shapla' ),
		) );

		return $args;
	}
}