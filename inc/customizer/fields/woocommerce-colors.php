<?php

// Add new section
$shapla->customizer->add_section( 'woocommerce_colors', array(
	'title'       => __( 'Colors', 'shapla' ),
	'description' => __( 'Customise WooCommerce related colors of your web site.', 'shapla' ),
	'panel'       => 'woocommerce_panel',
	'priority'    => 20,
) );

// Primary color
$shapla->customizer->add_field( array(
	'settings'    => 'wc_primary_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Primary color', 'shapla' ),
	'description' => __( 'Primary color for buttons (buttons with .alt class)', 'shapla' ),
	'default'     => '#a46497',
	'priority'    => 10,
	'output'      => array(),
) );

// Primary text color
$shapla->customizer->add_field( array(
	'settings'    => 'wc_primary_text_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Primary text color', 'shapla' ),
	'description' => __( 'Text on primary color', 'shapla' ),
	'default'     => '#ffffff',
	'priority'    => 20,
	'output'      => array(),
) );

// Secondary color
$shapla->customizer->add_field( array(
	'settings'    => 'wc_secondary_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Secondary color', 'shapla' ),
	'description' => __( 'Secondary color for buttons', 'shapla' ),
	'default'     => '#ebe9eb',
	'priority'    => 30,
	'output'      => array(),
) );

// Secondary text color
$shapla->customizer->add_field( array(
	'settings'    => 'wc_secondary_text_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Secondary text color', 'shapla' ),
	'description' => __( 'Text on secondary color', 'shapla' ),
	'default'     => '#515151',
	'priority'    => 40,
	'output'      => array(),
) );

// Highlight color
$shapla->customizer->add_field( array(
	'settings'    => 'wc_highlight_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Highlight color', 'shapla' ),
	'description' => __( 'Color for Prices, In stock labels, sales flash', 'shapla' ),
	'default'     => '#77a464',
	'priority'    => 50,
	'output'      => array(),
) );

// Highlight text color
$shapla->customizer->add_field( array(
	'settings'    => 'wc_highlight_text_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Secondary text color', 'shapla' ),
	'description' => __( 'Text on highlight color', 'shapla' ),
	'default'     => '#ffffff',
	'priority'    => 60,
	'output'      => array(),
) );

// Content background
$shapla->customizer->add_field( array(
	'settings'    => 'wc_content_background_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Content background', 'shapla' ),
	'description' => __( 'Content background - tabs (active state)', 'shapla' ),
	'default'     => '#ffffff',
	'priority'    => 70,
	'output'      => array(),
) );

// Content background
$shapla->customizer->add_field( array(
	'settings'    => 'wc_subtext_color',
	'type'        => 'alpha-color',
	'section'     => 'woocommerce_colors',
	'label'       => __( 'Subtext', 'shapla' ),
	'description' => __( 'small, breadcrumbs etc', 'shapla' ),
	'default'     => '#777777',
	'priority'    => 80,
	'output'      => array(),
) );