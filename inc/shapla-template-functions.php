<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shapla template functions.
 */

if ( ! function_exists( 'shapla_header_markup' ) ) {
	/**
	 * Site Header
	 * Function to get site header
	 *
	 * @since 1.4.5
	 */
	function shapla_header_markup() {
		?>
        <header id="masthead" class="site-header" role="banner">
            <div class="shapla-container">
                <div class="site-header-inner">
					<?php
					/**
					 * Functions hooked into shapla_header_inner action
					 */
					do_action( 'shapla_header_inner' ); ?>
                </div>
            </div>
        </header><!-- #masthead -->
		<?php
	}
}

if ( ! function_exists( 'shapla_footer_markup' ) ) {
	/**
	 * Site Footer
	 * Function to get site footer
	 *
	 * @since 1.4.5
	 */
	function shapla_footer_markup() {
		?>
        <footer id="colophon" class="site-footer" role="contentinfo">
            <div class="shapla-container">
                <div class="site-footer-inner">
					<?php
					/**
					 * Functions hooked into shapla_footer_inner action
					 */
					do_action( 'shapla_footer_inner' ); ?>
                </div>
            </div>
        </footer><!-- #colophon -->
		<?php
	}
}

if ( ! function_exists( 'shapla_single_post_content' ) ) {
	/**
	 * Single post content
	 * Function to get site single post content
	 *
	 * @since 1.4.5
	 */
	function shapla_single_post_content() {
		while ( have_posts() ) {
			the_post();

			do_action( 'shapla_single_post_before' );

			get_template_part( 'template-parts/content', 'single' );

			do_action( 'shapla_single_post_after' );
		}
	}
}

if ( ! function_exists( 'shapla_archive_page_content' ) ) {
	/**
	 * Category archive page content
	 * Function to get category archive page content
	 *
	 * @since 1.4.5
	 */
	function shapla_archive_page_content() {
		if ( have_posts() ) {
			get_template_part( 'loop' );
		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
	}
}

if ( ! function_exists( 'shapla_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function shapla_site_branding() {
		?>
        <div class="site-branding">
			<?php echo shapla_site_title_or_logo(); ?>
        </div><!-- .site-branding -->
		<?php
	}
}

if ( ! function_exists( 'shapla_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo image
	 *
	 * @return string
	 * @since 1.0.0
	 *
	 */
	function shapla_site_title_or_logo() {

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( function_exists( 'get_custom_logo' ) && $custom_logo_id ) {
			return get_custom_logo();
		}

		$tag = is_front_page() ? 'h1' : 'p';

		$html = '<' . esc_attr( $tag ) . ' class="site-title">';
		$html .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
		$html .= '</' . esc_attr( $tag ) . '>';

		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) {
			$html .= '<p class="site-description">' . esc_html( $description ) . '</p>';
		}

		return $html;
	}
}

if ( ! function_exists( 'shapla_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function shapla_primary_navigation() {
		$dropdown_direction = get_theme_mod( 'dropdown_direction', 'ltr' );

		$nav_class = 'main-navigation';
		$nav_class .= $dropdown_direction == 'rtl' ? ' dropdown-rtl' : ' dropdown-ltr';
		?>
        <a role="button" class="menu-toggle" data-target="#site-navigation" aria-label="menu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
        <nav id="site-navigation" class="<?php echo esc_attr( $nav_class ); ?>" role="navigation">
			<?php wp_nav_menu( array(
				'theme_location'  => 'primary',
				'menu_class'      => 'primary-menu',
				'menu_id'         => 'primary-menu',
				'container_class' => 'primary-menu-container',
			) ); ?>
        </nav><!-- #site-navigation -->
		<?php
	}
}

if ( ! function_exists( 'shapla_skip_links' ) ) {
	/**
	 * Skip links
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function shapla_skip_links() {
		?>
        <a class="skip-link screen-reader-text"
           href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'shapla' ); ?></a>
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'shapla' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'shapla_search_toggle' ) ) {
	/**
	 * Shapla Search toggle icon
	 *
	 * @return void
	 * @deprecated 1.2.3
	 *
	 * @since  1.0.0
	 */
	function shapla_search_toggle() {
		_deprecated_function( __FUNCTION__, '1.2.3' );

		$show_search_icon = get_theme_mod( 'show_search_icon' );
		$header_layout    = get_theme_mod( 'header_layout', 'default' );
		if ( ! $show_search_icon ) {
			return;
		}
		if ( $header_layout != 'default' ) {
			return;
		}

		return;
		?>
        <span id="search-toggle" class="search-toggle"><i class="fa fa-search"></i></span>
		<?php
	}
}

if ( ! function_exists( 'shapla_footer_widget' ) ) {
	/**
	 * Display Footer widget
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function shapla_footer_widget() {
		$rows    = intval( get_theme_mod( 'footer_widget_rows', 1 ) );
		$regions = intval( get_theme_mod( 'footer_widget_columns', 4 ) );

		for ( $row = 1; $row <= $rows; $row ++ ) :

			// Defines the number of active columns in this footer row.
			for ( $region = $regions; 0 < $region; $region -- ) {
				if ( is_active_sidebar( 'footer-' . strval( $region + $regions * ( $row - 1 ) ) ) ) {
					$columns = $region;
					break;
				}
			}

			if ( isset( $columns ) ) : ?>
                <div id="footer-widget-area" class="footer-widget-area">
                    <div class="shapla-container">
                        <div class=<?php echo '"footer-widgets row-' . strval( $row ) . ' col-' . strval( $columns ) . '"'; ?>><?php

							for ( $column = 1; $column <= $columns; $column ++ ) :
								$footer_n = $column + $regions * ( $row - 1 );

								if ( is_active_sidebar( 'footer-' . strval( $footer_n ) ) ) : ?>

                                <div class="widget-block footer-widget-<?php echo strval( $column ); ?>">
									<?php dynamic_sidebar( 'footer-' . strval( $footer_n ) ); ?>
                                    </div><?php

								endif;
							endfor; ?>

                        </div><!-- .footer-widgets.row-<?php echo strval( $row ); ?> -->
                    </div>
                </div>
				<?php

				unset( $columns );
			endif;
		endfor;

		/**
		 * Deprecated on version 1.2.1 and
		 * will be removed on version 2.0.0
		 */
		if ( is_active_sidebar( 'sidebar-2' ) ):
			?>
            <div id="footer-widget-area" class="footer-widget-area">
                <div class="shapla-container">
                    <div class="footer-widget">
						<?php dynamic_sidebar( 'sidebar-2' ); ?>
                    </div>
                </div>
            </div>
		<?php
		endif;
	}
}

