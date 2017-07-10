<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shapla template functions.
 */

if ( ! function_exists( 'shapla_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function shapla_site_branding() {
		?>
		<div class="site-branding">
			<?php shapla_site_title_or_logo(); ?>
		</div><!-- .site-branding -->
		<?php
	}
}

if ( ! function_exists( 'shapla_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo image
	 *
	 * @since 1.0.0
	 * @param bool $echo Echo the string or return it.
	 * @return string
	 */
	function shapla_site_title_or_logo( $echo = true ){

		$logo_image 	= get_theme_mod('site_logo_image');
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$html = '';

		if ( function_exists( 'the_custom_logo' ) && $custom_logo_id ) {
			ob_start();
			the_custom_logo();
			$html .= ob_get_clean();

		} elseif ( filter_var( $logo_image, FILTER_VALIDATE_URL) ) {

			$html .= sprintf('<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url"><img src="%2$s" class="custom-logo" itemprop="logo"></a>', esc_url( home_url( '/' ) ), esc_url( $logo_image ) );

		} else {
			$tag = is_home() ? 'h1' : 'p';

			$html .= '<' . esc_attr( $tag ) . ' class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) .'>';

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ){

				$html .= '<p class="site-description">' . esc_html( $description ) . '</p>';
			}
		}

		if ( ! $echo ) {
			return $html;
		}

		echo $html;
	}
}

if ( ! function_exists( 'shapla_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function shapla_primary_navigation() {
		?>
		<button id="menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'shapla' ); ?></button>
		<div id="site-header-menu" class="site-header-menu">
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_class'     => 'primary-menu',
				'menu_id' 		 => 'primary-menu'
			) ); ?>
		</nav><!-- #site-navigation -->
		</div>
		<?php
	}
}

if ( ! function_exists( 'shapla_skip_links' ) ) {
	/**
	 * Skip links
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function shapla_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'shapla' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'shapla' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'shapla_search_toggle' ) ) {
	/**
	 * Shapla Search toggle icon
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function shapla_search_toggle()
	{
		$show_search_icon = get_theme_mod('show_search_icon');
		if ( ! $show_search_icon) {
			return;
		}
		?>
		<span id="search-toggle" class="search-toggle"><i class="fa fa-search"></i></span>
		<?php
	}
}

if ( ! function_exists('shapla_search_form')) {
	/**
	 * Shapla Search form
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function shapla_search_form()
	{
		$show_search_icon = get_theme_mod('show_search_icon');
		if ( ! $show_search_icon) {
			return;
		}
		?>
		<div id="search-sidenav" class="sidenav sidenav-right">
			<div class="sidenav-header">
				<h2 class="sidenav-title">Search</h2>
				<span id="search-closebtn" class="sidenav-closebtn">
					<i class="fa fa-times-circle" aria-hidden="true"></i>
				</span>
			</div>
			<div class="sidenav-content">
			<?php
				if ( shapla_is_woocommerce_activated() ) {
					the_widget( 'WC_Widget_Product_Search' );
				} else {
					the_widget( 'WP_Widget_Search' );
				}
			?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists('shapla_footer_widget') ) {
	/**
	 * Display Footer widget
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function shapla_footer_widget()
	{
		if ( is_active_sidebar( 'sidebar-2' ) ):
			?><div id="footer-widget-area" class="footer-widget-area">
				<div class="shapla-container">
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				</div>
			</div><?php
		endif;
	}
}

if ( ! function_exists('shapla_site_info') ) {
	/**
	 * Display Primary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function shapla_site_info()
	{
		$copyright_text = get_theme_mod('site_copyright_text');
		?>
			<div class="site-info">
				<?php
					if($copyright_text):
						echo $copyright_text;
					else:
				?>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'shapla' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'shapla' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'shapla' ), 'shapla', '<a href="https://sayfulislam.com/" rel="designer">Sayful Islam</a>' ); ?>
				<?php endif; ?>
			</div><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists('shapla_social_navigation') ) {
	/**
	 * Display Footer widget
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function shapla_social_navigation()
	{
		if ( has_nav_menu( 'social-nav' ) ) : ?>
			<nav id="social-navigation" class="social-navigation" role="navigation">
				<?php
					// Social links navigation menu.
					wp_nav_menu( array(
						'theme_location' => 'social-nav',
						'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>',
					) );
				?>
			</nav><!-- .social-navigation -->
		<?php endif;
	}
}

if ( ! function_exists( 'shapla_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * @since 1.0.0
	 */
	function shapla_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		if ( is_singular() ) :
		?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
		</a>

		<?php endif; // End is_singular()
	}
}


