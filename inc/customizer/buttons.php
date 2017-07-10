<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
$shapla->customizer->add_panel('button_panel', array(
	'title' 		=> __('Buttons', 'shapla'),
	'description' 	=> __('Customise the look & feel of your web site buttons.', 'shapla'),
	'priority' 		=> 40,
));

// Add new section
$shapla->customizer->add_section('button_primary', array(
	'title' 		=> __('Primary Button', 'shapla'),
	'description' 	=> __('Customise the look & feel of your web site primary buttons.', 'shapla'),
	'panel' 		=> 'button_panel',
	'priority' 		=> 10,
));
$shapla->customizer->add_section('button_alternate', array(
	'title' 		=> __('Alternate Button', 'shapla'),
	'description' 	=> __('Customise the look & feel of your web site alternate buttons.', 'shapla'),
	'panel' 		=> 'button_panel',
	'priority' 		=> 10,
));

// Button Background Color
$shapla->customizer->add_field([
	'settings'    => 'button_primary_background_color',
	'type'        => 'color',
	'section'     => 'button_primary',
	'label'       => __( 'Background Color', 'shapla' ),
	'default'     => '#2c2d33',
	'priority'    => 10,
	'output' => array(
		array(
			'element'  => array(
				'button',
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
				'.button',
				'a.button',
			),
			'property' => 'background-color',
		),
	),
]);

// Button Background Hover Color
$shapla->customizer->add_field([
	'settings'    => 'button_primary_background_hover_color',
	'type'        => 'color',
	'section'     => 'button_primary',
	'label'       => __( 'Background Hover Color', 'shapla' ),
	'default'     => '#13141a',
	'priority'    => 20,
	'output' => array(
		array(
			'element'  => array(
				'button:hover',
				'input[type="button"]:hover',
				'input[type="reset"]:hover',
				'input[type="submit"]:hover',
				'.button:hover',
				'a.button:hover',
			),
			'property' => 'background-color',
		),
	),
]);

// Button Text Color
$shapla->customizer->add_field([
	'settings'    => 'button_primary_text_color',
	'type'        => 'color',
	'section'     => 'button_primary',
	'label'       => __( 'Text Color', 'shapla' ),
	'default'     => '#ffffff',
	'priority'    => 30,
	'output' => array(
		array(
			'element'  => array(
				'button',
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
				'.button',
				'a.button',
			),
			'property' => 'color',
		),
	),
]);

// Button Text Hover Color
$shapla->customizer->add_field([
	'settings'    => 'button_primary_text_hover_color',
	'type'        => 'color',
	'section'     => 'button_primary',
	'label'       => __( 'Text Hover Color', 'shapla' ),
	'default'     => '#ffffff',
	'priority'    => 40,
	'output' => array(
		array(
			'element'  => array(
				'button:hover',
				'input[type="button"]:hover',
				'input[type="reset"]:hover',
				'input[type="submit"]:hover',
				'.button:hover',
				'a.button:hover',
			),
			'property' => 'color',
		),
	),
]);


// Alternate Button Background Color
$shapla->customizer->add_field([
	'settings'    => 'button_alternate_background_color',
	'type'        => 'color',
	'section'     => 'button_alternate',
	'label'       => __( 'Background Color', 'shapla' ),
	'default'     => '#96588a',
	'priority'    => 10,
	'output' => array(
		array(
			'element'  => array(
				'button.alt',
				'input[type="button"].alt',
				'input[type="reset"].alt',
				'input[type="submit"].alt',
				'.button.alt',
				'a.button.alt',
			),
			'property' => 'background-color',
		),
	),
]);

// Alternate Button Background Hover Color
$shapla->customizer->add_field([
	'settings'    => 'button_alternate_background_hover_color',
	'type'        => 'color',
	'section'     => 'button_alternate',
	'label'       => __( 'Background Hover Color', 'shapla' ),
	'default'     => '#7d3f71',
	'priority'    => 20,
	'output' => array(
		array(
			'element'  => array(
				'button.alt:hover',
				'input[type="button"].alt:hover',
				'input[type="reset"].alt:hover',
				'input[type="submit"].alt:hover',
				'.button.alt:hover',
				'a.button.alt:hover',
			),
			'property' => 'background-color',
		),
	),
]);

// Alternate Button Text Color
$shapla->customizer->add_field([
	'settings'    => 'button_alternate_text_color',
	'type'        => 'color',
	'section'     => 'button_alternate',
	'label'       => __( 'Text Color', 'shapla' ),
	'default'     => '#ffffff',
	'priority'    => 30,
	'output' => array(
		array(
			'element'  => array(
				'button.alt',
				'input[type="button"].alt',
				'input[type="reset"].alt',
				'input[type="submit"].alt',
				'.button.alt',
				'a.button.alt',
			),
			'property' => 'color',
		),
	),
]);

// Alternate Button Text Hover Color
$shapla->customizer->add_field([
	'settings'    => 'button_alternate_text_hover_color',
	'type'        => 'color',
	'section'     => 'button_alternate',
	'label'       => __( 'Text Hover Color', 'shapla' ),
	'default'     => '#ffffff',
	'priority'    => 40,
	'output' => array(
		array(
			'element'  => array(
				'button.alt:hover',
				'input[type="button"].alt:hover',
				'input[type="reset"].alt:hover',
				'input[type="submit"].alt:hover',
				'.button.alt:hover',
				'a.button.alt:hover',
			),
			'property' => 'color',
		),
	),
]);