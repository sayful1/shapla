<?php
/**
 * Shapla functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shapla
 */

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
require 'inc/shapla-functions.php';
require 'inc/shapla-template-hooks.php';
require 'inc/shapla-template-functions.php';

require 'inc/class-shapla-structured-data.php';
require 'inc/customizer/fields/init.php';

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


if ( shapla_is_woocommerce_activated() ) {
	$shapla->woocommerce = require 'inc/woocommerce/class-shapla-woocommerce.php';
	require 'inc/woocommerce/shapla-woocommerce-template-hooks.php';
	require 'inc/woocommerce/shapla-woocommerce-template-functions.php';
}


if ( is_admin() ) {
	require 'inc/admin/class-shapla-admin.php';
	require 'inc/admin/class-shapla-meta-boxes.php';
}