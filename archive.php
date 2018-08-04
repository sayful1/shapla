<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shapla
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
			<?php
			/**
			 * Functions hooked into shapla_archive_page_content action
			 *
			 * @hooked shapla_archive_page_content - 10
			 */
			do_action( 'shapla_archive_page_content' );
			?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
