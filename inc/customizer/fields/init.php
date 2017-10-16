<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add global configuration
$shapla->customizer->add_config( array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );

$fields_dir = get_template_directory() . '/inc/customizer/fields';

require $fields_dir . '/title_tagline.php';
require $fields_dir . '/header.php';
require $fields_dir . '/site_footer.php';
require $fields_dir . '/buttons.php';
require $fields_dir . '/layout.php';
require $fields_dir . '/blog.php';

if ( shapla_is_woocommerce_activated() ) {
	require $fields_dir . '/woocommerce.php';
}