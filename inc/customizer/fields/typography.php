<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
$shapla->customizer->add_panel( 'typography_panel', array(
	'title'    => __( 'Typography', 'shapla' ),
	'priority' => 40,
) );

// Add new section
$shapla->customizer->add_section( 'typography_colors_section', array(
	'title'    => __( 'Colors', 'shapla' ),
	'panel'    => 'typography_panel',
	'priority' => 10,
) );

// Primary color
$shapla->customizer->add_field( array(
	'settings'    => 'typography_primary_color',
	'section'     => 'typography_colors_section',
	'type'        => 'alpha-color',
	'label'       => __( 'Primary color', 'shapla' ),
	'description' => __( 'Set site primary color. Primary color will be used for link color, pagination', 'shapla' ),
	'default'     => shapla_default_options()->primary_color,
	'priority'    => 10,
	'output'      => array(
		array(
			'element'  => array(
				// General Link Color
				'a',
				'a:hover',
				'a:focus',
				'a:active',
				'a:visited',
				// Pagination
				'.navigation .page-numbers',
				'.navigation .nav-previous',
				'.navigation .nav-previous a',
				'.navigation .nav-next',
				'.navigation .nav-next a',
				// Breadcrumbs
				'.breadcrumb a',
			),
			'property' => 'color',
		),
		array(
			'element'  => array(
				// Pagination
				'.navigation .page-numbers.current',
			),
			'property' => 'background-color',
		),
		array(
			'element'  => array(
				// Pagination
				'.navigation .page-numbers.current',
			),
			'property' => 'border-color',
		),
	),
) );

// Heading color
$shapla->customizer->add_field( array(
	'settings'    => 'typography_heading_color',
	'section'     => 'typography_colors_section',
	'type'        => 'alpha-color',
	'label'       => __( 'Heading color', 'shapla' ),
	'description' => __( 'Heading color will be used for heading tags (h1, h2, h3, h4, h5, h6)', 'shapla' ),
	'default'     => shapla_default_options()->heading_color,
	'priority'    => 20,
	'output'      => array(
		array(
			'element'  => array(
				'.entry-title a',
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
			),
			'property' => 'color',
		),
	),
) );

// Text color
$shapla->customizer->add_field( array(
	'settings'    => 'typography_text_color',
	'section'     => 'typography_colors_section',
	'type'        => 'alpha-color',
	'label'       => __( 'Text color', 'shapla' ),
	'description' => __( 'Text color will be used for body', 'shapla' ),
	'default'     => shapla_default_options()->heading_color,
	'priority'    => 20,
	'output'      => array(
		array(
			'element'  => array(
				'body',
				'.hentry .entry-meta a',
				'.byline a',
				'.posted-on a',
			),
			'property' => 'color',
		),
	),
) );