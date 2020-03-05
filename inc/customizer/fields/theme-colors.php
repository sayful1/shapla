<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Add new section
Shapla_Customizer_Config::add_section( 'theme_colors', array(
	'title'       => __( 'Colors', 'shapla' ),
	'description' => __( 'Customise colors of your web site.', 'shapla' ),
	'priority'    => 20,
) );

$color_settings = Shapla_Colors::customizer_colors_settings();
foreach ( $color_settings as $color_id => $color_args ) {
	Shapla_Customizer_Config::add_field( $color_id, $color_args );
}
