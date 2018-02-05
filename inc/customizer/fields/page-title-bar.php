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
	'default'     => shapla_default_options()->title_bar->padding,
	'priority'    => 10,
	'output'      => array(
		array(
			'element'  => array(
				'.page-title-bar',
			),
			'property' => 'padding-top',
		),
		array(
			'element'  => array(
				'.page-title-bar',
			),
			'property' => 'padding-bottom',
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
	'default'     => shapla_default_options()->title_bar->border_color,
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

// Page Title Font Size
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_font_size',
	'type'        => 'text',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Font Size', 'shapla' ),
	'description' => __( 'Controls the font size for the page title heading. Enter value including CSS unit (px, em, rem), ex: 18px',
		'shapla' ),
	'default'     => shapla_default_options()->title_bar->font_size,
	'priority'    => 30,
	'output'      => array(
		array(
			'element'  => array(
				'.page-title-bar .entry-title',
			),
			'property' => 'font-size',
		),
	),
) );

// Page Title Line Height
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_line_height',
	'type'        => 'text',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Line Height', 'shapla' ),
	'description' => __( 'Controls the line height for the page title heading. Enter value including any valid CSS unit, ex: 1.4.',
		'shapla' ),
	'default'     => shapla_default_options()->title_bar->line_height,
	'priority'    => 40,
	'output'      => array(
		array(
			'element'  => array(
				'.page-title-bar .entry-title',
			),
			'property' => 'line-height',
		),
	),
) );

// Page Title Font Color
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_font_color',
	'type'        => 'alpha-color',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Font Color', 'shapla' ),
	'description' => __( 'Controls the text color of the page title fonts.', 'shapla' ),
	'default'     => shapla_default_options()->title_bar->title_font_color,
	'priority'    => 50,
	'output'      => array(
		array(
			'element'  => array(
				'.page-title-bar .entry-title',
			),
			'property' => 'color',
		),
	),
) );

// Page Title Bar Text Transform
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_text_transform',
	'type'        => 'select',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Text Transform', 'shapla' ),
	'description' => __( 'Controls the page title text transform.', 'shapla' ),
	'default'     => shapla_default_options()->title_bar->text_transform,
	'priority'    => 60,
	'choices'     => array(
		'none'       => __( 'Default', 'shapla' ),
		'capitalize' => __( 'Capitalize', 'shapla' ),
		'uppercase'  => __( 'Uppercase', 'shapla' ),
		'lowercase'  => __( 'Lowercase', 'shapla' ),
	),
	'output'      => array(
		array(
			'element'  => array(
				'.page-title-bar .entry-title',
			),
			'property' => 'text-transform',
		),
	),
) );

// Page Title Font Weight
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_font_weight',
	'type'        => 'select',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Font Weight', 'shapla' ),
	'description' => __( 'Controls the page title font weight.', 'shapla' ),
	'default'     => shapla_default_options()->title_bar->font_weight,
	'priority'    => 70,
	'choices'     => array(
		'100' => __( '100 - thin', 'shapla' ),
		'200' => __( '200 - extra-light', 'shapla' ),
		'300' => __( '300 - light', 'shapla' ),
		'400' => __( '400 - normal', 'shapla' ),
		'500' => __( '500 - medium', 'shapla' ),
		'600' => __( '600 - semi-bold', 'shapla' ),
		'700' => __( '700 - bold', 'shapla' ),
		'800' => __( '800', 'shapla' ),
		'900' => __( '900 - bolder', 'shapla' ),
	),
	'output'      => array(
		array(
			'element'  => array(
				'.page-title-bar .entry-title',
			),
			'property' => 'font-weight',
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
	'default'     => shapla_default_options()->title_bar->text_alignment,
	'priority'    => 80,
	'choices'     => array(
		'all_left'  => __( 'Left', 'shapla' ),
		'centered'  => __( 'Centered', 'shapla' ),
		'all_right' => __( 'Right', 'shapla' ),
		'left'      => __( 'Left Title &amp; Right Breadcrumbs', 'shapla' ),
		'right'     => __( 'Left Breadcrumbs &amp; Right Title', 'shapla' ),
	),
) );

$shapla->customizer->add_field( array(
	'type'        => 'background',
	'settings'    => 'page_title_bar_background',
	'label'       => esc_attr__( 'Page Title Bar Background', 'shapla' ),
	'description' => esc_attr__( 'Controls the background of the page title bar.', 'shapla' ),
	'section'     => 'page_title_bar',
	'priority'    => 90,
	'default'     => array(
		'background-color'      => '#f5f5f5',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'fixed',
	),
	'output'      => array(
		array(
			'element' => array(
				'.page-title-bar',
			),
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
	'default'     => shapla_default_options()->breadcrumbs->content_display,
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
	'default'     => shapla_default_options()->breadcrumbs->visible_on_mobile,
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
	'default'     => shapla_default_options()->breadcrumbs->separator,
	'priority'    => 30,
	'choices'     => array(
		'slash'    => __( 'Slash', 'shapla' ),
		'arrow'    => __( 'Arrow', 'shapla' ),
		'bullet'   => __( 'Bullet', 'shapla' ),
		'dot'      => __( 'Dot', 'shapla' ),
		'succeeds' => __( 'Succeeds', 'shapla' ),
	),
) );

// Breadcrumbs Font Size
$shapla->customizer->add_field( array(
	'settings'    => 'breadcrumbs_font_size',
	'type'        => 'text',
	'section'     => 'breadcrumbs',
	'label'       => __( 'Breadcrumbs Font Size', 'shapla' ),
	'description' => __( 'Controls the font size for the breadcrumbs text. Enter value including CSS unit (px, em, rem), ex: 10px.',
		'shapla' ),
	'default'     => shapla_default_options()->breadcrumbs->font_size,
	'priority'    => 40,
	'output'      => array(
		array(
			'element'  => array(
				'.breadcrumb',
			),
			'property' => 'font-size',
		),
	),
) );

// Breadcrumbs Text Color
$shapla->customizer->add_field( array(
	'settings'    => 'breadcrumbs_text_color',
	'type'        => 'alpha-color',
	'section'     => 'breadcrumbs',
	'label'       => __( 'Breadcrumbs Text Color', 'shapla' ),
	'description' => __( 'Controls the text color of the breadcrumbs font.', 'shapla' ),
	'default'     => shapla_default_options()->breadcrumbs->font_color,
	'priority'    => 60,
	'output'      => array(
		array(
			'element'  => array(
				'.breadcrumb li',
				'.breadcrumb li + li::before',
				'.breadcrumb span',
				'.breadcrumb a',
				'.breadcrumb a:hover',
			),
			'property' => 'color',
		),
	),
) );

// Page Title Bar Text Transform
$shapla->customizer->add_field( array(
	'settings'    => 'breadcrumbs_text_transform',
	'type'        => 'select',
	'section'     => 'breadcrumbs',
	'label'       => __( 'Breadcrumbs Text Transform', 'shapla' ),
	'description' => __( 'Controls the breadcrumbs text transform.', 'shapla' ),
	'default'     => shapla_default_options()->breadcrumbs->text_transform,
	'priority'    => 70,
	'choices'     => array(
		'none'       => __( 'Default', 'shapla' ),
		'capitalize' => __( 'Capitalize', 'shapla' ),
		'uppercase'  => __( 'Uppercase', 'shapla' ),
		'lowercase'  => __( 'Lowercase', 'shapla' ),
	),
	'output'      => array(
		array(
			'element'  => array(
				'.breadcrumb li',
				'.breadcrumb span',
				'.breadcrumb a',
			),
			'property' => 'text-transform',
		),
	),
) );
