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


if ( ! function_exists( 'shapla_loop_shop_columns' ) ) {
	/**
	 * Change number or products per row
	 * @return integer
	 */
	function shapla_loop_shop_columns() {
		return apply_filters( 'shapla_loop_shop_columns', 4 );
	}
}

if ( ! function_exists( 'shapla_wc_product_search' ) ) {
	/**
	 * WooCommerce Product Search
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
