<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
$shapla->customizer->add_panel( 'site_footer_panel', array(
	'title'       => __( 'Footer', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site footer.', 'shapla' ),
	'priority'    => 30,
) );
// Add new section
$shapla->customizer->add_section( 'site_footer_widgets', array(
	'title'       => __( 'Widgets', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site footer widget area.', 'shapla' ),
	'panel'       => 'site_footer_panel',
	'priority'    => 10,
) );
$shapla->customizer->add_section( 'site_footer_bottom_bar', array(
	'title'       => __( 'Bottom Bar', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site footer bottom bar.', 'shapla' ),
	'panel'       => 'site_footer_panel',
	'priority'    => 20,
) );

// Footer Widget Rows
$shapla->customizer->add_field( array(
	'settings'    => 'footer_widget_rows',
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
$shapla->customizer->add_field( array(
	'settings'    => 'footer_widget_columns',
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

$shapla->customizer->add_field( array(
	'settings'    => 'footer_widget_background',
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
	'output'      => array(
		array(
			'element' => array(
				'.footer-widget-area',
			),
		),
	),
) );

$shapla->customizer->add_field( array(
	'settings' => 'footer_widget_text_color',
	'type'     => 'alpha-color',
	'section'  => 'site_footer_widgets',
	'label'    => __( 'Text Color', 'shapla' ),
	'default'  => shapla_default_options( 'footer_widget_text_color' ),
	'priority' => 30,
	'output'   => array(
		array(
			'element'  => array(
				'.footer-widget-area',
				'.footer-widget-area li:before',
				'.footer-widget-area .widget-title',
			),
			'property' => 'color',
		),
		array(
			'element'  => array(
				'.footer-widget-area .widget-title',
				'.footer-widget-area table',
				'.footer-widget-area table tr',
			),
			'property' => 'border-color',
		),
	),
) );

$shapla->customizer->add_field( array(
	'settings' => 'footer_widget_link_color',
	'type'     => 'alpha-color',
	'section'  => 'site_footer_widgets',
	'label'    => __( 'Link Color', 'shapla' ),
	'default'  => shapla_default_options( 'footer_widget_link_color' ),
	'priority' => 40,
	'output'   => array(
		array(
			'element'  => '.footer-widget-area .widget a',
			'property' => 'color',
		),
	),
) );

// Site Footer Bottom Bar Background Color
$shapla->customizer->add_field( array(
	'settings' => 'site_footer_bg_color',
	'type'     => 'alpha-color',
	'section'  => 'site_footer_bottom_bar',
	'label'    => __( 'Background Color', 'shapla' ),
	'default'  => shapla_default_options( 'site_footer_bg_color' ),
	'priority' => 10,
	'output'   => array(
		array(
			'element'  => '.site-footer',
			'property' => 'background-color',
		),
	),
) );

// Site Footer Bottom Bar Text Color
$shapla->customizer->add_field( array(
	'settings' => 'site_footer_text_color',
	'type'     => 'alpha-color',
	'section'  => 'site_footer_bottom_bar',
	'label'    => __( 'Text Color', 'shapla' ),
	'default'  => shapla_default_options( 'site_footer_text_color' ),
	'priority' => 20,
	'output'   => array(
		array(
			'element'  => '.site-footer',
			'property' => 'color',
		),
	),
) );

// Site Footer Bottom Bar Link Color
$shapla->customizer->add_field( array(
	'settings' => 'site_footer_link_color',
	'type'     => 'alpha-color',
	'section'  => 'site_footer_bottom_bar',
	'label'    => __( 'Link Color', 'shapla' ),
	'default'  => shapla_default_options( 'site_footer_link_color' ),
	'priority' => 30,
	'output'   => array(
		array(
			'element'  => '.site-footer a',
			'property' => 'color',
		),
	),
) );

// Footer credit text
$shapla->customizer->add_field( array(
	'settings'    => 'site_copyright_text',
	'type'        => 'textarea',
	'section'     => 'site_footer_bottom_bar',
	'label'       => __( 'Copyright Text', 'shapla' ),
	'description' => __( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'shapla' ),
	'default'     => shapla_default_options( 'site_copyright_text' ),
	'priority'    => 40,
) );
