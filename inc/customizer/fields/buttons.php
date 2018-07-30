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

// Button Background Color
$shapla->customizer->add_field( array(
	'settings' => 'button_primary_background_color',
	'type'     => 'alpha-color',
	'section'  => 'button_primary',
	'label'    => __( 'Background Color', 'shapla' ),
	'default'  => shapla_default_options( 'button_primary_background_color' ),
	'priority' => 10,
	'output'   => array(
		array(
			'element'  => array(
				'button',
				'.button',
				'a.button',
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
			),
			'property' => 'background-color',
		),
	),
) );

// Button Background Hover Color
$shapla->customizer->add_field( array(
	'settings' => 'button_primary_background_hover_color',
	'type'     => 'alpha-color',
	'section'  => 'button_primary',
	'label'    => __( 'Background Hover Color', 'shapla' ),
	'default'  => shapla_default_options( 'button_primary_background_hover_color' ),
	'priority' => 20,
	'output'   => array(
		array(
			'element'  => array(
				'button:hover',
				'button:focus',
				'button:active',
				'.button:hover',
				'.button:focus',
				'.button:active',
				'a.button:hover',
				'a.button:focus',
				'a.button:active',
				'input[type="button"]:hover',
				'input[type="button"]:focus',
				'input[type="button"]:active',
				'input[type="reset"]:hover',
				'input[type="reset"]:focus',
				'input[type="reset"]:active',
				'input[type="submit"]:hover',
				'input[type="submit"]:focus',
				'input[type="submit"]:active',
			),
			'property' => 'background-color',
		),
	),
) );

// Button Text Color
$shapla->customizer->add_field( array(
	'settings' => 'button_primary_text_color',
	'type'     => 'alpha-color',
	'section'  => 'button_primary',
	'label'    => __( 'Text Color', 'shapla' ),
	'default'  => shapla_default_options( 'button_primary_text_color' ),
	'priority' => 30,
	'output'   => array(
		array(
			'element'  => array(
				'button',
				'.button',
				'a.button',
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
			),
			'property' => 'color',
		),
	),
) );

// Button Text Hover Color
$shapla->customizer->add_field( array(
	'settings' => 'button_primary_text_hover_color',
	'type'     => 'alpha-color',
	'section'  => 'button_primary',
	'label'    => __( 'Text Hover Color', 'shapla' ),
	'default'  => shapla_default_options( 'button_primary_text_hover_color' ),
	'priority' => 40,
	'output'   => array(
		array(
			'element'  => array(
				'button:hover',
				'button:focus',
				'button:active',
				'.button:hover',
				'.button:focus',
				'.button:active',
				'a.button:hover',
				'a.button:focus',
				'a.button:active',
				'input[type="button"]:hover',
				'input[type="button"]:focus',
				'input[type="button"]:active',
				'input[type="reset"]:hover',
				'input[type="reset"]:focus',
				'input[type="reset"]:active',
				'input[type="submit"]:hover',
				'input[type="submit"]:focus',
				'input[type="submit"]:active',
			),
			'property' => 'color',
		),
	),
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
