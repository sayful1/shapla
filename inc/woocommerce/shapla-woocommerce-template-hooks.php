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

// Change number or products per row
// add_filter('loop_shop_columns', 'shapla_loop_shop_columns');