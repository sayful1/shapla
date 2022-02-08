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
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'shapla_before_site' ); ?>

<div id="page" class="site">
	<?php
	/**
	 * Functions hooked in to shapla_before_header
	 */
	do_action( 'shapla_before_header' );

	/**
	 * Functions hooked into shapla_header action
	 *
	 * @hooked shapla_header_markup - 10
	 */
	do_action( 'shapla_header' );

	/**
	 * Functions hooked in to shapla_before_content
	 */
	do_action( 'shapla_before_content' );
	?>

	<div id="content" class="site-content">
		<div class="shapla-container">
			<div class="site-content-inner">
