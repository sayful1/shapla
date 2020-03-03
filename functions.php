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

spl_autoload_register( function ( $className ) {
	// If class already exists, no need to include it
	if ( class_exists( $className ) ) {
		return;
	}

	// If class not related to theme, no need to include it
	if ( false === strpos( $className, 'Shapla' ) ) {
		return;
	}

	// Include our classes
	$file_name = 'class-' . strtolower( str_replace( '_', '-', $className ) ) . '.php';

	$directories = array(
		SHAPLA_PATH . '/classes/customize/controls/',
		SHAPLA_PATH . '/classes/integrations/carousel-slider/',
		SHAPLA_PATH . '/classes/integrations/elementor-pro/',
		SHAPLA_PATH . '/classes/integrations/jetpack/',
		SHAPLA_PATH . '/classes/integrations/woocommerce/',
		SHAPLA_PATH . '/classes/utilities/',
	);

	foreach ( $directories as $directory ) {
		if ( file_exists( $directory . $file_name ) ) {
			require_once $directory . $file_name;
		}
	}
} );

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

/**
 * Customizer
 */
require SHAPLA_PATH . '/inc/customizer/init.php';

/**
 * Load Shapla modules
 */
include SHAPLA_PATH . '/inc/modules/class-shapla-blog.php';

/**
 * Add structured data if enabled
 */
require SHAPLA_PATH . '/inc/class-shapla-structured-data.php';

if ( is_admin() ) {
	require SHAPLA_PATH . '/inc/admin/class-shapla-system-status.php';
	require SHAPLA_PATH . '/inc/admin/class-shapla-admin.php';

	// Metabox
	require SHAPLA_PATH . '/inc/admin/class-shapla-metabox.php';
	require SHAPLA_PATH . '/inc/admin/class-shapla-page-metabox-fields.php';
}

/**
 * Third party plugin integrations
 */
require SHAPLA_PATH . '/classes/integrations/integrations.php';
