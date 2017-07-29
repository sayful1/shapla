<?php
// Add new section
$shapla->customizer->add_section( 'woocommerce', array(
	'title'       => __( 'WooCommerce', 'shapla' ),
	'description' => __( 'Customise WooCommerce related look & feel of your web site.', 'shapla' ),
	'priority'    => 50,
) );

// Change products per page
$shapla->customizer->add_field( array(
	'settings'    => 'wc_products_per_page',
	'type'        => 'number',
	'section'     => 'woocommerce',
	'label'       => __( 'Products per page', 'shapla' ),
	'description' => __( 'Change number of products displayed per page', 'shapla' ),
	'default'     => 16,
	'priority'    => 10,
) );

// Change site title font size
$shapla->customizer->add_field( array(
	'settings'    => 'wc_products_per_row',
	'type'        => 'select',
	'section'     => 'woocommerce',
	'label'       => __( 'Products per row', 'shapla' ),
	'description' => __( 'Change number of products displayed per row', 'shapla' ),
	'default'     => 4,
	'priority'    => 20,
	'choices'     => array(
		3 => __( '3 Products', 'shapla' ),
		4 => __( '4 Products', 'shapla' ),
		5 => __( '5 Products', 'shapla' ),
		6 => __( '6 Products', 'shapla' ),
	),
) );