if ( ! function_exists( 'shapla_site_info' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function shapla_site_info() {
		$default        = shapla_footer_credits();
		$copyright_text = get_theme_mod( 'site_copyright_text' );
		$class          = 'site-info';
		$class          .= has_nav_menu( 'social-nav' ) ? ' has-social-icons' : ' no-social-icons';
		?>
        <div class="<?php echo esc_attr( $class ); ?>">
			<?php
			if ( ! empty( $copyright_text ) ) {
				echo wp_kses_post( $copyright_text );
			} else {
				echo wp_kses_post( $default );
			}
			?>
        </div><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'shapla_social_navigation' ) ) {
	/**
	 * Display Footer widget
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function shapla_social_navigation() {
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
		$show_comments_link = get_theme_mod( 'show_blog_comments_link', true );

		echo '<div class="entry-meta">';
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			echo Shapla_Blog::post_author();
			echo Shapla_Blog::post_date();
			echo Shapla_Blog::post_category();
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			if ( $show_comments_link ) {
				echo '<div class="comments-link">';
				/* translators: %s: post title */
				comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>',
					'shapla' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
				echo '</div>';
			}
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( '%s Edit %s', 'shapla' ),
				'<span class="shapla-icon"><i class="fas fa-pencil-alt"></i></span>',
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<div class="edit-link">',
			'</div>'
		);

		echo '</div>';
		echo Shapla_Blog::post_tag();
	}
endif;

