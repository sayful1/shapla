<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add Extra Panel
 */
Shapla_Customizer_Config::add_panel( 'extra_panel', array(
	'title'    => __( 'Extra', 'shapla' ),
	'priority' => 190,
) );

/**
 * Add Go to Top Button Sections
 */
Shapla_Customizer_Config::add_section( 'go_to_top_button_section', array(
	'title'    => __( 'Go to Top Button', 'shapla' ),
	'panel'    => 'extra_panel',
	'priority' => 10,
) );

/**
 * Add Structured Data Sections
 */
Shapla_Customizer_Config::add_section( 'structured_data_section', array(
	'title'    => __( 'Structured Data', 'shapla' ),
	'panel'    => 'extra_panel',
	'priority' => 20,
) );

/**
 * Display Go to top button field
 */
Shapla_Customizer_Config::add_field( 'display_go_to_top_button', array(
	'type'              => 'toggle',
	'section'           => 'go_to_top_button_section',
	'label'             => __( 'Display Go to top button', 'shapla' ),
	'description'       => __( 'Enable it to display Go to Top button.', 'shapla' ),
	'default'           => true,
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 10,
) );

/**
 * Go to Top Button Section
 */
Shapla_Customizer_Config::add_field( 'show_structured_data', array(
	'type'              => 'toggle',
	'section'           => 'structured_data_section',
	'label'             => __( 'Enable Structured Data', 'shapla' ),
	'description'       => __( 'Structured Data helps search engine to understand the content of a web page. You may disable it if you are already using a SEO plugin.', 'shapla' ),
	'default'           => true,
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 10,
) );
