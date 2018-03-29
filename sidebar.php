<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shapla
 */

$sidebar_index = 'sidebar-1';

if ( is_singular() ) {
	$sidebar_widget_area = shapla_page_option( 'sidebar_widget_area', 'default' );
	if ( ! empty( $sidebar_widget_area ) && 'default' !== $sidebar_widget_area ) {
		$sidebar_index = $sidebar_widget_area;
	}
}

if ( ! is_active_sidebar( $sidebar_index ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( $sidebar_index ); ?>
</aside><!-- #secondary -->
