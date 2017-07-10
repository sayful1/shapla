<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shapla hooks
 *
 * @package shapla
 */

/**
 * Header
 *
 * @see  shapla_skip_links()
 * @see  shapla_site_branding()
 * @see  shapla_primary_navigation()
 */
add_action( 'shapla_header', 'shapla_skip_links', 			0 );
add_action( 'shapla_header', 'shapla_search_toggle', 		10 );
add_action( 'shapla_header', 'shapla_site_branding', 		20 );
add_action( 'shapla_header', 'shapla_primary_navigation', 	30 );

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
add_action( 'shapla_footer', 'shapla_site_info', 			20 );
add_action( 'shapla_footer', 'shapla_social_navigation', 	30 );

/**
 * After Footer
 *
 * @see  shapla_search_form()
 */
add_action( 'shapla_after_footer', 'shapla_search_form',  	10 );

/**
 * Pages
 *
 * @see  shapla_page_header()
 * @see  shapla_page_content()
 * @see  shapla_display_comments()
 */
add_action( 'shapla_page',       'shapla_post_thumbnail',       10 );
add_action( 'shapla_page',       'shapla_page_header',          10 );
add_action( 'shapla_page',       'shapla_page_content',         20 );
add_action( 'shapla_page_after', 'shapla_display_comments',     10 );

/**
 * Single Posts
 *
 * @see  shapla_post_header()
 * @see  shapla_post_content()
 * @see  shapla_post_meta()
 * @see  shapla_post_nav()
 * @see  shapla_display_comments()
 */
add_action( 'shapla_single_post', 		 'shapla_post_thumbnail',       10 );
add_action( 'shapla_single_post', 		 'shapla_post_header',          10 );
add_action( 'shapla_single_post', 		 'shapla_post_meta',            20 );
add_action( 'shapla_single_post', 		 'shapla_post_content',         30 );

add_action( 'shapla_single_post_after', 'shapla_post_nav',             	10 );
add_action( 'shapla_single_post_after', 'shapla_display_comments', 	   	20 );


/**
 * Posts
 *
 * @see  shapla_post_header()
 * @see  shapla_post_meta()
 * @see  shapla_post_content()
 * @see  shapla_paging_nav()
 */
add_action( 'shapla_loop_post', 'shapla_post_header',          10 );
add_action( 'shapla_loop_post', 'shapla_post_meta',            20 );
add_action( 'shapla_loop_post', 'shapla_post_content',         30 );

add_action( 'shapla_loop_after', 'shapla_paging_nav',          10 );