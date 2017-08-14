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
	'default'  => '30px',
	'priority' => 40,
	'output'   => array(
		array(
			'element'  => '.site-title',
			'property' => 'font-size',
		),
	),
) );

// Toggle search icon
$shapla->customizer->add_field( array(
	'settings'    => 'show_search_icon',
	'type'        => 'checkbox',
	'section'     => 'header_image',
	'label'       => __( 'Show Search Icon', 'shapla' ),
	'description' => __( 'Check to show search icon on navigation bar in header area.', 'shapla' ),
	'default'     => 0,
	'priority'    => 50,
) );

// Site Title Color
$shapla->customizer->add_field( [
	'settings' => 'header_background_color',
	'type'     => 'color',
	'section'  => 'header_image',
	'label'    => __( 'Header Background Color', 'shapla' ),
	'default'  => '#212a34',
	'priority' => 10,
	'output'   => array(
		array(
			'element'  => '.site-header',
			'property' => 'background-color',
		),
	),
] );

// Header text color
$shapla->customizer->add_field( [
	'settings' => 'header_text_color',
	'type'     => 'color',
	'section'  => 'header_image',
	'label'    => __( 'Header Text Color', 'shapla' ),
	'default'  => '#f1f1f1',
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
	),
] );

// Header link color
$shapla->customizer->add_field( [
	'settings' => 'header_link_color',
	'type'     => 'color',
	'section'  => 'header_image',
	'label'    => __( 'Header Link Color', 'shapla' ),
	'default'  => '#96588a',
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
] );

// Sticky Header
$shapla->customizer->add_field( array(
	'settings'    => 'sticky_header',
	'type'        => 'checkbox',
	'section'     => 'header_image',
	'label'       => __( 'Sticky Header', 'shapla' ),
	'description' => __( 'Check to to enable a sticky header.', 'shapla' ),
	'default'     => false,
	'priority'    => 40,
) );