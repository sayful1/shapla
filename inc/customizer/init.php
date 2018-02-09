<?php
/**
 * Include customize fields
 */
require 'fields/init.php';

$shapla->customizer->add_field( array(
	'type'     => 'typography',
	'settings' => 'my_setting',
	'label'    => esc_attr__( 'Control Label', 'textdomain' ),
	'section'  => 'typography_section',
	'default'  => array(
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '14px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left'
	),
	'priority' => 10,
	'output'   => array(
		array(
			'element' => 'body',
		),
	),
) );
