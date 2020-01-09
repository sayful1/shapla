<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Add new section
$shapla->customizer->add_section( 'theme_colors', array(
	'title'       => __( 'Colors', 'shapla' ),
	'description' => __( 'Customise colors of your web site.', 'shapla' ),
	'priority'    => 20,
) );

// Primary color
$shapla->customizer->add_field( array(
	'settings'    => 'shapla_primary_color',
	'type'        => 'alpha-color',
	'section'     => 'theme_colors',
	'label'       => __( 'Primary Color', 'shapla' ),
	'description' => __( 'A primary color is the color displayed most frequently across your site.', 'shapla' ),
	'default'     => '#00d1b2',
	'priority'    => 10,
) );

// Secondary color
$shapla->customizer->add_field( array(
	'settings'    => 'shapla_secondary_color',
	'type'        => 'alpha-color',
	'section'     => 'theme_colors',
	'label'       => __( 'Secondary Color', 'shapla' ),
	'description' => __( 'Color for Links, Actions buttons, Highlighting text', 'shapla' ),
	'default'     => '#3273dc',
	'priority'    => 30,
) );

// Surface color
$shapla->customizer->add_field( array(
	'settings'    => 'shapla_surface_color',
	'type'        => 'alpha-color',
	'section'     => 'theme_colors',
	'label'       => __( 'Surface Color', 'shapla' ),
	'description' => __( 'Color for surfaces of components such as cards.', 'shapla' ),
	'default'     => '#ffffff',
	'priority'    => 50,
) );

// Error color
$shapla->customizer->add_field( array(
	'settings'    => 'shapla_success_color',
	'type'        => 'alpha-color',
	'section'     => 'theme_colors',
	'label'       => __( 'Success Color', 'shapla' ),
	'description' => __( 'Color for success in components.', 'shapla' ),
	'default'     => '#48c774',
	'priority'    => 70,
) );


// Error color
$shapla->customizer->add_field( array(
	'settings'    => 'shapla_error_color',
	'type'        => 'alpha-color',
	'section'     => 'theme_colors',
	'label'       => __( 'Error Color', 'shapla' ),
	'description' => __( 'Color for error in components.', 'shapla' ),
	'default'     => '#f14668',
	'priority'    => 70,
) );
