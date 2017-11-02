<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new section
$shapla->customizer->add_section( 'typography_section', array(
	'title'    => __( 'Typography', 'shapla' ),
	'priority' => 40,
) );

// Primary color
$shapla->customizer->add_field( array(
	'settings'    => 'typography_primary_color',
	'section'     => 'typography_section',
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
				'.shapla-cart-contents .count',
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
	'section'     => 'typography_section',
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
	'section'     => 'typography_section',
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

// Text color
$shapla->customizer->add_field( array(
	'settings'    => 'google_font_family',
	'section'     => 'typography_section',
	'type'        => 'google-font',
	'label'       => __( 'Body font family', 'shapla' ),
	'description' => __( 'Font family will be used for body', 'shapla' ),
	'default'     => shapla_default_options()->font_family,
	'priority'    => 20,
	'output'      => array(
		array(
			'element'  => array(
				'body',
				'button',
				'input',
				'select',
				'textarea',
			),
			'property' => 'font-family',
		),
	),
) );