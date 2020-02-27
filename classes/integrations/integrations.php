<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load Jetpack compatibility class.
 */
if ( class_exists( 'Jetpack' ) ) {
	Shapla_Jetpack::init();
}

// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( shapla_is_elementor_pro_active() ) {
	Shapla_Elementor_Pro::init();
}

if ( shapla_is_woocommerce_activated() ) {
	Shapla_WooCommerce::init();
}

if ( shapla_is_carousel_slider_activated() ) {
	Shapla_Carousel_Slider::init();
}