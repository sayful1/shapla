<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
Shapla_Customizer_Config::add_panel( 'woocommerce', array(
	'title'       => __( 'WooCommerce', 'shapla' ),
	'description' => __( 'Customise WooCommerce related look & feel of your web site.', 'shapla' ),
	'priority'    => 200,
) );

// Add new section
Shapla_Customizer_Config::add_section( 'shapla_woocommerce_section', array(
	'title'       => __( 'General', 'shapla' ),
	'description' => __( 'Customise WooCommerce related look & feel of your web site.', 'shapla' ),
	'panel'       => 'woocommerce',
	'priority'    => 100,
) );

// Change products per page
Shapla_Customizer_Config::add_field( 'wc_products_per_page', array(
	'type'        => 'range-slider',
	'section'     => 'shapla_woocommerce_section',
	'label'       => __( 'Products per page', 'shapla' ),
	'description' => __( 'Change number of products displayed per page', 'shapla' ),
	'default'     => shapla_default_options( 'wc_products_per_page' ),
	'priority'    => 10,
	'input_attrs' => array(
		'min'  => 1,
		'max'  => 120,
		'step' => 1,
	),
) );

// Change site title font size
Shapla_Customizer_Config::add_field( 'wc_products_per_row', array(
	'type'        => 'range-slider',
	'section'     => 'shapla_woocommerce_section',
	'label'       => __( 'Products per row', 'shapla' ),
	'description' => __( 'Change number of products displayed per row', 'shapla' ),
	'default'     => shapla_default_options( 'wc_products_per_row' ),
	'priority'    => 20,
	'input_attrs' => array(
		'min'  => 3,
		'max'  => 6,
		'step' => 1,
	),
) );

// Toggle cart icon
Shapla_Customizer_Config::add_field( 'show_cart_icon', array(
	'type'        => 'toggle',
	'section'     => 'shapla_woocommerce_section',
	'label'       => __( 'Show Cart Icon', 'shapla' ),
	'description' => __( 'Check to show cart icon on navigation bar in header area.', 'shapla' ),
	'default'     => shapla_default_options( 'show_cart_icon' ),
	'priority'    => 30,
) );
