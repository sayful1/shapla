<?php
/**
 * Shapla hooks
 *
 * @package shapla
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'shapla_before_site', 'shapla_skip_links', 0 );

add_action( 'shapla_header', 'shapla_header_markup', 10 );
add_action( 'shapla_footer', 'shapla_footer_markup', 10 );

/**
 * Header Inner
 *
 * @see  shapla_site_branding()
 * @see  shapla_default_search()
 * @see  shapla_primary_navigation()
 */
add_action( 'shapla_header_inner', 'shapla_site_branding', 20 );
add_action( 'shapla_header_inner', 'shapla_default_search', 25 );
add_action( 'shapla_header_inner', 'shapla_primary_navigation', 30 );
add_action( 'shapla_header_inner', 'shapla_header_extras', 30 );

add_action( 'shapla_header_extras', 'shapla_search_toggle', 10 );
add_action( 'shapla_header_inner', 'shapla_mobile_navigation_toggle', 40 );

/**
 * Footer Widget
 *
 * @see  shapla_footer_widget()
 */
add_action( 'shapla_footer_widget', 'shapla_footer_widget', 10 );

/**
 * Footer
 *
 * @see  shapla_site_info()
 * @see  shapla_social_navigation()
 */
add_action( 'shapla_footer_inner', 'shapla_site_info', 20 );
add_action( 'shapla_footer_inner', 'shapla_social_navigation', 30 );

/**
 * Pages
 *
 * @see  shapla_page_header()
 * @see  shapla_page_content()
 * @see  shapla_display_comments()
 */
add_action( 'shapla_before_content', 'shapla_page_header', 10 );
add_action( 'shapla_page', 'shapla_post_thumbnail', 10 );
add_action( 'shapla_page', 'shapla_page_content', 20 );
add_action( 'shapla_page_after', 'shapla_display_comments', 10 );

/**
 * Single Posts
 *
 * @see  shapla_post_header()
 * @see  shapla_post_content()
 * @see  shapla_post_meta()
 * @see  shapla_navigation()
 * @see  shapla_display_comments()
 */
add_action( 'shapla_single_post', 'shapla_post_thumbnail', 10 );
add_action( 'shapla_single_post', 'shapla_post_content', 20 );
add_action( 'shapla_single_post', 'shapla_post_meta', 30 );

add_action( 'shapla_single_post_after', 'shapla_navigation', 10 );
add_action( 'shapla_single_post_after', 'shapla_display_comments', 20 );

add_action( 'shapla_single_page_content', 'shapla_single_page_content', 10 );
add_action( 'shapla_single_post_content', 'shapla_single_post_content', 10 );
add_action( 'shapla_archive_page_content', 'shapla_archive_page_content', 10 );
add_action( 'shapla_search_page_content', 'shapla_archive_page_content', 10 );

/**
 * Posts
 *
 * @see  shapla_pagination()
 */
add_action( 'shapla_loop_after', 'shapla_pagination', 10 );

// Add theme custom Breadcrumbs
add_action( 'shapla_after_page_title', 'shapla_breadcrumb', 10 );

add_action( 'wp_footer', 'shapla_search_modal', 1 );
add_action( 'wp_footer', 'shapla_scroll_to_top_button', 2 );

// 404 page
add_action( 'shapla_404_page_content', 'shapla_404_page_content', 10 );

// Extra hook.
add_filter( 'walker_nav_menu_start_el', 'shapla_nav_menu_social_icons', 10, 4 );
