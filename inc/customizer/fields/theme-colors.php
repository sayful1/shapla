<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Add new section
$shapla->customizer->add_section( 'theme_colors', array(
	'title'       => __( 'Colors', 'shapla' ),
	'description' => __( 'Customise colors of your web site.', 'shapla' ),
	'priority'    => 20,
) );

$color_settings = Shapla_Colors::customizer_colors_settings();
foreach ( $color_settings as $color_setting ) {
	$shapla->customizer->add_field( $color_setting );
}
