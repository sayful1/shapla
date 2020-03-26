<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Load Jetpack compatibility class.
 */
if ( class_exists( 'Jetpack' ) ) {
	require SHAPLA_THEME_PATH . '/classes/integrations/jetpack/class-shapla-jetpack.php';
	Shapla_Jetpack::init();
}

/**
 * Elementor Compatibility requires PHP 5.4 for namespaces.
 */
if ( shapla_is_elementor_pro_active() ) {
	require SHAPLA_THEME_PATH . '/classes/integrations/elementor-pro/class-shapla-elementor-pro.php';
	Shapla_Elementor_Pro::init();
}

/**
 * Load WooCommerce compatibility class.
 */
if ( shapla_is_woocommerce_activated() ) {
	require SHAPLA_THEME_PATH . '/classes/integrations/woocommerce/class-shapla-woocommerce.php';
	Shapla_WooCommerce::init();
}

/**
 * Load Carousel Slider compatibility class.
 */
if ( shapla_is_carousel_slider_activated() ) {
	require SHAPLA_THEME_PATH . '/classes/integrations/carousel-slider/class-shapla-carousel-slider.php';
	Shapla_Carousel_Slider::init();
}
