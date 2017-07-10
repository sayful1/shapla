<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shapla
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	do_action( 'shapla_single_post_top' );

	/**
	 * Functions hooked into shapla_single_post add_action
	 *
	 * @hooked shapla_post_header          - 10
	 * @hooked shapla_post_content         - 20
	 * @hooked shapla_post_meta            - 30
	 */
	do_action( 'shapla_single_post' );
	?>
	
</div><!-- #post-## -->
