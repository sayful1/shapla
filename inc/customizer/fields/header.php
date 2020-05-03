<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Change site title font size
Shapla_Customizer_Config::add_field( 'site_logo_text_font_size', array(
	'type'     => 'text',
	'section'  => 'header_image',
	'label'    => __( 'Site Title Font Size', 'shapla' ),
	'default'  => shapla_default_options( 'site_logo_text_font_size' ),
	'priority' => 40,
) );

// Site Title Color
Shapla_Customizer_Config::add_field( 'header_background_color', array(
	'type'     => 'alpha-color',
	'section'  => 'header_image',
	'label'    => __( 'Header Background Color', 'shapla' ),
	'default'  => shapla_default_options( 'header_background_color' ),
	'priority' => 10,
) );

// Header text color
Shapla_Customizer_Config::add_field( 'header_text_color', array(
	'type'     => 'alpha-color',
	'section'  => 'header_image',
	'label'    => __( 'Header Text Color', 'shapla' ),
	'default'  => shapla_default_options( 'header_text_color' ),
	'priority' => 20,
) );

// Header link color
Shapla_Customizer_Config::add_field( 'header_link_color', array(
	'type'     => 'alpha-color',
	'section'  => 'header_image',
	'label'    => __( 'Header Link Color', 'shapla' ),
	'default'  => shapla_default_options( 'header_link_color' ),
	'priority' => 30,
) );

// Sticky Header
Shapla_Customizer_Config::add_field( 'sticky_header', array(
	'type'        => 'toggle',
	'section'     => 'header_image',
	'label'       => __( 'Sticky Header', 'shapla' ),
	'description' => __( 'Check to to enable a sticky header.', 'shapla' ),
	'default'     => shapla_default_options( 'sticky_header' ),
	'priority'    => 40,
) );

// Toggle search icon
Shapla_Customizer_Config::add_field( 'show_search_icon', array(
	'type'        => 'toggle',
	'section'     => 'header_image',
	'label'       => __( 'Show Search Icon', 'shapla' ),
	'description' => __( 'Check to show search icon on navigation bar in header area.', 'shapla' ),
	'default'     => shapla_default_options( 'show_search_icon' ),
	'priority'    => 50,
) );

Shapla_Customizer_Config::add_field( 'dropdown_direction', array(
	'type'     => 'radio-button',
	'section'  => 'header_image',
	'label'    => __( 'Dropdown direction', 'shapla' ),
	'default'  => shapla_default_options( 'dropdown_direction' ),
	'priority' => 60,
	'choices'  => array(
		'ltr' => esc_html__( 'Left to Right', 'shapla' ),
		'rtl' => esc_html__( 'Right to Left', 'shapla' ),
	)
) );
