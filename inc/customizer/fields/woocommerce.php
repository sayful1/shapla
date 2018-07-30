<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
$shapla->customizer->add_panel( 'woocommerce_panel', array(
	'title'       => __( 'WooCommerce Style', 'shapla' ),
	'description' => __( 'Customise WooCommerce related look & feel of your web site.', 'shapla' ),
	'priority'    => 50,
) );

// Add new section
$shapla->customizer->add_section( 'woocommerce', array(
	'title'       => __( 'General', 'shapla' ),
	'description' => __( 'Customise WooCommerce related look & feel of your web site.', 'shapla' ),
	'panel'       => 'woocommerce_panel',
	'priority'    => 10,
) );

// Change products per page
$shapla->customizer->add_field( array(
	'settings'    => 'wc_products_per_page',
	'type'        => 'range-slider',
	'section'     => 'woocommerce',
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
$shapla->customizer->add_field( array(
	'settings'    => 'wc_products_per_row',
	'type'        => 'range-slider',
	'section'     => 'woocommerce',
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
$shapla->customizer->add_field( array(
	'settings'    => 'show_cart_icon',
	'type'        => 'toggle',
	'section'     => 'woocommerce',
	'label'       => __( 'Show Cart Icon', 'shapla' ),
	'description' => __( 'Check to show cart icon on navigation bar in header area.', 'shapla' ),
	'default'     => shapla_default_options( 'show_cart_icon' ),
	'priority'    => 30,
) );

// Toggle cart icon
$shapla->customizer->add_field( array(
	'settings'    => 'show_product_search_categories',
	'type'        => 'toggle',
	'section'     => 'woocommerce',
	'label'       => __( 'Show Categories Dropdown', 'shapla' ),
	'description' => __( 'Check to show product categories dropdown on search field in header area.', 'shapla' ),
	'default'     => shapla_default_options( 'show_product_search_categories' ),
	'priority'    => 30,
) );
