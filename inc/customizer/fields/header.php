<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Change site title font size
$shapla->customizer->add_field( array(
	'settings' => 'site_logo_text_font_size',
	'type'     => 'text',
	'section'  => 'header_image',
	'label'    => __( 'Site Title Font Size', 'shapla' ),
	'default'  => shapla_default_options( 'site_logo_text_font_size' ),
	'priority' => 40,
	'output'   => array(
		array(
			'element'  => '.site-title',
			'property' => 'font-size',
		),
	),
) );

// Site Title Color
$shapla->customizer->add_field( array(
	'settings' => 'header_background_color',
	'type'     => 'alpha-color',
	'section'  => 'header_image',
	'label'    => __( 'Header Background Color', 'shapla' ),
	'default'  => shapla_default_options( 'header_background_color' ),
	'priority' => 10,
	'output'   => array(
		array(
			'element'  => '.site-header',
			'property' => 'background-color',
		),
	),
) );

// Header text color
$shapla->customizer->add_field( array(
	'settings' => 'header_text_color',
	'type'     => 'alpha-color',
	'section'  => 'header_image',
	'label'    => __( 'Header Text Color', 'shapla' ),
	'default'  => shapla_default_options( 'header_text_color' ),
	'priority' => 20,
	'output'   => array(
		array(
			'element'  => array(
				'.site-title > a',
				'.site-title > a:hover',
				'.site-title > a:focus',
				'.site-description',
				'.dropdown-toggle',
				'.main-navigation a',
				'.search-toggle i.fa-search'
			),
			'property' => 'color',
		),
		array(
			'element'  => array(
				'.menu-toggle span',
			),
			'property' => 'background-color',
		),
		array(
			'element'  => array(
				'a.shapla-cart-contents',
			),
			'property' => 'color',
		),
	),
) );

// Header link color
$shapla->customizer->add_field( array(
	'settings' => 'header_link_color',
	'type'     => 'alpha-color',
	'section'  => 'header_image',
	'label'    => __( 'Header Link Color', 'shapla' ),
	'default'  => shapla_default_options( 'header_link_color' ),
	'priority' => 30,
	'output'   => array(
		array(
			'element'  => array(
				'.dropdown-toggle:hover',
				'.dropdown-toggle:focus',
				'.main-navigation .current-menu-item > a',
				'.main-navigation .current-menu-ancestor > a',
				'.main-navigation a:hover',
				'.main-navigation a:focus',
			),
			'property' => 'color',
		),
		array(
			'element'     => array(
				'.main-navigation li:hover > a',
				'.main-navigation li:focus > a',
			),
			'property'    => 'color',
			'media_query' => '@media screen and (min-width: 769px)'
		),
	),
) );

// Sticky Header
$shapla->customizer->add_field( array(
	'settings'    => 'sticky_header',
	'type'        => 'toggle',
	'section'     => 'header_image',
	'label'       => __( 'Sticky Header', 'shapla' ),
	'description' => __( 'Check to to enable a sticky header.', 'shapla' ),
	'default'     => shapla_default_options( 'sticky_header' ),
	'priority'    => 40,
) );

// Toggle search icon
$shapla->customizer->add_field( array(
	'settings'    => 'show_search_icon',
	'type'        => 'toggle',
	'section'     => 'header_image',
	'label'       => __( 'Show Search Icon', 'shapla' ),
	'description' => __( 'Check to show search icon on navigation bar in header area.', 'shapla' ),
	'default'     => shapla_default_options( 'show_search_icon' ),
	'priority'    => 50,
) );

$shapla->customizer->add_field( array(
	'settings' => 'dropdown_direction',
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
