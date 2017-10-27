<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! shapla_is_woocommerce_activated() ) {
	return;
}

$shapla->customizer->add_section( 'button_alternate', array(
	'title'       => __( 'Alternate Button', 'shapla' ),
	'description' => __( 'Customise the look & feel of your web site alternate buttons.', 'shapla' ),
	'panel'       => 'button_panel',
	'priority'    => 10,
) );

// Alternate Button Background Color
$shapla->customizer->add_field( array(
	'settings' => 'button_alternate_background_color',
	'type'     => 'alpha-color',
	'section'  => 'button_alternate',
	'label'    => __( 'Background Color', 'shapla' ),
	'default'  => shapla_default_options()->secondary_button->background,
	'priority' => 10,
	'output'   => array(
		array(
			'element'  => array(
				'button.alt',
				'.button.alt',
				'a.button.alt',
				'input[type="button"].alt',
				'input[type="reset"].alt',
				'input[type="submit"].alt',
			),
			'property' => 'background-color',
		),
	),
) );

// Alternate Button Background Hover Color
$shapla->customizer->add_field( array(
	'settings' => 'button_alternate_background_hover_color',
	'type'     => 'alpha-color',
	'section'  => 'button_alternate',
	'label'    => __( 'Background Hover Color', 'shapla' ),
	'default'  => shapla_default_options()->secondary_button->background_hover,
	'priority' => 20,
	'output'   => array(
		array(
			'element'  => array(
				'button.alt:hover',
				'button.alt:focus',
				'button.alt:active',
				'.button.alt:hover',
				'.button.alt:focus',
				'.button.alt:active',
				'a.button.alt:hover',
				'a.button.alt:focus',
				'a.button.alt:active',
				'input[type="button"].alt:hover',
				'input[type="button"].alt:focus',
				'input[type="button"].alt:active',
				'input[type="reset"].alt:hover',
				'input[type="reset"].alt:focus',
				'input[type="reset"].alt:active',
				'input[type="submit"].alt:hover',
				'input[type="submit"].alt:focus',
				'input[type="submit"].alt:active',
			),
			'property' => 'background-color',
		),
	),
) );

// Alternate Button Text Color
$shapla->customizer->add_field( array(
	'settings' => 'button_alternate_text_color',
	'type'     => 'alpha-color',
	'section'  => 'button_alternate',
	'label'    => __( 'Text Color', 'shapla' ),
	'default'  => shapla_default_options()->secondary_button->text,
	'priority' => 30,
	'output'   => array(
		array(
			'element'  => array(
				'button.alt',
				'.button.alt',
				'a.button.alt',
				'input[type="button"].alt',
				'input[type="reset"].alt',
				'input[type="submit"].alt',
			),
			'property' => 'color',
		),
	),
) );

// Alternate Button Text Hover Color
$shapla->customizer->add_field( array(
	'settings' => 'button_alternate_text_hover_color',
	'type'     => 'alpha-color',
	'section'  => 'button_alternate',
	'label'    => __( 'Text Hover Color', 'shapla' ),
	'default'  => shapla_default_options()->secondary_button->text_hover,
	'priority' => 40,
	'output'   => array(
		array(
			'element'  => array(
				'button.alt:hover',
				'button.alt:focus',
				'button.alt:active',
				'.button.alt:hover',
				'.button.alt:focus',
				'.button.alt:active',
				'a.button.alt:hover',
				'a.button.alt:focus',
				'a.button.alt:active',
				'input[type="button"].alt:hover',
				'input[type="button"].alt:focus',
				'input[type="button"].alt:active',
				'input[type="reset"].alt:hover',
				'input[type="reset"].alt:focus',
				'input[type="reset"].alt:active',
				'input[type="submit"].alt:hover',
				'input[type="submit"].alt:focus',
				'input[type="submit"].alt:active',
			),
			'property' => 'color',
		),
	),
) );
