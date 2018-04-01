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
		$sidebar_index = esc_attr( $sidebar_widget_area );
	}
}

if ( shapla_is_woocommerce_activated() ) {
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		$shop_page_id = wc_get_page_id( 'shop' );
		$page_options = get_post_meta( $shop_page_id, '_shapla_page_options', true );
		if ( ! empty( $page_options['sidebar_widget_area'] ) && 'default' !== $page_options['sidebar_widget_area'] ) {
			$sidebar_index = esc_attr( $page_options['sidebar_widget_area'] );
		}
	}
}

if ( ! is_active_sidebar( $sidebar_index ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( $sidebar_index ); ?>
</aside><!-- #secondary -->
