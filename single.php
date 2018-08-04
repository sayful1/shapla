<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Shapla
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
			<?php
			/**
			 * Functions hooked into shapla_single_post_content action
			 *
			 * @hooked shapla_single_post_content - 10
			 */
			do_action( 'shapla_single_post_content' );
			?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
