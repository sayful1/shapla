<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add Extra Panel
 */
$shapla->customizer->add_panel( 'extra_panel', array(
	'title'    => __( 'Extra', 'shapla' ),
	'priority' => 190,
) );

/**
 * Add Extra Sections
 */
$shapla->customizer->add_section( 'forms_styling_section', array(
	'title'    => __( 'Forms Styling', 'shapla' ),
	'panel'    => 'extra_panel',
	'priority' => 10,
) );

/**
 * Forms Styling Fields
 */
$shapla->customizer->add_field( array(
	'settings'    => 'form_background_color',
	'type'        => 'alpha-color',
	'section'     => 'forms_styling_section',
	'label'       => __( 'Form Background Color', 'shapla' ),
	'description' => __( 'Controls the background color of form fields.', 'shapla' ),
	'default'     => shapla_default_options()->form_background_color,
	'priority'    => 10,
	'output'      => array(
		array(
			'element'  => array(
				'input[type="text"]',
				'input[type="email"]',
				'input[type="url"]',
				'input[type="password"]',
				'input[type="search"]',
				'input[type="number"]',
				'input[type="tel"]',
				'textarea',
			),
			'property' => 'background-color',
		),
	),
) );
$shapla->customizer->add_field( array(
	'settings'    => 'form_text_color',
	'type'        => 'alpha-color',
	'section'     => 'forms_styling_section',
	'label'       => __( 'Form Text Color', 'shapla' ),
	'description' => __( 'Controls the text color of form fields.', 'shapla' ),
	'default'     => shapla_default_options()->form_text_color,
	'priority'    => 10,
	'output'      => array(
		array(
			'element'  => array(
				'input[type="text"]',
				'input[type="email"]',
				'input[type="url"]',
				'input[type="password"]',
				'input[type="search"]',
				'input[type="number"]',
				'input[type="tel"]',
				'textarea',
			),
			'property' => 'color',
		),
	),
) );
$shapla->customizer->add_field( array(
	'settings'    => 'form_border_color',
	'type'        => 'alpha-color',
	'section'     => 'forms_styling_section',
	'label'       => __( 'Form Border Color', 'shapla' ),
	'description' => __( 'Controls the border color of form fields.', 'shapla' ),
	'default'     => shapla_default_options()->form_border_color,
	'priority'    => 10,
	'output'      => array(
		array(
			'element'  => array(
				'input[type="text"]',
				'input[type="email"]',
				'input[type="url"]',
				'input[type="password"]',
				'input[type="search"]',
				'input[type="number"]',
				'input[type="tel"]',
				'textarea',
			),
			'property' => 'border-color',
		),
	),
) );