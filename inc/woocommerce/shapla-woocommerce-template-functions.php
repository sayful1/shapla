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