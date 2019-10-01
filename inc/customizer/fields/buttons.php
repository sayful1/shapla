<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new section
$shapla->customizer->add_section( 'button_primary', array(
	'title'       => __( 'Buttons', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site buttons.', 'shapla' ),
	'priority'    => 40,
) );

// Button Border Radius
$shapla->customizer->add_field( array(
	'settings'    => 'button_primary_border_radius',
	'type'        => 'range-slider',
	'section'     => 'button_primary',
	'label'       => __( 'Border Radius', 'shapla' ),
	'description' => __( 'Enter a px value for button. ex: 3px', 'shapla' ),
	'default'     => shapla_default_options( 'button_primary_border_radius' ),
	'priority'    => 60,
	'input_attrs' => array(
		'min'    => 0,
		'max'    => 100,
		'step'   => 1,
		'suffix' => 'px',
	),
	'output'      => array(
		array(
			'element'  => array(
				'button',
				'.button',
				'a.button',
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
			),
			'property' => 'border-radius',
			'suffix'   => 'px',
		),
	),
) );
