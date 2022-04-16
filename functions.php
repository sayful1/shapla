<?php
/**
 * Shapla functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
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

require_once SHAPLA_THEME_PATH . '/inc/classes/Autoloader.php';
$loader = new Shapla\Autoloader();
$loader->add_namespace( 'Shapla', SHAPLA_THEME_PATH . '/inc/classes' );
$loader->register();


require SHAPLA_THEME_PATH . '/inc/class-shapla-fonts.php';

/**
 * Load theme base functionality
 */
require SHAPLA_THEME_PATH . '/inc/class-shapla.php';

/**
 * Load customize functionality
 */
require SHAPLA_THEME_PATH . '/inc/class-shapla-customizer.php';

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
	require SHAPLA_THEME_PATH . '/inc/class-shapla-admin.php';
}

/**
 * Third party plugin integrations
 */
require SHAPLA_THEME_PATH . '/inc/classes/Integrations/integrations.php';