if ( ! function_exists( 'shapla_page_header' ) ):
	/**
	 * Display the page header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function shapla_page_header() {
		global $post;

		$title = get_the_title();

		if ( is_search() ) {
			$title = sprintf( esc_html__( 'Search Results for: %s', 'shapla' ),
				'<span>' . get_search_query() . '</span>'
			);
		}
		if ( is_archive() ) {
			$title = get_the_archive_title();
		}

		if ( is_404() ) {
			$title = esc_html__( 'Page not found.', 'shapla' );
		}

		if ( is_singular() && $post instanceof \WP_Post ) {
			$hide_page_title = shapla_page_option( 'hide_page_title' );
			if ( Shapla_Sanitize::checked( $hide_page_title ) ) {
				return;
			}

			/**
			 * @deprecated 1.4.2
			 */
			if ( empty( $hide_page_title ) && 'on' == get_post_meta( $post->ID, '_shapla_hide_page_title', true ) ) {
				return;
			}
		}

		// Blog page (with the latest posts)
		if ( is_home() && ! is_front_page() ) {
			if ( ! get_theme_mod( 'show_blog_page_title', true ) ) {
				return;
			}
			$title = get_the_title( get_option( 'page_for_posts' ) );
		}

		// Default homepage (with the latest posts)
		if ( is_front_page() && is_home() ) {
			if ( ! get_theme_mod( 'show_blog_page_title', true ) ) {
				return;
			}

			$title = get_theme_mod( 'blog_page_title', esc_html__( 'Blog', 'shapla' ) );
		}

		if ( shapla_is_woocommerce_activated() ) {
			if ( is_search() || is_tax() || is_shop() ) {
				$title = woocommerce_page_title( false );
			}

			if ( is_page() && is_wc_endpoint_url() ) {
				$endpoint = WC()->query->get_current_endpoint();
				if ( $endpoint_title = WC()->query->get_endpoint_title( $endpoint ) ) {
					$title = $endpoint_title;
				}
			}
		}

		$class = 'page-title-bar clear';

		$alignment = get_theme_mod( 'page_title_bar_text_alignment', 'left' );
		if ( ! empty( $alignment ) ) {
			$class .= ' page-title-bar-' . $alignment;
		}

		?>
        <div class="<?php echo $class; ?>">
            <div class="shapla-container">
                <div class="entry-title-container">
					<?php do_action( 'shapla_before_page_title' ); ?>
                    <div class="entry-header">
                        <h1 class="entry-title">
							<?php echo $title; ?>
                        </h1>
                    </div>
					<?php do_action( 'shapla_after_page_title' ); ?>
                </div>
            </div>
        </div><!-- .page-title-bar -->
		<?php
	}

endif;

if ( ! function_exists( 'shapla_blog_header' ) ):
	/**
	 * Display the page header with a link to the single post
	 *
	 * @since 1.1.6
	 */
	function shapla_blog_header() {

		_deprecated_function( __FUNCTION__, '1.4.0', 'shapla_page_header' );

		$show_blog_page_title = get_theme_mod( 'show_blog_page_title', true );
		if ( ! $show_blog_page_title ) {
			return '';
		}
		if ( is_home() && ! is_front_page() ): ?>
            <header class="page-header">
                <h1 class="page-title">
					<?php echo get_the_title( get_option( 'page_for_posts' ) ); ?>
                </h1>
            </header>
		<?php endif;
	}

endif;

if ( ! function_exists( 'shapla_page_content' ) ):
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function shapla_page_content() {
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

if ( ! function_exists( 'shapla_404_page_content' ) ) {
	/**
	 * Shapla 404 page content
	 *
	 * @since 1.4.5
	 */
	function shapla_404_page_content() {
		?>
        <section class="error-404 not-found">
            <div class="page-content">
				<?php
				echo '<p>';
				esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?',
					'shapla' );
				echo '</p>';

				get_search_form();

				the_widget( 'WP_Widget_Recent_Posts' );

				/* translators: %1$s: smiley */
				$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s',
						'shapla' ), convert_smilies( ':)' ) ) . '</p>';
				the_widget( 'WP_Widget_Archives',
					array( 'dropdown' => true ),
					array( "after_title" => '</h2>' . $archive_content )
				);

				the_widget( 'WP_Widget_Tag_Cloud' );
				?>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
		<?php
	}
}

if ( ! function_exists( 'shapla_display_comments' ) ):
	/**
	 * Shapla display comments
	 *
	 * @since  1.0.0
	 */
	function shapla_display_comments() {
		// If comments are open or we have at least one comment,
		// load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}

endif;

if ( ! function_exists( 'shapla_post_header' ) ):
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since  1.0.0
	 */
	function shapla_post_header() {
		?>
        <header class="entry-header">
			<?php
			the_title(
				'<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">',
				'</a></h2>'
			);
			?>
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
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'shapla' ),
					array( 'span' => array( 'class' => array() ) ) ),
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

if ( ! function_exists( 'shapla_navigation' ) ):
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @since  1.0.0
	 */
	function shapla_navigation() {
		$args = apply_filters( 'shapla_post_navigation_args', array(
			'next_text' => '<div class="nav-next-text">' .
			               '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'shapla' ) . '</span> ' .
			               '<span class="screen-reader-text">' . __( 'Next post:', 'shapla' ) . '</span> ' .
			               '<span class="post-title">%title</span>' .
			               '</div>',
			'prev_text' => '<div class="nav-previous-text">' .
			               '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'shapla' ) . '</span> ' .
			               '<span class="screen-reader-text">' . __( 'Previous post:', 'shapla' ) . '</span> ' .
			               '<span class="post-title">%title</span>' .
			               '</div>',
		) );
		echo get_the_post_navigation( $args );
	}

