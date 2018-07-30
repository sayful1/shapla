<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new section
$shapla->customizer->add_section( 'woocommerce_colors', array(
	'title'       => __( 'Colors', 'shapla' ),
	'description' => __( 'Customise WooCommerce related colors of your web site.', 'shapla' ),
	'panel'       => 'woocommerce_panel',
	'priority'    => 20,
) );

// Highlight color
$shapla->customizer->add_field( array(
	'settings'    => 'wc_highlight_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Highlight color', 'shapla' ),
	'description' => __( 'Color for Prices, In stock labels, sales flash', 'shapla' ),
	'default'     => shapla_default_options( 'wc_highlight_color' ),
	'priority'    => 50,
	'output'      => array(
		array(
			'element'  => array(
				'.woocommerce .onsale',
			),
			'property' => 'background-color',
		),
		array(
			'element'  => array(
				'.woocommerce .star-rating span::before',
				'p.stars:hover a::before',
				'p.stars.selected a.active::before',
				'p.stars.selected a:not(.active)::before',
			),
			'property' => 'color',
		),
	),
) );

// Highlight text color
$shapla->customizer->add_field( array(
	'settings'    => 'wc_highlight_text_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Highlight text color', 'shapla' ),
	'description' => __( 'Text on highlight color', 'shapla' ),
	'default'     => shapla_default_options( 'wc_highlight_text_color' ),
	'priority'    => 60,
	'output'      => array(
		array(
			'element'  => array(
				'.woocommerce .onsale',
			),
			'property' => 'color',
		),
	),
) );
