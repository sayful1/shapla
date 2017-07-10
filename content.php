<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shapla
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to shapla_loop_post action.
	 *
	 * @hooked shapla_post_header          - 10
	 * @hooked shapla_post_meta            - 20
	 * @hooked shapla_post_content         - 30
	 */
	do_action( 'shapla_loop_post' );
	?>
	
</article><!-- #post-## -->
