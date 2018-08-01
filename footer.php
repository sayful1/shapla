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

</div>
</div>
</div><!-- #content -->

<?php do_action( 'shapla_before_footer_widget' ); ?>

<?php
/**
 * Functions hooked into shapla_footer_widget action
 *
 * @hooked shapla_footer_widget - 10
 */
do_action( 'shapla_footer_widget' );

/**
 * Functions hooked into shapla_before_footer action
 */
do_action( 'shapla_before_footer' );

/**
 * Functions hooked into shapla_footer action
 */
do_action( 'shapla_footer' );

/**
 * Functions hooked into shapla_after_footer action
 */
do_action( 'shapla_after_footer' );
?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
