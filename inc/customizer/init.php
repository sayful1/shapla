<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add global configuration
$shapla->customizer->add_config( [
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
] );

require get_template_directory() . '/inc/customizer/title_tagline.php';
require get_template_directory() . '/inc/customizer/header.php';
require get_template_directory() . '/inc/customizer/site_footer.php';
require get_template_directory() . '/inc/customizer/buttons.php';
require get_template_directory() . '/inc/customizer/layout.php';
require get_template_directory() . '/inc/customizer/blog.php';

if ( shapla_is_woocommerce_activated() ) {
	require get_template_directory() . '/inc/customizer/woocommerce.php';
}