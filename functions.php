<?php
/**
 * Shapla functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shapla
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Assign the Shapla version to a var
 */
$theme          = wp_get_theme( 'shapla' );
$shapla_version = $theme['Version'];

if ( ! defined( 'SHAPLA_VERSION' ) ) {
	define( 'SHAPLA_VERSION', $shapla_version );
}

$shapla = (object) array(
	'version'    => $shapla_version,
	'main'       => require 'inc/class-shapla.php',
	'customizer' => require 'inc/customizer/class-shapla-customizer.php',
);

/**
 * Load template hooks and functions file.
 */
require 'inc/class-shapla-sanitize.php';
require 'inc/class-shapla-fonts.php';
require 'inc/class-shapla-breadcrumb.php';

require 'inc/shapla-functions.php';
require 'inc/shapla-template-hooks.php';
require 'inc/shapla-template-functions.php';

require 'inc/class-shapla-structured-data.php';

/**
 * Customizer
 */
require 'inc/customizer/init.php';

/**
 * Load Shapla modules
 */
include 'inc/modules/class-shapla-blog.php';


/**
 * Load Jetpack compatibility class.
 */
if ( class_exists( 'Jetpack' ) ) {
	$shapla->jetpack = require 'inc/jetpack/class-shapla-jetpack.php';
}

// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once 'inc/elementor/class-shapla-elementor-pro.php';
}


if ( shapla_is_woocommerce_activated() ) {
	$shapla->woocommerce = require 'inc/woocommerce/class-shapla-woocommerce.php';
	require 'inc/woocommerce/shapla-woocommerce-template-hooks.php';
	require 'inc/woocommerce/shapla-woocommerce-template-functions.php';
}

if ( shapla_is_carousel_slider_activated() ) {
	require 'inc/carousel-slider/class-shapla-carousel-slider.php';
}

if ( is_admin() ) {
	require 'inc/admin/class-shapla-system-status.php';
	require 'inc/admin/class-shapla-admin.php';
}

// Metabox
require 'inc/admin/class-shapla-metabox.php';
require 'inc/admin/class-shapla-page-metabox-fields.php';
