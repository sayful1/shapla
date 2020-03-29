<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_Blog' ) ) {

	class Shapla_Blog {

		/**
		 * @var object
		 */
		private static $instance;

		/**
		 * @return Shapla_Blog
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				add_filter( 'body_class', array( self::$instance, 'body_classes' ) );
				add_action( 'shapla_loop_post', array( self::$instance, 'loop_post' ), 5 );

				add_filter( 'excerpt_more', array( self::$instance, 'excerpt_more' ) );
				add_filter( 'excerpt_length', array( self::$instance, 'excerpt_length' ) );
				add_filter( 'term_links-post_tag', array( self::$instance, 'post_tag_links' ) );
			}

			return self::$instance;
		}

		/**
		 * Modify tags link
		 *
		 * @param array $links
		 *
		 * @return array
		 */
		public function post_tag_links( array $links ) {
			foreach ( $links as $index => $link ) {
				$links[ $index ] = '<li>' . $link . '</li>';
			}

			return $links;
		}

		/**
		 * Add body class for blog
		 *
		 * @param $classes
		 *
		 * @return array
		 */
		public function body_classes( $classes ) {
			$blog_layout = get_theme_mod( 'blog_layout', 'grid' );

			// Blog page
			if ( static::is_blog() && 'grid' == $blog_layout ) {
				$classes[] = 'shapla-blog-grid';
			}

			return $classes;
		}

		/**
		 * Filters the number of words in an excerpt.
		 *
		 * @return int
		 */
		public function excerpt_length() {
			$excerpt_length = get_theme_mod( 'blog_excerpt_length', 20 );

			return absint( $excerpt_length );
		}

		/**
		 * Filters the string in the "more" link displayed after a trimmed excerpt.
		 *
		 * @return string
		 */
		public function excerpt_more() {
			return sprintf( '%1$s <a class="read-more" href="%2$s" rel="nofollow"> %3$s</a>',
				__( '...', 'shapla' ),
				get_permalink( get_the_ID() ),
				__( 'Read more', 'shapla' )
			);
		}

		/**
		 * Get grid blog style
		 */
		public function loop_post() {
			$blog_layout = get_theme_mod( 'blog_layout', 'grid' );
			if ( 'grid' == $blog_layout ) {
				$this->get_loop_post_for_grid();

				return;
			}

			$this->get_default_loop_post();
		}

		/**
		 * Default loop post design
		 */
		public function get_default_loop_post() {
			?>
			<div class="blog-grid-inside layout-default">
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="blog-loop-media">
						<?php echo static::post_thumbnail(); ?>
					</div>
				<?php } ?>
				<div class="blog-loop-content">
					<header class="entry-header"><?php echo static::post_title(); ?></header>
					<?php shapla_post_meta(); ?>
					<div class="entry-summary"><?php echo get_the_excerpt(); ?></div>
				</div>
			</div>
			<?php
		}

		/**
		 * Get loop post
		 */
		public function get_loop_post_for_grid() {
			?>
			<div class="blog-grid-inside">
				<?php echo static::post_thumbnail(); ?>
				<header class="entry-header">
					<?php
					echo static::post_category();
					echo static::post_title();
					?>
				</header>
				<div class="entry-summary"><?php echo get_the_excerpt(); ?></div>
				<?php echo static::post_tag(); ?>
				<div class="spacer"></div>
				<footer class="entry-footer">
					<?php
					echo static::post_author();
					echo static::post_date();
					?>
				</footer>
			</div>
			<?php
		}

		/**
		 * Get post thumbnail
		 *
		 * @return string
		 */
		public static function post_thumbnail() {
			if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
				return '';
			}
			$post_thumbnail = get_the_post_thumbnail( null, 'post-thumbnail',
				array( 'alt' => the_title_attribute( array( 'echo' => false ) ) )
			);

			return sprintf( '<a class="post-thumbnail" href="%s">%s</a>',
				esc_url( get_permalink() ), $post_thumbnail
			);
		}

		/**
		 * Get post category
		 *
		 * @return string
		 */
		public static function post_category() {
			$show_category_list = get_theme_mod( 'show_blog_category_list', true );

			$html = '';
			if ( ! $show_category_list ) {
				return $html;
			}

			$categories_list = get_the_category_list( __( ', ', 'shapla' ) );
			if ( $categories_list ) {
				$html .= '<div class="cat-links">' . $categories_list . '</div>';
			}

			return $html;
		}

		/**
		 * Get post tags
		 *
		 * @return string
		 */
		public static function post_tag() {
			$show_tag_list = get_theme_mod( 'show_blog_tag_list', false );

			if ( ( ! is_singular() && $show_tag_list == false ) ) {
				return '';
			}

			$list = get_the_tag_list();
			if ( empty( $list ) || is_wp_error( $list ) || $list == false ) {
				return '';
			}

			return '<ul class="tags-links">' . $list . '</ul>';
		}

		/**
		 * Get post title
		 *
		 * @return string
		 */
		public static function post_title() {
			return sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">%s</a></h2>',
				esc_url( get_permalink() ), get_the_title()
			);
		}

		/**
		 * Get blog entry author
		 *
		 * @return string
		 */
		public static function post_author() {
			$author_avatar = get_theme_mod( 'show_blog_author_avatar', false );
			$author_name   = get_theme_mod( 'show_blog_author_name', true );
			$html          = '';

			if ( ! $author_avatar && ! $author_name ) {
				return $html;
			}

			$size = 32;

			$html .= '<span class="byline">';

			if ( $author_avatar ) {
				$html .= '<span class="author-avatar is-rounded is-' . sprintf( '%sx%s', $size, $size ) . '">';
				$html .= get_avatar( get_the_author_meta( 'ID' ), $size );
				$html .= '</span> ';
			}

			if ( $author_name ) {
				$html .= sprintf(
					'<span class="author vcard">%s <a class="url fn n" href="%s">%s</a></span>',
					esc_html__( 'by', 'shapla' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_html( get_the_author() )
				);
			}

			$html .= '</span>';

			return $html;
		}

		/**
		 * Get blog entry date
		 *
		 * @return string
		 */
		public static function post_date() {
			$show_date        = get_theme_mod( 'show_blog_date', true );
			$blog_date_format = get_theme_mod( 'blog_date_format', 'human' );

			if ( ! $show_date ) {
				return '';
			}

			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			if ( $blog_date_format == 'human' ) {
				$created_time  = sprintf( '%s ago', human_time_diff( get_the_date( 'U' ) ) );
				$modified_time = sprintf( '%s ago', human_time_diff( get_the_modified_date( 'U' ) ) );
			} else {
				$created_time  = get_the_date();
				$modified_time = get_the_modified_date();
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( $created_time ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( $modified_time )
			);

			return sprintf(
				'<span class="posted-on"><a href="%s" rel="bookmark">%s</a></span>',
				esc_url( get_permalink() ),
				$time_string
			);
		}

		/**
		 * Check if it is a blog page
		 *
		 * @return bool
		 */
		public static function is_blog() {
			return ( is_post_type_archive( 'post' ) || is_category() || is_tag() || is_author() || is_home() || is_search() );
		}
	}
}

return Shapla_Blog::init();
