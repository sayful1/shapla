<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shapla
 */

?>

	</div><!-- #content -->
	
	<?php do_action( 'shapla_before_footer_widget' ); ?>

	<?php
	/**
	 * Functions hooked into shapla_footer_widget action
	 *
	 * @hooked shapla_footer_widget - 10
	 */
	do_action( 'shapla_footer_widget' );


	do_action( 'shapla_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="shapla-container">
			<?php
			/**
			 * Functions hooked into shapla_footer action
			 *
			 * @hooked shapla_site_info - 20
			 * @hooked shapla_social_navigation - 30
			 */
			do_action( 'shapla_footer' ); ?>
		</div>
	</footer><!-- #colophon -->

	<?php do_action( 'shapla_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
