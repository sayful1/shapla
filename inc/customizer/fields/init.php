<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add global configuration
$shapla->customizer->add_config( array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );


require 'typography.php';
require 'header.php';
require 'site_footer.php';
require 'buttons.php';
require 'layout.php';
require 'blog.php';

if ( shapla_is_woocommerce_activated() ) {
	require 'woocommerce.php';
	require 'woocommerce-colors.php';
	require 'woocommerce-buttons.php';
}