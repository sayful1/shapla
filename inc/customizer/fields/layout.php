<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new section
Shapla_Customizer_Config::add_section( 'layout_section', [
	'title'       => __( 'Layout', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site layout.', 'shapla' ),
	'priority'    => 10,
] );

// Site Layout
Shapla_Customizer_Config::add_field( 'site_layout', array(
	'type'        => 'radio-button',
	'section'     => 'layout_section',
	'label'       => __( 'Site Layout', 'shapla' ),
	'description' => __( 'Controls the site layout.', 'shapla' ),
	'default'     => shapla_default_options( 'site_layout' ),
	'priority'    => 10,
	'choices'     => array(
		'wide'  => __( 'Wide', 'shapla' ),
		'boxed' => __( 'Boxed', 'shapla' ),
	),
) );

// General Layout
Shapla_Customizer_Config::add_field( 'general_layout', array(
	'type'        => 'radio-image',
	'section'     => 'layout_section',
	'label'       => __( 'Sidebar Layout', 'shapla' ),
	'description' => __( 'Controls the site sidebar layout.', 'shapla' ),
	'default'     => shapla_default_options( 'general_layout' ),
	'priority'    => 20,
	'choices'     => array(
		'right-sidebar' => get_template_directory_uri() . '/assets/images/customizer/2cr.svg',
		'left-sidebar'  => get_template_directory_uri() . '/assets/images/customizer/2cl.svg',
		'full-width'    => get_template_directory_uri() . '/assets/images/customizer/1c.svg',
	),
) );

// Header Layout
Shapla_Customizer_Config::add_field( 'header_layout', array(
	'type'        => 'radio-image',
	'section'     => 'layout_section',
	'label'       => __( 'Header Layout', 'shapla' ),
	'description' => __( 'Controls the site header layout.', 'shapla' ),
	'default'     => shapla_default_options( 'header_layout' ),
	'priority'    => 30,
	'choices'     => array(
		'layout-1' => get_template_directory_uri() . '/assets/images/customizer/layout-1.svg',
		'layout-2' => get_template_directory_uri() . '/assets/images/customizer/layout-2.svg',
		'layout-3' => get_template_directory_uri() . '/assets/images/customizer/layout-3.svg',
	),
) );
