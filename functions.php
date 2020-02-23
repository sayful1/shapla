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

if ( ! defined( 'SHAPLA_PATH' ) ) {
	define( 'SHAPLA_PATH', dirname( __FILE__ ) );
}

/**
 * Include utilities classes and functions
 */
require SHAPLA_PATH . '/inc/utilities/class-shapla-colors.php';
require SHAPLA_PATH . '/inc/utilities/class-shapla-sanitize.php';
require SHAPLA_PATH . '/inc/utilities/class-shapla-fonts.php';
require SHAPLA_PATH . '/inc/utilities/class-shapla-breadcrumb.php';

$shapla = (object) array(
	'version'    => $shapla_version,
	'main'       => require SHAPLA_PATH . '/inc/class-shapla.php',
	'customizer' => require SHAPLA_PATH . '/inc/customizer/class-shapla-customizer.php',
);

/**
 * Load template hooks and functions file.
 */
require SHAPLA_PATH . '/inc/shapla-functions.php';
require SHAPLA_PATH . '/inc/shapla-template-hooks.php';
require SHAPLA_PATH . '/inc/shapla-template-functions.php';

require SHAPLA_PATH . '/inc/class-shapla-structured-data.php';

/**
 * Customizer
 */
require SHAPLA_PATH . '/inc/customizer/init.php';

/**
 * Load Shapla modules
 */
include SHAPLA_PATH . '/inc/modules/class-shapla-blog.php';


/**
 * Load Jetpack compatibility class.
 */
if ( class_exists( 'Jetpack' ) ) {
	$shapla->jetpack = require SHAPLA_PATH . '/inc/jetpack/class-shapla-jetpack.php';
}

// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once SHAPLA_PATH . '/inc/elementor/class-shapla-elementor-pro.php';
}


if ( shapla_is_woocommerce_activated() ) {
	require SHAPLA_PATH . '/inc/woocommerce/class-shapla-woocommerce.php';
	require SHAPLA_PATH . '/inc/woocommerce/shapla-woocommerce-template-hooks.php';
	require SHAPLA_PATH . '/inc/woocommerce/shapla-woocommerce-template-functions.php';
}

if ( shapla_is_carousel_slider_activated() ) {
	require SHAPLA_PATH . '/inc/carousel-slider/class-shapla-carousel-slider.php';
}

if ( is_admin() ) {
	require SHAPLA_PATH . '/inc/admin/class-shapla-system-status.php';
	require SHAPLA_PATH . '/inc/admin/class-shapla-admin.php';
}

// Metabox
require SHAPLA_PATH . '/inc/admin/class-shapla-metabox.php';
require SHAPLA_PATH . '/inc/admin/class-shapla-page-metabox-fields.php';
