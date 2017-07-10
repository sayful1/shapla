<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'the_custom_logo' ) ) {
	$shapla->customizer->add_field([
		'settings' 	=> 'site_logo_image',
		'type' 		=> 'image',
		'section' 	=> 'title_tagline',
		'label' 	=> __('Logo', 'shapla'),
		'default' 	=> '',
		'description' 	=> __('Upload your site logo. You can upload any size (widths * heights). It will automatically adjust with the theme.', 'shapla'),
	]);
	$shapla->customizer->add_field( array(
		'settings' => 'site_logo_image_height',
		'type'     => 'text',
		'section'  => 'title_tagline',
		'label'    => __( 'Logo Image Height', 'shapla' ),
		'default'  => '35px',
		'priority' => 30,
		'output' => array(
			array(
				'element'  => '.site-header .site-branding img',
				'property' => 'height',
			),
		),
	));
}
