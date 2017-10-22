<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Declare WooCommerce support
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'shapla_before_content', 10 );
add_action( 'woocommerce_after_main_content', 'shapla_after_content', 10 );

// Replace woocommerce_pagination() with the_posts_pagination() WordPress function
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'shapla_paging_nav', 10 );

// Remove woocommerce breadcrumb
// remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

add_action( 'shapla_header', 'shapla_wc_product_search', 25 );
add_action( 'shapla_header', 'shapla_header_cart', 30 );

add_filter( 'woocommerce_add_to_cart_fragments', 'shapla_add_to_cart_fragments' );
