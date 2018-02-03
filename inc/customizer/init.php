<?php

require 'fields/init.php';

// Background Image
$shapla->customizer->add_field( array(
	'settings'    => 'page_title_bar_background',
	'type'        => 'background',
	'section'     => 'page_title_bar',
	'label'       => __( 'Page Title Bar Background', 'shapla' ),
	'description' => __( 'Controls the background of the page title bar.', 'shapla' ),
	'priority'    => 10,
	'default'     => array(
		'background-color'      => '#f5f5f5',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'fixed',
	),
) );