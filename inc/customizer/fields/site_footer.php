<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
Shapla_Customizer_Config::add_panel( 'site_footer_panel', array(
	'title'       => __( 'Footer', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site footer.', 'shapla' ),
	'priority'    => 30,
) );
// Add new section
Shapla_Customizer_Config::add_section( 'site_footer_widgets', array(
	'title'       => __( 'Widgets', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site footer widget area.', 'shapla' ),
	'panel'       => 'site_footer_panel',
	'priority'    => 10,
) );
Shapla_Customizer_Config::add_section( 'site_footer_bottom_bar', array(
	'title'       => __( 'Bottom Bar', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site footer bottom bar.', 'shapla' ),
	'panel'       => 'site_footer_panel',
	'priority'    => 20,
) );

// Footer Widget Rows
Shapla_Customizer_Config::add_field( 'footer_widget_rows', array(
	'type'        => 'range-slider',
	'section'     => 'site_footer_widgets',
	'label'       => __( 'Footer Widget Rows', 'shapla' ),
	'description' => __( 'Select the number of widgets rows you want in the footer. After changing value, save and refresh the page.', 'shapla' ),
	'default'     => shapla_default_options( 'footer_widget_rows' ),
	'priority'    => 10,
	'input_attrs' => array(
		'min'  => 1,
		'max'  => 10,
		'step' => 1,
	),
) );
// Footer Widget Columns
Shapla_Customizer_Config::add_field( 'footer_widget_columns', array(
	'type'        => 'range-slider',
	'section'     => 'site_footer_widgets',
	'label'       => __( 'Footer Widget Columns', 'shapla' ),
	'description' => __( 'Select the number of columns you want in each widgets rows in the footer.  After changing value, save and refresh the page.', 'shapla' ),
	'default'     => shapla_default_options( 'footer_widget_columns' ),
	'priority'    => 20,
	'input_attrs' => array(
		'min'  => 1,
		'max'  => 10,
		'step' => 1,
	),
) );

Shapla_Customizer_Config::add_field( 'footer_widget_background', array(
	'type'        => 'background',
	'label'       => esc_attr__( 'Footer Widget Area Background', 'shapla' ),
	'description' => esc_attr__( 'Controls the background of the footer widget area.', 'shapla' ),
	'section'     => 'site_footer_widgets',
	'priority'    => 50,
	'default'     => array(
		'background-color'      => shapla_default_options( 'footer_widget_background_color' ),
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'fixed',
	),
) );

Shapla_Customizer_Config::add_field( 'footer_widget_text_color', array(
	'type'     => 'alpha-color',
	'section'  => 'site_footer_widgets',
	'label'    => __( 'Text Color', 'shapla' ),
	'default'  => shapla_default_options( 'footer_widget_text_color' ),
	'priority' => 30,
) );

Shapla_Customizer_Config::add_field( 'footer_widget_link_color', array(
	'type'     => 'alpha-color',
	'section'  => 'site_footer_widgets',
	'label'    => __( 'Link Color', 'shapla' ),
	'default'  => shapla_default_options( 'footer_widget_link_color' ),
	'priority' => 40,
) );

// Site Footer Bottom Bar Background Color
Shapla_Customizer_Config::add_field( 'site_footer_bg_color', array(
	'type'     => 'alpha-color',
	'section'  => 'site_footer_bottom_bar',
	'label'    => __( 'Background Color', 'shapla' ),
	'default'  => shapla_default_options( 'site_footer_bg_color' ),
	'priority' => 10,
) );

// Site Footer Bottom Bar Text Color
Shapla_Customizer_Config::add_field( 'site_footer_text_color', array(
	'type'     => 'alpha-color',
	'section'  => 'site_footer_bottom_bar',
	'label'    => __( 'Text Color', 'shapla' ),
	'default'  => shapla_default_options( 'site_footer_text_color' ),
	'priority' => 20,
) );

// Site Footer Bottom Bar Link Color
Shapla_Customizer_Config::add_field( 'site_footer_link_color', array(
	'type'     => 'alpha-color',
	'section'  => 'site_footer_bottom_bar',
	'label'    => __( 'Link Color', 'shapla' ),
	'default'  => shapla_default_options( 'site_footer_link_color' ),
	'priority' => 30,
) );

// Footer credit text
Shapla_Customizer_Config::add_field( 'site_copyright_text', array(
	'type'        => 'textarea',
	'section'     => 'site_footer_bottom_bar',
	'label'       => __( 'Copyright Text', 'shapla' ),
	'description' => __( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'shapla' ),
	'default'     => shapla_default_options( 'site_copyright_text' ),
	'priority'    => 40,
) );
