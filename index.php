<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shapla
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			if ( is_archive() || is_home() ) {
				do_action( 'shapla_archive_page_content' );
			} elseif ( is_search() ) {
				do_action( 'shapla_search_page_content' );
			} elseif ( is_page() ) {
				do_action( 'shapla_single_page_content' );
			} elseif ( is_singular() ) {
				do_action( 'shapla_single_post_content' );
			} else {
				do_action( 'shapla_404_page_content' );
			}
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
