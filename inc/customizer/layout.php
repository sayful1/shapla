<?php
// Add new section
$shapla->customizer->add_section( 'layout_section', array(
	'title'       => __( 'Layout', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site layout.', 'shapla' ),
	'priority'    => 50,
) );

// Site Layout
$shapla->customizer->add_field( [
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
] );

// General Layout
$shapla->customizer->add_field( [
	'settings' => 'general_layout',
	'type'     => 'radio',
	'section'  => 'layout_section',
	'label'    => __( 'Sidebar Layout', 'shapla' ),
	'default'  => 'right-sidebar',
	'priority' => 10,
	'choices'  => array(
		'right-sidebar' => __( 'Right Sidebar', 'shapla' ),
		'left-sidebar'  => __( 'Left Sidebar', 'shapla' ),
		'full-width'    => __( 'No Sidebar', 'shapla' ),
	),
] );
