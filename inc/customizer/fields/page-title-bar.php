<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
$shapla->customizer->add_panel( 'page_title_bar_panel', array(
	'title'    => __( 'Page Title Bar', 'shapla' ),
	'priority' => 30,
) );

// Add new section
$shapla->customizer->add_section( 'breadcrumbs', array(
	'title'    => __( 'Breadcrumbs', 'shapla' ),
	'priority' => 20,
	'panel'    => 'page_title_bar_panel',
) );

// Add new section
$shapla->customizer->add_section( 'page_title_bar', array(
	'title'    => __( 'Page Title Bar', 'shapla' ),
	'priority' => 10,
	'panel'    => 'page_title_bar_panel',
) );

// Top and Bottom Padding
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_bar_padding',
	'type'        => 'text',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Bar Top &amp; Bottom Padding', 'shapla' ),
	'description' => __( 'Controls the top and bottom padding of the page title bar. Enter value including any valid CSS unit(px,em,rem)',
		'shapla' ),
	'default'     => shapla_default_options( 'page_title_bar_padding' ),
	'priority'    => 10,
	'output'      => array(
		array(
			'element'     => array(
				'.page-title-bar',
			),
			'property'    => 'padding-top',
			'media_query' => '@media screen and (min-width: 769px)',
		),
		array(
			'element'     => array(
				'.page-title-bar',
			),
			'property'    => 'padding-bottom',
			'media_query' => '@media screen and (min-width: 769px)',
		),
	),
) );

// Border Color
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_bar_border_color',
	'type'        => 'alpha-color',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Bar Borders Color', 'shapla' ),
	'description' => __( 'Controls the border colors of the page title bar.', 'shapla' ),
	'default'     => shapla_default_options( 'page_title_bar_border_color' ),
	'priority'    => 20,
	'output'      => array(
		array(
			'element'  => array(
				'.page-title-bar',
			),
			'property' => 'border-top-color',
		),
		array(
			'element'  => array(
				'.page-title-bar',
			),
			'property' => 'border-bottom-color',
		),
	),
) );

// Page Title Bar Text Alignment
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_bar_text_alignment',
	'type'        => 'select',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Bar Text Alignment', 'shapla' ),
	'description' => __( 'Controls the page title bar text alignment.', 'shapla' ),
	'default'     => shapla_default_options( 'page_title_bar_text_alignment' ),
	'priority'    => 30,
	'choices'     => array(
		'all_left'  => __( 'Left', 'shapla' ),
		'centered'  => __( 'Centered', 'shapla' ),
		'all_right' => __( 'Right', 'shapla' ),
		'left'      => __( 'Left Title &amp; Right Breadcrumbs', 'shapla' ),
		'right'     => __( 'Left Breadcrumbs &amp; Right Title', 'shapla' ),
	),
) );

$shapla->customizer->add_field( array(
	'settings'    => 'page_title_bar_background',
	'type'        => 'background',
	'label'       => esc_attr__( 'Page Title Bar Background', 'shapla' ),
	'description' => esc_attr__( 'Controls the background of the page title bar.', 'shapla' ),
	'section'     => 'page_title_bar',
	'priority'    => 40,
	'default'     => array(
		'background-color'      => shapla_default_options( 'page_title_bar_background_color' ),
		'background-image'      => shapla_default_options( 'page_title_bar_background_image' ),
		'background-repeat'     => shapla_default_options( 'page_title_bar_background_repeat' ),
		'background-position'   => shapla_default_options( 'page_title_bar_background_position' ),
		'background-size'       => shapla_default_options( 'page_title_bar_background_size' ),
		'background-attachment' => shapla_default_options( 'page_title_bar_background_attachment' ),
	),
	'output'      => array(
		array(
			'element' => array(
				'.page-title-bar',
			),
		),
	),
) );

// Page Title Typography
$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'page_title_typography',
	'section'     => 'page_title_bar',
	'label'       => esc_attr__( 'Page Title Typography', 'shapla' ),
	'description' => esc_attr__( 'Control the typography for page title.', 'shapla' ),
	'default'     => array(
		'font-size'      => shapla_default_options( 'page_title_font_size' ),
		'line-height'    => shapla_default_options( 'page_title_line_height' ),
		'color'          => shapla_default_options( 'page_title_font_color' ),
		'text-transform' => shapla_default_options( 'page_title_text_transform' ),
	),
	'priority'    => 50,
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
			'element' => '.page-title-bar .entry-title',
		),
	),
) );

// Page Title Bar Text Alignment
$shapla->customizer->add_field( array(
	'settings'    => 'breadcrumbs_content_display',
	'type'        => 'radio-button',
	'section'     => 'breadcrumbs',
	'label'       => __( 'Breadcrumbs Content Display', 'shapla' ),
	'description' => __( 'Controls what displays in the breadcrumbs area.', 'shapla' ),
	'default'     => shapla_default_options( 'breadcrumbs_content_display' ),
	'priority'    => 10,
	'choices'     => array(
		'none'       => __( 'None', 'shapla' ),
		'breadcrumb' => __( 'Breadcrumbs', 'shapla' ),
	),
) );

// Breadcrumbs on Mobile Devices
$shapla->customizer->add_field( array(
	'settings'    => 'breadcrumbs_on_mobile_devices',
	'type'        => 'radio-button',
	'section'     => 'breadcrumbs',
	'label'       => __( 'Breadcrumbs on Mobile Devices', 'shapla' ),
	'description' => __( 'Turn on to display breadcrumbs on mobile devices.', 'shapla' ),
	'default'     => shapla_default_options( 'breadcrumbs_on_mobile_devices' ),
	'priority'    => 20,
	'choices'     => array(
		'off' => __( 'Off', 'shapla' ),
		'on'  => __( 'On', 'shapla' ),
	),
) );

// Breadcrumbs Separator
$shapla->customizer->add_field( array(
	'settings'    => 'breadcrumbs_separator',
	'type'        => 'select',
	'section'     => 'breadcrumbs',
	'label'       => __( 'Breadcrumbs Separator', 'shapla' ),
	'description' => __( 'Controls the type of separator between each breadcrumb. ', 'shapla' ),
	'default'     => shapla_default_options( 'breadcrumbs_separator' ),
	'priority'    => 30,
	'choices'     => array(
		'slash'    => __( 'Slash', 'shapla' ),
		'arrow'    => __( 'Arrow', 'shapla' ),
		'bullet'   => __( 'Bullet', 'shapla' ),
		'dot'      => __( 'Dot', 'shapla' ),
		'succeeds' => __( 'Succeeds', 'shapla' ),
	),
) );

$shapla->customizer->add_field( array(
	'type'        => 'typography',
	'settings'    => 'breadcrumbs_typography',
	'section'     => 'breadcrumbs',
	'label'       => esc_attr__( 'Breadcrumbs Typography', 'shapla' ),
	'description' => esc_attr__( 'Control the typography for breadcrumbs.', 'shapla' ),
	'default'     => array(
		'font-size'      => shapla_default_options( 'breadcrumbs_font_size' ),
		'color'          => shapla_default_options( 'breadcrumbs_text_color' ),
		'text-transform' => shapla_default_options( 'breadcrumbs_text_transform' ),
	),
	'priority'    => 50,
	'output'      => array(
		array(
			'element' => array( '.breadcrumb', '.breadcrumb a' ),
		),
	),
) );