endif;

if ( ! function_exists( 'shapla_pagination' ) ):
	/**
	 * Display a set of page numbers with links to the previous and next pages of posts.
	 *
	 * @since  1.0.0
	 */
	function shapla_pagination() {
		the_posts_pagination( array(
			'prev_text' => '<span class="screen-reader-text">' . __( 'Previous', 'shapla' ) . __( '&laquo;', 'shapla' ),
			'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'shapla' ) . __( '&raquo;', 'shapla' )
		) );
	}

endif;

if ( ! function_exists( 'shapla_search_form' ) ) {
	/**
	 * Shapla Search form
	 *
	 * @param bool $echo
	 *
	 * @return string|void
	 * @since 1.0.0
	 */
	function shapla_search_form( $echo = true ) {
		$html = '<div class="shapla-search">';
		if ( shapla_is_woocommerce_activated() ) {
			$html .= get_product_search_form( false );
		} else {
			$html .= get_search_form();
		}
		$html .= '</div>';

		$search_form = apply_filters( 'shapla_search_form', $html );

		if ( ! $echo ) {
			return $search_form;
		}

		echo $search_form;
	}
}

if ( ! function_exists( 'shapla_default_search' ) ) {
	/**
	 * WooCommerce Product Search
	 *
	 * @return  void
	 * @since   1.3.0
	 */
	function shapla_default_search() {
		if ( shapla_is_woocommerce_activated() ) {
			return;
		}

		$header_layout = get_theme_mod( 'header_layout', 'layout-1' );
		if ( $header_layout != 'layout-3' ) {
			return;
		}

		shapla_search_form();
	}
}


if ( ! function_exists( 'shapla_search_icon' ) ) {
	/**
	 * Filters the HTML list content for navigation menus.
	 *
	 * @param string $items The HTML list content for the menu items.
	 * @param stdClass $args An object containing wp_nav_menu() arguments.
	 *
	 * @return string
	 * @since 1.3.0
	 */
	function shapla_search_icon( $items, $args ) {
		$show_search_icon = get_theme_mod( 'show_search_icon', false );
		$header_layout    = get_theme_mod( 'header_layout', 'layout-1' );

		if ( 'primary' == $args->theme_location && $header_layout != 'layout-3' && $show_search_icon ) {
			ob_start(); ?>
            <li class="shapla-custom-menu-item shapla-main-menu-search">
                <a href="#" id="search-toggle" class="shapla-search-toggle">
                    <span class="shapla-icon"><i class="fa fa-search"></i></span>
                </a>
                <div class="shapla-custom-menu-item-contents">
					<?php shapla_search_form(); ?>
                </div>
            </li>
			<?php
			$items .= ob_get_clean();
		}

		return $items;
	}
}

