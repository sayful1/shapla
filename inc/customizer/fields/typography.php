<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add Typography Panel
 */
$shapla->customizer->add_panel( 'typography_panel', array(
	'title'    => __( 'Typography', 'shapla' ),
	'priority' => 40,
) );

/**
 * Add Typography Sections
 */
$shapla->customizer->add_section( 'body_typography_section', array(
	'title'    => __( 'Body Typography', 'shapla' ),
	'panel'    => 'typography_panel',
	'priority' => 10,
) );
$shapla->customizer->add_section( 'headers_typography_section', array(
	'title'    => __( 'Headers Typography', 'shapla' ),
	'panel'    => 'typography_panel',
	'priority' => 20,
) );

/**
 * Body Typography Section
 */
$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'body_typography',
	'section'     => 'body_typography_section',
	'label'       => esc_attr__( 'Body Typography', 'shapla' ),
	'description' => esc_attr__( 'These settings control the typography for all body text.', 'shapla' ),
	'default'     => array(
		'font-family' => shapla_default_options( 'font_family' ),
		'variant'     => '400',
		'font-size'   => '1rem',
		'line-height' => '1.5',
		// 'color'          => shapla_default_options( 'text_color' ),
		// 'text-transform' => 'none',
		// 'text-align'     => 'left'
	),
	'priority'    => 10,
	'choices'     => array(
		'fonts'       => array(
			'standard' => array(
				'serif',
				'sans-serif',
			),
		),
		'font-backup' => true
	),
	'output'      => array(
		array(
			'element' => array(
				'body',
				'button',
				'input',
				'select',
				'textarea',
			),
		),
	),
) );

/**
 * Headers Section
 */
$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'headers_typography',
	'section'     => 'headers_typography_section',
	'label'       => esc_attr__( 'Headers Typography', 'shapla' ),
	'description' => esc_attr__( 'These settings control the typography for all H1, H2, H3, H4, H5, H6 Headers.', 'shapla' ),
	'default'     => array(
		'font-family'    => shapla_default_options( 'font_family' ),
		'variant'        => '500',
		'text-transform' => 'none',
		// 'color'          => shapla_default_options( 'heading_color' ),
		// 'text-align'     => 'left'
	),
	'priority'    => 10,
	'choices'     => array(
		'fonts' => array(
			'standard' => array(
				'serif',
				'sans-serif',
			),
		),
	),
	'output'      => array(
		array(
			'element' => 'h1,h2,h3,h4,h5,h6',
		),
	),
) );
$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'h1_headers_typography',
	'section'     => 'headers_typography_section',
	'label'       => esc_attr__( 'H1 Headers Typography', 'shapla' ),
	'description' => esc_attr__( 'These settings control the typography for all H1 Headers.', 'shapla' ),
	'default'     => array(
		'font-size'   => '2.5rem',
		'line-height' => '1.2',
	),
	'priority'    => 20,
	'output'      => array(
		array(
			'element' => 'h1',
		),
	),
) );

$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'h2_headers_typography',
	'section'     => 'headers_typography_section',
	'label'       => esc_attr__( 'H2 Headers Typography', 'shapla' ),
	'description' => esc_attr__( 'These settings control the typography for all H2 Headers.', 'shapla' ),
	'priority'    => 30,
	'default'     => array(
		'font-size'   => '2rem',
		'line-height' => '1.2',
	),
	'output'      => array(
		array(
			'element' => 'h2',
		),
	),
) );

$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'h3_headers_typography',
	'section'     => 'headers_typography_section',
	'label'       => esc_attr__( 'H3 Headers Typography', 'shapla' ),
	'description' => esc_attr__( 'These settings control the typography for all H3 Headers.', 'shapla' ),
	'priority'    => 40,
	'default'     => array(
		'font-size'   => '1.75rem',
		'line-height' => '1.2',
	),
	'output'      => array(
		array(
			'element' => 'h3',
		),
	),
) );

$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'h4_headers_typography',
	'section'     => 'headers_typography_section',
	'label'       => esc_attr__( 'H4 Headers Typography', 'shapla' ),
	'description' => esc_attr__( 'These settings control the typography for all H4 Headers.', 'shapla' ),
	'priority'    => 50,
	'default'     => array(
		'font-size'   => '1.5rem',
		'line-height' => '1.2',
	),
	'output'      => array(
		array(
			'element' => 'h4',
		),
	),
) );

$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'h5_headers_typography',
	'section'     => 'headers_typography_section',
	'label'       => esc_attr__( 'H5 Headers Typography', 'shapla' ),
	'description' => esc_attr__( 'These settings control the typography for all H5 Headers.', 'shapla' ),
	'priority'    => 50,
	'default'     => array(
		'font-size'   => '1.25rem',
		'line-height' => '1.2',
	),
	'output'      => array(
		array(
			'element' => 'h5',
		),
	),
) );

$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'h6_headers_typography',
	'section'     => 'headers_typography_section',
	'label'       => esc_attr__( 'H6 Headers Typography', 'shapla' ),
	'description' => esc_attr__( 'These settings control the typography for all H6 Headers.', 'shapla' ),
	'priority'    => 50,
	'default'     => array(
		'font-size'   => '1rem',
		'line-height' => '1.2',
	),
	'output'      => array(
		array(
			'element' => 'h6',
		),
	),
) );

$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'post_titles_typography',
	'section'     => 'headers_typography_section',
	'label'       => esc_attr__( 'Post Titles Typography', 'shapla' ),
	'description' => esc_attr__( 'Controls the font size and line height of post titles including archive and single posts. This is a H2 heading. Enter value including CSS unit (px, em, rem), ex: 18px.', 'shapla' ),
	'priority'    => 50,
	'default'     => array(
		'font-size'   => '1.25rem',
		'line-height' => '1.2',
	),
	'output'      => array(
		array(
			'element' => array(
				'.blog-grid .blog-grid-inside .entry-title',
			),
		),
	),
) );
