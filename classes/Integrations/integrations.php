<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Load Jetpack compatibility class.
 */
if ( class_exists( 'Jetpack' ) ) {
	\Shapla\Integrations\Jetpack\Jetpack::init();
}

/**
 * Elementor Compatibility requires PHP 5.4 for namespaces.
 */
if ( shapla_is_elementor_pro_active() ) {
	\Shapla\Integrations\ElementorPro\ElementorPro::init();
}

/**
 * Load WooCommerce compatibility class.
 */
if ( shapla_is_woocommerce_activated() ) {
	\Shapla\Integrations\WooCommerce\WooCommerce::init();
}

/**
 * Load Carousel Slider compatibility class.
 */
if ( shapla_is_carousel_slider_activated() ) {
	\Shapla\Integrations\CarouselSlider\CarouselSlider::init();
}
