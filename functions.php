<?php
/**
 * Shapla functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shapla
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Define theme constants
 */
define( 'SHAPLA_THEME_VERSION', wp_get_theme( 'shapla' )->get( 'Version' ) );
define( 'SHAPLA_THEME_PATH', dirname( __FILE__ ) );
define( 'SHAPLA_THEME_URI', untrailingslashit( get_template_directory_uri() ) );


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
		SHAPLA_THEME_PATH . '/classes/customize/controls/',
		SHAPLA_THEME_PATH . '/classes/utilities/',
	);

	foreach ( $directories as $directory ) {
		if ( file_exists( $directory . $file_name ) ) {
			require_once $directory . $file_name;
		}
	}
} );

require SHAPLA_THEME_PATH . '/inc/class-shapla.php';

/**
 * Load customize functionality
 */
require SHAPLA_THEME_PATH . '/inc/customizer/class-shapla-customizer.php';

/**
 * Load Shapla blog
 */
include SHAPLA_THEME_PATH . '/inc/class-shapla-blog.php';

/**
 * Load template hooks and functions file.
 */
require SHAPLA_THEME_PATH . '/inc/shapla-functions.php';
require SHAPLA_THEME_PATH . '/inc/shapla-template-hooks.php';
require SHAPLA_THEME_PATH . '/inc/shapla-template-functions.php';

/**
 * Load theme scripts and styles
 */
require SHAPLA_THEME_PATH . '/inc/class-shapla-assets.php';

/**
 * Add structured data if enabled
 */
require SHAPLA_THEME_PATH . '/inc/class-shapla-structured-data.php';

if ( is_admin() ) {
	require SHAPLA_THEME_PATH . '/inc/admin/class-shapla-system-status.php';
	require SHAPLA_THEME_PATH . '/inc/admin/class-shapla-admin.php';

	// Metabox
	require SHAPLA_THEME_PATH . '/inc/admin/class-shapla-metabox.php';
	require SHAPLA_THEME_PATH . '/inc/admin/class-shapla-page-metabox-fields.php';
}

/**
 * Third party plugin integrations
 */
require SHAPLA_THEME_PATH . '/classes/integrations/integrations.php';