if ( ! function_exists( 'shapla_post_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function shapla_post_meta() {

	$show_author_avatar 	= get_theme_mod( 'show_blog_author_avatar', true );
	$show_author_name 		= get_theme_mod( 'show_blog_author_name', true );
	$show_date 				= get_theme_mod( 'show_blog_date', true );
	$show_category_list 	= get_theme_mod( 'show_blog_category_list', true );
	$show_tag_list 			= get_theme_mod( 'show_blog_tag_list', true );
	$show_comments_link 	= get_theme_mod( 'show_blog_comments_link', true );

	echo '<div class="entry-meta">';
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		if ( $show_author_avatar || $show_author_name ) {
			
			echo '<div class="byline">';

				if( $show_author_avatar ) {
					echo '<div class="vcard">' . get_avatar( get_the_author_meta( 'ID' ), 96 ) . '</div>';
				}

				if( $show_author_name ) {
					echo '<div class="label">' . esc_attr( __( 'Posted by ', 'shapla' ) ) . '</div>';
					echo '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>';
				}

			echo '</div>';
		}

		if ( $show_date ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			echo '<div class="posted-on"><div class="label">'. esc_html__('Posted on ', 'shapla' ) .'</div><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></div>';
		}

		if ( $show_category_list ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ' ', 'shapla' ) );
			if ( $categories_list ) {
				printf( '<div class="cat-links"><div class="label">'. esc_html__( 'Posted in ', 'shapla' ) .'</div>' . esc_html__( '%1$s', 'shapla' ) . '</div>', $categories_list ); // WPCS: XSS OK.
			}
		}

		if ( $show_tag_list ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'shapla' ) );
			if ( $tags_list ) {
				printf( '<div class="tags-links"><div class="label">'. esc_html__( 'Tagged ', 'shapla' ) .'</div>' . esc_html__( '%1$s', 'shapla' ) . '</div>', $tags_list ); // WPCS: XSS OK.
			}
		}

	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		if ( $show_comments_link ) {
			echo '<div class="comments-link">';
			echo '<div class="label">' . esc_attr( __( 'Comments', 'shapla' ) ) . '</div>';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'shapla' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</div>';
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'shapla' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<div class="edit-link"><div class="label">',
		'</div></div>'
	);

	echo '</div>';
}
endif;

if( ! function_exists( 'shapla_page_header' ) ):
/**
 * Display the page header with a link to the single post
 *
 * @since 1.0.0
 */
function shapla_page_header()
{
	global $post;
	$hide_title = get_post_meta( $post->ID, '_shapla_hide_page_title', true );
	if ( $hide_title == 'on') {
		return;
	}
	?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php
}

endif;

if( ! function_exists( 'shapla_page_content' ) ):
/**
 * Display the post content with a link to the single post
 *
 * @since 1.0.0
 */
function shapla_page_content()
{
	?>
		<div class="entry-content">
			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shapla' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	<?php
}

endif;

if( ! function_exists( 'shapla_display_comments' ) ):
/**
 * Shapla display comments
 *
 * @since  1.0.0
 */
function shapla_display_comments()
{
	// If comments are open or we have at least one comment,
	// load up the comment template.
	if ( comments_open() || get_comments_number() ){
		comments_template();
	}
}

endif;

if( ! function_exists( 'shapla_post_header' ) ):
/**
 * Display the post header with a link to the single post
 *
 * @since  1.0.0
 */
function shapla_post_header()
{
	?>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif; ?>
	</header><!-- .entry-header -->
	<?php
}

endif;

if ( ! function_exists( 'shapla_post_content' ) ):
/**
 * Display the post content with a link to the single post
 *
 * @since 1.0.0
 */
function shapla_post_content() {
	?>
	<div class="entry-content">
		<?php
			/**
			 * Functions hooked in to shapla_post_content_before action.
			 *
			 * @hooked shapla_post_thumbnail - 10
			 */
			do_action( 'shapla_post_content_before' );

			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'shapla' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			do_action( 'shapla_post_content_after' );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shapla' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php
}

endif;

if ( ! function_exists('shapla_post_nav')):
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since  1.0.0
 */
function shapla_post_nav()
{
	the_post_navigation();
}

endif;

if ( ! function_exists('shapla_paging_nav')):
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since  1.0.0
 */
function shapla_paging_nav()
{
	the_posts_pagination( array(
		'prev_text'     => __( '&laquo;', 'shapla' ),
		'next_text'     => __( '&raquo;', 'shapla' )
	) );
}

endif;
