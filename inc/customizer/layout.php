<?php
// Add new section
$shapla->customizer->add_section('layout_section', array(
	'title' 		=> __('Layout', 'shapla'),
	'description' 	=> __('Customise the look & feel of your web site layout.', 'shapla'),
	'priority' 		=> 50,
));

// General Layout
$shapla->customizer->add_field([
	'settings'    => 'general_layout',
	'type'        => 'radio',
	'section'     => 'layout_section',
	'label'       => __( 'General Layout', 'shapla' ),
	'default'     => 'right-sidebar',
	'priority'    => 10,
	'choices'	  => array(
		'right-sidebar' => __( 'Right Sidebar', 'shapla' ),
		'left-sidebar' 	=> __( 'Left Sidebar', 'shapla' ),
		'full-width' 	=> __( 'No Sidebar', 'shapla' ),
	),
]);