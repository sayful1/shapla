<?php

use Shapla\Integrations\CarouselSlider\CarouselSlider;
use Shapla\Integrations\ElementorPro\ElementorPro;
use Shapla\Integrations\Jetpack\Jetpack;
use Shapla\Integrations\WooCommerce\WooCommerce;

defined( 'ABSPATH' ) || exit;

/**
 * Load Jetpack compatibility class.
 */
if ( class_exists( 'Jetpack' ) ) {
	Jetpack::init();
}

/**
 * Elementor Compatibility requires PHP 5.4 for namespaces.
 */
if ( shapla_is_elementor_pro_active() ) {
	ElementorPro::init();
}

/**
 * Load WooCommerce compatibility class.
 */
if ( shapla_is_woocommerce_activated() ) {
	WooCommerce::init();
}

/**
 * Load Carousel Slider compatibility class.
 */
if ( shapla_is_carousel_slider_activated() ) {
	CarouselSlider::init();
}
