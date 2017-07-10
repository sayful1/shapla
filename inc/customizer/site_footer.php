<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
$shapla->customizer->add_panel('site_footer_panel', array(
	'title' 		=> __('Footer', 'shapla'),
	'description' 	=> __('Customise the look & feel of your web site footer.', 'shapla'),
	'priority' 		=> 30,
));
// Add new section
$shapla->customizer->add_section('site_footer_widgets', array(
	'title' 		=> __('Widgets', 'shapla'),
	'description' 	=> __('Customise the look & feel of your web site footer widget area.', 'shapla'),
	'panel' 		=> 'site_footer_panel',
	'priority' 		=> 10,
));
$shapla->customizer->add_section('site_footer_bottom_bar', array(
	'title' 		=> __('Bottom Bar', 'shapla'),
	'description' 	=> __('Customise the look & feel of your web site footer bottom bar.', 'shapla'),
	'panel' 		=> 'site_footer_panel',
	'priority' 		=> 20,
));

// Footer Widget Area
$shapla->customizer->add_field([
	'settings'    => 'footer_widget_background_color',
	'type'        => 'color',
	'section'     => 'site_footer_widgets',
	'label'       => __( 'Background Color', 'shapla' ),
	'default'     => '#212a34',
	'priority'    => 10,
	'output' => array(
		array(
			'element'  => array(
				'.footer-widget-area',
				'.footer-widget-area table tr:nth-child(odd)',
				'.footer-widget-area table tr:nth-child(even)',
			),
			'property' => 'background-color',
		),
	),
]);
$shapla->customizer->add_field([
	'settings'    => 'footer_widget_text_color',
	'type'        => 'color',
	'section'     => 'site_footer_widgets',
	'label'       => __( 'Text Color', 'shapla' ),
	'default'     => '#f1f1f1',
	'priority'    => 10,
	'output' => array(
		array(
			'element'  => array(
				'.footer-widget-area',
				'.footer-widget-area li:before',
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
]);
$shapla->customizer->add_field([
	'settings'    => 'footer_widget_link_color',
	'type'        => 'color',
	'section'     => 'site_footer_widgets',
	'label'       => __( 'Link Color', 'shapla' ),
	'default'     => '#f1f1f1',
	'priority'    => 10,
	'output' => array(
		array(
			'element'  => '.footer-widget-area a',
			'property' => 'color',
		),
	),
]);

// Site Footer Bottom Bar Background Color
$shapla->customizer->add_field([
	'settings'    => 'site_footer_bg_color',
	'type'        => 'color',
	'section'     => 'site_footer_bottom_bar',
	'label'       => __( 'Background Color', 'shapla' ),
	'default'     => '#19212a',
	'priority'    => 10,
	'output' => array(
		array(
			'element'  => '.site-footer',
			'property' => 'background-color',
		),
	),
]);

// Site Footer Bottom Bar Text Color
$shapla->customizer->add_field([
	'settings'    => 'site_footer_text_color',
	'type'        => 'color',
	'section'     => 'site_footer_bottom_bar',
	'label'       => __( 'Text Color', 'shapla' ),
	'default'     => '#9e9e9e',
	'priority'    => 20,
	'output' => array(
		array(
			'element'  => '.site-footer',
			'property' => 'color',
		),
	),
]);

// Site Footer Bottom Bar Link Color
$shapla->customizer->add_field([
	'settings'    => 'site_footer_link_color',
	'type'        => 'color',
	'section'     => 'site_footer_bottom_bar',
	'label'       => __( 'Link Color', 'shapla' ),
	'default'     => '#f1f1f1',
	'priority'    => 30,
	'output' => array(
		array(
			'element'  => '.site-footer a',
			'property' => 'color',
		),
	),
]);

// Footer credit text
$shapla->customizer->add_field( array(
	'settings' => 'site_copyright_text',
	'type'     => 'textarea',
	'section'  => 'site_footer_bottom_bar',
	'label'    => __( 'Copyright Text', 'shapla' ),
	'default'  => sprintf(
		'<a href="%1$s">%2$s WordPress</a><span class="sep"> | </span>Theme: %3$s by %4$s.',
		esc_url( __( 'https://wordpress.org/', 'shapla' ) ),
		'Proudly powered by',
		'Shapla',
		'<a href="https://sayfulislam.com/" rel="designer">Sayful Islam</a>'
	),
	'priority' => 40,
));
