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
			if ( have_posts() ) {
				if ( is_singular() && ! is_page() ) {
					/**
					 * Functions hooked into shapla_single_post_content action
					 *
					 * @see shapla_single_post_content - 10
					 */
					do_action( 'shapla_single_post_content' );
				} elseif ( is_archive() ) {
					/**
					 * Functions hooked into shapla_archive_page_content action
					 *
					 * @see shapla_archive_page_content - 10
					 */
					do_action( 'shapla_archive_page_content' );
				} else {
					get_template_part( 'loop' );
				}
			} else {
				if ( is_404() ) {
					/**
					 * Functions hooked into shapla_404_page_content action
					 *
					 * @see shapla_404_page_content - 10
					 */
					do_action( 'shapla_404_page_content' );
				} else {
					get_template_part( 'template-parts/content', 'none' );
				}
			}
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
