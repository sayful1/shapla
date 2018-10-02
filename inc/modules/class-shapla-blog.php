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
			}

			return self::$instance;
		}

		/**
		 * Shapla_Blog constructor.
		 */
		public function __construct() {
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			add_action( 'shapla_loop_post', array( $this, 'blog' ), 5 );

			add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
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
			if ( $this->is_blog() && 'grid' == $blog_layout ) {
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
			return sprintf( '<a class="read-more" href="%1$s" rel="nofollow"> %2$s</a>',
				get_permalink( get_the_ID() ),
				__( '...', 'shapla' )
			);
		}

		/**
		 * Get grid blog style
		 */
		public function blog() {

			$show_author_avatar = get_theme_mod( 'show_blog_author_avatar', true );
			$show_tag_list      = get_theme_mod( 'show_blog_tag_list', true );
			$show_comments_link = get_theme_mod( 'show_blog_comments_link', true );

			$blog_layout = get_theme_mod( 'blog_layout', 'grid' );
			if ( 'grid' != $blog_layout ) {
				return;
			}

			remove_action( 'shapla_loop_post', 'shapla_post_thumbnail', 10 );
			remove_action( 'shapla_loop_post', 'shapla_post_header', 10 );
			remove_action( 'shapla_loop_post', 'shapla_post_meta', 20 );
			remove_action( 'shapla_loop_post', 'shapla_post_content', 30 );
			?>
			<div class="blog-grid-inside">
				<?php $this->post_thumbnail(); ?>
				<header class="entry-header">
					<?php
					$this->post_category();
					$this->post_title();
					?>
				</header>
				<div class="entry-summary"><?php echo get_the_excerpt(); ?></div>
				<?php $this->post_tag(); ?>
				<footer class="entry-footer">
					<?php
					$this->post_author();
					$this->post_date();
					?>
				</footer>
			</div>
			<?php
		}

		/**
		 * Get post thumbnail
		 *
		 * @param bool $echo
		 *
		 * @return string
		 */
		public function post_thumbnail( $echo = true ) {
			$post_thumbnail = get_the_post_thumbnail( null, 'post-thumbnail',
				array( 'alt' => the_title_attribute( array( 'echo' => false ) ) )
			);

			$_thumbnail = sprintf( '<a class="post-thumbnail" href="%s">%s</a>',
				esc_url( get_permalink() ), $post_thumbnail
			);

			if ( ! $echo ) {
				return $_thumbnail;
			}

			echo $_thumbnail;
		}

		/**
		 * Get post category
		 *
		 * @param bool $echo
		 *
		 * @return string
		 */
		public function post_category( $echo = true ) {
			$show_category_list = get_theme_mod( 'show_blog_category_list', true );

			$html = '';
			if ( $show_category_list ) {
				$categories_list = get_the_category_list( esc_html__( ', ', 'shapla' ) );
				if ( $categories_list ) {
					$html .= '<div class="cat-links">' . $categories_list . '</div>';
				}
			}

			if ( ! $echo ) {
				return $html;
			}

			echo $html;
		}

		/**
		 * Get post tags
		 *
		 * @param bool $echo
		 *
		 * @return string
		 */
		public function post_tag( $echo = true ) {
			$show_tag_list = get_theme_mod( 'show_blog_tag_list', false );
			$tags_list     = get_the_tag_list( '', esc_html__( ', ', 'shapla' ) );
			$html          = '';

			if ( $show_tag_list && $tags_list ) {
				$html .= '<div class="tags-links">';
				$html .= $tags_list;
				$html .= '</div>';
			}

			if ( ! $echo ) {
				return $html;
			}

			echo $html;
		}

		/**
		 * Get post title
		 *
		 * @param bool $echo
		 *
		 * @return string
		 */
		public function post_title( $echo = true ) {
			$title = sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">%s</a></h2>',
				esc_url( get_permalink() ), get_the_title()
			);

			if ( ! $echo ) {
				return $title;
			}

			echo $title;
		}

		/**
		 * Get blog entry author
		 *
		 * @param bool $echo
		 *
		 * @return string
		 */
		public function post_author( $echo = true ) {
			$_author_avatar = get_theme_mod( 'show_blog_author_avatar', false );
			$_author_name   = get_theme_mod( 'show_blog_author_name', true );
			$html           = '';

			if ( ! $_author_avatar && ! $_author_name ) {
				return '';
			}

			$html .= '<span class="byline">';

			if ( $_author_avatar ) {
				$html .= '<span class="vcard">' . get_avatar( get_the_author_meta( 'ID' ), 20 ) . '</span> ';
			}

			if ( $_author_name ) {
				$html .= sprintf(
					'<span class="author">%s <a class="url fn n" href="%s">%s</a></span>',
					esc_html__( 'by', 'shapla' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_html( get_the_author() )
				);
			}

			$html .= '</span>';

			if ( ! $echo ) {
				return $html;
			}

			echo $html;
		}

		/**
		 * Get blog entry date
		 *
		 * @param bool $echo
		 *
		 * @return string
		 */
		public function post_date( $echo = true ) {
			$show_date        = get_theme_mod( 'show_blog_date', true );
			$blog_date_format = get_theme_mod( 'blog_date_format', 'human' );

			if ( $show_date ) {
				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
				if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
					$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
				}

				if ( $blog_date_format == 'human' ) {
					$_created_time  = sprintf( '%s ago', human_time_diff( get_the_date( 'U' ) ) );
					$_modified_time = sprintf( '%s ago', human_time_diff( get_the_modified_date( 'U' ) ) );
				} else {
					$_created_time  = get_the_date();
					$_modified_time = get_the_modified_date();
				}

				$time_string = sprintf( $time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( $_created_time ),
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( $_modified_time )
				);

				$date_string = sprintf(
					'<span class="posted-on"><a href="%s" rel="bookmark">%s</a></span>',
					esc_url( get_permalink() ),
					$time_string
				);

				if ( ! $echo ) {
					return $date_string;
				}

				echo $date_string;
			}
		}

		/**
		 * Check if it is a blog page
		 *
		 * @return bool
		 */
		private function is_blog() {
			return ( is_post_type_archive( 'post' ) || is_category() || is_tag() || is_author() || is_home() || is_search() );
		}
	}
}

return Shapla_Blog::init();
