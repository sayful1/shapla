<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add Extra Panel
 */
$shapla->customizer->add_panel( 'extra_panel', array(
	'title'    => __( 'Extra', 'shapla' ),
	'priority' => 190,
) );

/**
 * Add Extra Sections
 */
$shapla->customizer->add_section( 'go_to_top_button_section', array(
	'title'    => __( 'Go to Top Button', 'shapla' ),
	'panel'    => 'extra_panel',
	'priority' => 10,
) );

/**
 * Go to Top Button Section
 */
$shapla->customizer->add_field( array(
	'settings'          => 'display_go_to_top_button',
	'type'              => 'toggle',
	'section'           => 'go_to_top_button_section',
	'label'             => __( 'Display Go to top button', 'shapla' ),
	'description'       => __( 'Enable it to display Go to Top button.', 'shapla' ),
	'default'           => true,
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 10,
) );