if ( ! function_exists( 'shapla_breadcrumb' ) ) {
	/**
	 * Display breadcrumb
	 *
	 * @since  1.4.0
	 */
	function shapla_breadcrumb() {
		$breadcrumbs_separator = get_theme_mod( 'breadcrumbs_separator', 'slash' );
		$is_hidden_mobile      = get_theme_mod( 'breadcrumbs_on_mobile_devices', 'off' );
		$content_display       = get_theme_mod( 'breadcrumbs_content_display', 'breadcrumb' );

		$class = 'breadcrumb';
		if ( ! empty( $breadcrumbs_separator ) ) {
			$class .= ' has-' . $breadcrumbs_separator . '-separator';
		}

		if ( 'off' == $is_hidden_mobile ) {
			$class .= ' is-hidden-mobile';
		}

		if ( 'none' == $content_display ) {
			$class .= ' is-hidden';
		}

		if ( is_page() || is_single() ) {
			global $post;
			$page_options = get_post_meta( $post->ID, '_shapla_page_options', true );
			if ( ! empty( $page_options['show_breadcrumbs'] ) && 'default' != $page_options['show_breadcrumbs'] ) {
				if ( ! Shapla_Sanitize::checked( $page_options['show_breadcrumbs'] ) ) {
					$class .= ' is-hidden';
				}
			}
		}

		$args = apply_filters( 'shapla_wc_breadcrumb', array(
			'delimiter'   => '',
			'wrap_before' => '<nav class="' . $class . '"><ul>',
			'wrap_after'  => '</ul></nav>',
			'before'      => '<li>',
			'after'       => '</li>',
			'home'        => _x( 'Home', 'breadcrumb', 'shapla' ),
		) );

		// Implement Yoast SEO breadcrumbs if available
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$options = get_option( 'wpseo_internallinks' );
			if ( $options['breadcrumbs-enable'] === true ) {
				yoast_breadcrumb( '<nav class="' . $class . '">', '</nav>', true );

				return;
			}
		}

		// Implement WooCommerce breadcrumbs if available
		if ( function_exists( 'woocommerce_breadcrumb' ) ) {
			woocommerce_breadcrumb( $args );

			return;
		}

		$breadcrumbs = new Shapla_Breadcrumb();

		if ( ! empty( $args['home'] ) ) {
			$breadcrumbs->add_crumb( $args['home'], apply_filters( 'shapla_breadcrumb_home_url', home_url() ) );
		}

		$args['breadcrumb'] = $breadcrumbs->generate();


		/**
		 * Shapla Breadcrumb hook
		 *
		 * @hooked Shapla_Structured_Data::generate_breadcrumb_data() - 10
		 */
		do_action( 'shapla_breadcrumb', $breadcrumbs, $args );

		if ( ! empty( $args['breadcrumb'] ) ) {

			echo $args['wrap_before'];

			foreach ( $args['breadcrumb'] as $key => $crumb ) {

				if ( empty( $crumb[0] ) ) {
					continue;
				}

				echo $args['before'];

				if ( ! empty( $crumb[1] ) && sizeof( $args['breadcrumb'] ) !== $key + 1 ) {
					echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
				} else {
					echo esc_html( $crumb[0] );
				}

				echo $args['after'];

				if ( sizeof( $args['breadcrumb'] ) !== $key + 1 ) {
					echo $args['delimiter'];
				}
			}

			echo $args['wrap_after'];

		}
	}
}

if ( ! function_exists( 'shapla_scroll_to_top_button' ) ) {
	/**
	 * Display scroll to top button
	 *
	 * @since 1.4.1
	 */
	function shapla_scroll_to_top_button() {
		if ( false === get_theme_mod( 'display_go_to_top_button', true ) ) {
			return;
		}
		?>
        <span id="shapla-back-to-top" class="back-to-top" data-distance="500">
            <span class="screen-reader-text"><?php esc_html_e( 'Scroll to Top', 'shapla' ) ?></span>
        </span>
		<?php
	}
}

if ( ! function_exists( 'shapla_comment' ) ) {
	/**
	 * Shapla comment template
	 *
	 * @param \WP_Comment $comment the comment array.
	 * @param array $args the comment args.
	 * @param int $depth the comment depth.
	 *
	 * @since 1.4.3
	 */
	function shapla_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		$class         = empty( $args['has_children'] ) ? '' : 'parent';
		$comment_class = join( ' ', get_comment_class( $class, $comment ) );
		?>
        <<?php echo esc_attr( $tag ); ?> class="<?php echo $comment_class; ?>" id="comment-<?php comment_ID() ?>">

        <div class="comment-body">
        <div class="comment-meta">
            <div class="comment-author vcard">
				<?php echo get_avatar( $comment, 128 ); ?>
				<?php printf( wp_kses_post( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
            </div>
			<?php if ( '0' == $comment->comment_approved ) : ?>
                <em class="comment-awaiting-moderation">
					<?php esc_attr_e( 'Your comment is awaiting moderation.', 'shapla' ); ?>
                </em><br/>
			<?php endif; ?>

            <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>"
               class="comment-date">
				<?php echo '<time datetime="' . get_comment_date( 'c' ) . '">' . get_comment_date() . '</time>'; ?>
            </a>
        </div>

		<?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-content">
	<?php endif; ?>

        <div class="comment-text">
			<?php comment_text(); ?>
        </div>

        <div class="reply">
			<?php comment_reply_link( array_merge( $args, array(
				'add_below' => $add_below,
				'depth'     => $depth,
				'max_depth' => $args['max_depth']
			) ) ); ?>
			<?php edit_comment_link( __( 'Edit', 'shapla' ), '  ', '' ); ?>
        </div>

        </div>
		<?php if ( 'div' != $args['style'] ) : ?>
            </div>
		<?php endif; ?>
		<?php
	}
}
