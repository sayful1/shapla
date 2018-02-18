<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add global configuration
$shapla->customizer->add_config( array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );

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
require 'typography.php'; // priority - 40
require 'layout.php'; // priority - 10
require 'header.php'; // priority - 25 (Under Header Image)
require 'page-title-bar.php'; // priority - 30
require 'site_footer.php'; // priority - 30
require 'buttons.php'; // priority - 40
require 'blog.php'; // priority - 50
require 'extra.php'; // priority - 190

if ( shapla_is_woocommerce_activated() ) {
	require 'woocommerce.php'; // priority - 50
	require 'woocommerce-colors.php'; // priority - 50
}