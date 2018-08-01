<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Shapla
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
			<?php
			/**
			 * Functions hooked into shapla_404_page_content action
			 *
			 * @hooked shapla_404_page_content - 10
			 */
			do_action( 'shapla_404_page_content' );
			?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
