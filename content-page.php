<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shapla
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to shapla_page add_action
	 *
	 * @hooked shapla_page_header          - 10
	 * @hooked shapla_page_content         - 20
	 */
	do_action( 'shapla_page' );
	?>
</div><!-- #post-## -->
