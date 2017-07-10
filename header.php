<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shapla
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<?php
	/**
	 * Functions hooked in to shapla_before_header
	 */
	do_action( 'shapla_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php shapla_header_styles(); ?>">
		<div class="shapla-container">
			<?php
			/**
			 * Functions hooked into shapla_header action
			 *
			 * @hooked shapla_skip_links - 0
			 * @hooked shapla_site_branding - 20
			 * @hooked shapla_primary_navigation - 30
			 */
			do_action( 'shapla_header' ); ?>
		</div>
	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to shapla_before_content
	 */
	do_action( 'shapla_before_content' ); ?>

	<div id="content" class="site-content">
