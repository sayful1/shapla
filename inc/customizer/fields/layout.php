<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new section
$shapla->customizer->add_section( 'layout_section', array(
	'title'       => __( 'Layout', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site layout.', 'shapla' ),
	'priority'    => 50,
) );

// Site Layout
$shapla->customizer->add_field( array(
	'settings'    => 'site_layout',
	'type'        => 'radio',
	'section'     => 'layout_section',
	'label'       => __( 'Layout', 'shapla' ),
	'description' => __( 'Controls the site layout.', 'shapla' ),
	'default'     => 'wide',
	'priority'    => 10,
	'choices'     => array(
		'wide'  => __( 'Wide', 'shapla' ),
		'boxed' => __( 'Boxed', 'shapla' ),
	),
) );

// General Layout
$shapla->customizer->add_field( array(
	'settings'    => 'general_layout',
	'type'        => 'radio-image',
	'section'     => 'layout_section',
	'label'       => __( 'Sidebar Layout', 'shapla' ),
	'description' => __( 'Controls the site sidebar layout.', 'shapla' ),
	'default'     => 'right-sidebar',
	'priority'    => 20,
	'choices'     => array(
		'right-sidebar' => get_template_directory_uri() . '/assets/images/customizer/2cr.png',
		'left-sidebar'  => get_template_directory_uri() . '/assets/images/customizer/2cl.png',
		'full-width'    => get_template_directory_uri() . '/assets/images/customizer/1c.png',
	),
) );
