<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
Shapla_Customizer_Config::add_panel( 'page_title_bar_panel', array(
	'title'    => __( 'Page Title Bar', 'shapla' ),
	'priority' => 30,
) );

// Add new section
Shapla_Customizer_Config::add_section( 'breadcrumbs', array(
	'title'    => __( 'Breadcrumbs', 'shapla' ),
	'priority' => 20,
	'panel'    => 'page_title_bar_panel',
) );

// Add new section
Shapla_Customizer_Config::add_section( 'page_title_bar', array(
	'title'    => __( 'Page Title Bar', 'shapla' ),
	'priority' => 10,
	'panel'    => 'page_title_bar_panel',
) );

// Top and Bottom Padding
Shapla_Customizer_Config::add_field( 'page_title_bar_padding', array(
	'type'        => 'text',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Bar Top &amp; Bottom Padding', 'shapla' ),
	'description' => __( 'Controls the top and bottom padding of the page title bar. Enter value including any valid CSS unit(px,em,rem)',
		'shapla' ),
	'default'     => shapla_default_options( 'page_title_bar_padding' ),
	'priority'    => 10,
) );

// Border Color
Shapla_Customizer_Config::add_field( 'page_title_bar_border_color', array(
	'type'        => 'alpha-color',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Bar Borders Color', 'shapla' ),
	'description' => __( 'Controls the border colors of the page title bar.', 'shapla' ),
	'default'     => shapla_default_options( 'page_title_bar_border_color' ),
	'priority'    => 20,
) );

// Page Title Bar Text Alignment
Shapla_Customizer_Config::add_field( 'page_title_bar_text_alignment', array(
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

Shapla_Customizer_Config::add_field( 'page_title_bar_background', array(
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
) );

// Page Title Typography
Shapla_Customizer_Config::add_field( 'page_title_typography', array(
	'type'        => 'typography',
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
) );

// Page Title Bar Text Alignment
Shapla_Customizer_Config::add_field( 'breadcrumbs_content_display', array(
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
Shapla_Customizer_Config::add_field( 'breadcrumbs_on_mobile_devices', array(
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
Shapla_Customizer_Config::add_field( 'breadcrumbs_separator', array(
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
