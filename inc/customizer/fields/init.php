<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * priorities of the core customize sections
 *
 * Site Title & Tagline ---> 20
 * Colors ---> 40
 * Header Image ---> 60 ===> 25
 * Background Image ---> 80 ===> 30
 * Menus (Panel) ---> 100
 * Widgets (Panel) ---> 110
 * Static Front Page ---> 120
 * Additional CSS ---> 200
 */
require SHAPLA_THEME_PATH . '/inc/customizer/fields/layout.php'; // priority - 10
require SHAPLA_THEME_PATH . '/inc/customizer/fields/theme-colors.php'; // priority - 20
require SHAPLA_THEME_PATH . '/inc/customizer/fields/typography.php'; // priority - 40
require SHAPLA_THEME_PATH . '/inc/customizer/fields/header.php'; // priority - 25 (Under Header Image)
require SHAPLA_THEME_PATH . '/inc/customizer/fields/page-title-bar.php'; // priority - 30
require SHAPLA_THEME_PATH . '/inc/customizer/fields/site_footer.php'; // priority - 30
require SHAPLA_THEME_PATH . '/inc/customizer/fields/blog.php'; // priority - 50
require SHAPLA_THEME_PATH . '/inc/customizer/fields/extra.php'; // priority - 190

if ( shapla_is_woocommerce_activated() ) {
	require SHAPLA_THEME_PATH . '/inc/customizer/fields/woocommerce.php'; // priority - 50
}
