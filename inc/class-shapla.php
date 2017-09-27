<?php
/**
 * Shapla Class
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Shapla' ) ) {

	class Shapla {

		private static $instance;

		/**
		 * @return Shapla
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Shapla constructor.
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'shapla_setup' ) );
			add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'shapla_scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 90 );
			add_filter( 'body_class', array( $this, 'body_classes' ) );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since  0.1.0
		 */
		public function shapla_setup() {
			/*
			 * Make theme available for translation.
			 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/shapla
			 * If you're building a theme based on Shapla, use a find and replace
			 * to change 'shapla' to the name of your theme in all the template files.
			 */
			load_theme_textdomain( 'shapla' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );

			/*
			 * Enable support for custom logo.
			 */
			add_theme_support( 'custom-logo', array(
				'height'      => 250,
				'width'       => 250,
				'flex-height' => true,
			) );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			 */
			add_theme_support( 'post-thumbnails' );

			// This theme uses wp_nav_menu() in one location.
			register_nav_menus( array(
				'primary'    => esc_html__( 'Primary', 'shapla' ),
				'social-nav' => esc_html__( 'Social Link', 'shapla' ),
			) );

			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );

			// Set up the WordPress core custom background feature.
			add_theme_support( 'custom-background', apply_filters( 'shapla_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => '',
			) ) );

			// Set up the WordPress core custom header feature.
			add_theme_support( 'custom-header', apply_filters( 'shapla_custom_header_args', array(
				'default-image' => '',
				'header-text'   => false,
				'width'         => 1920,
				'height'        => 500,
				'flex-width'    => true,
				'flex-height'   => true,
			) ) );

			// Indicate widget sidebars can use selective refresh in the Customizer.
			add_theme_support( 'customize-selective-refresh-widgets' );

			/*
			 * This theme styles the visual editor to resemble the theme style,
			 * specifically font, colors, icons, and column width.
			 */
			$editor_style = get_template_directory_uri() . '/assets/css/editor-style.css';
			add_editor_style( $editor_style );
		}

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global int $content_width
		 *
		 * @since  0.1.0
		 */
		public function content_width() {
			$GLOBALS['content_width'] = apply_filters( 'shapla_content_width', 910 );
		}

		/**
		 * Register widget area.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
		 *
		 * @since  0.1.0
		 */
		public function widgets_init() {
			$sidebar_args['sidebar'] = array(
				'name'        => __( 'Sidebar', 'shapla' ),
				'id'          => 'sidebar-1',
				'description' => esc_html__( 'Widgets added to this region will appear beside the main content. Only show left or right sidebar layout.', 'shapla' )
			);

			$rows    = intval( get_theme_mod( 'footer_widget_rows', 1 ) );
			$regions = intval( get_theme_mod( 'footer_widget_columns', 4 ) );

			for ( $row = 1; $row <= $rows; $row ++ ) {
				for ( $region = 1; $region <= $regions; $region ++ ) {
					$footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
					$footer   = sprintf( 'footer_%d', $footer_n );

					if ( 1 == $rows ) {
						$footer_region_name        = sprintf( __( 'Footer Column %1$d', 'shapla' ), $region );
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'shapla' ), $region );
					} else {
						$footer_region_name        = sprintf( __( 'Footer Row %1$d - Column %2$d', 'shapla' ), $row, $region );
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'shapla' ), $region, $row );
					}

					$sidebar_args[ $footer ] = array(
						'name'        => $footer_region_name,
						'id'          => sprintf( 'footer-%d', $footer_n ),
						'description' => $footer_region_description,
					);
				}
			}

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				);

				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 *
				 * 'shapla_sidebar_widget_tags'
				 *
				 * 'shapla_footer_1_widget_tags'
				 * 'shapla_footer_2_widget_tags'
				 * 'shapla_footer_3_widget_tags'
				 * 'shapla_footer_4_widget_tags'
				 */
				$filter_hook = sprintf( 'shapla_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}

			/**
			 * Deprecated on version 1.2.1 and
			 * will be removed on version 2.0.0
			 */
			register_sidebar( array(
				'name'          => esc_html__( 'Above Footer', 'shapla' ),
				'id'            => 'sidebar-2',
				'description'   => esc_html__( 'This region has been deprecated on version 1.2.1 and will be removed on version 2.0.0', 'shapla' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 *
		 * @since  0.1.0
		 * @return array
		 */
		public function body_classes( $classes ) {
			// Adds a class of group-blog to blogs with more than 1 published author.
			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			}

			// Adds a class of hfeed to non-singular pages.
			if ( ! is_singular() ) {
				$classes[] = 'hfeed';
			}

			if ( is_page_template( 'templates/full-width.php' ) ) {
				$classes[] = 'full-width';
			}

			if ( is_page_template( 'templates/full-screen.php' ) ) {
				$classes[] = 'full-screen';
			}

			if ( ! is_page_template( array( 'templates/full-width.php', 'templates/full-screen.php' ) ) ) {
				$general_layout = get_theme_mod( 'general_layout', 'right-sidebar' );
				if ( $general_layout == 'right-sidebar' ) {
					$classes[] = 'right-sidebar';
				} elseif ( $general_layout == 'left-sidebar' ) {
					$classes[] = 'left-sidebar';
				} elseif ( $general_layout == 'full-width' ) {
					$classes[] = 'full-width';
				}
			}

			$site_layout = get_theme_mod( 'site_layout', 'wide' );
			if ( $site_layout == 'boxed' ) {
				$classes[] = 'boxed-layout';
			}

			// If our main sidebar doesn't contain widgets,
			// adjust the layout to be full-width.
			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$classes[] = 'full-width';
			}

			$classes[] = 'shapla';

			return $classes;
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since  0.1.0
		 */
		public function shapla_scripts() {
			// Add custom fonts, used in the main stylesheet.
			wp_enqueue_style( 'shapla-fonts', $this->google_fonts_url(), array(), null );
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), '4.7.0', 'all' );
			wp_enqueue_style( 'shapla-style', get_template_directory_uri() . '/style.css', array(), SHAPLA_VERSION, 'all' );
			wp_enqueue_script( 'shapla-script', get_template_directory_uri() . '/assets/js/script.min.js', array(), SHAPLA_VERSION, true );

			wp_localize_script( 'shapla-script', 'Shapla', $this->localize_script() );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Shapla localize script
		 *
		 * @return array
		 */
		private function localize_script() {
			$localize_script = array(
				'ajaxurl'          => admin_url( 'admin-ajax.php' ),
				'screenReaderText' => array(
					'expand'   => __( 'expand child menu', 'shapla' ),
					'collapse' => __( 'collapse child menu', 'shapla' ),
				),
				'stickyHeader'     => array(
					'isEnabled' => get_theme_mod( 'sticky_header', false ),
					'minWidth'  => 1025,
				),
			);

			return $localize_script;
		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_
		 * the parent theme primary css.
		 *
		 * @since  0.1.0
		 */
		public function child_scripts() {
			if ( is_child_theme() ) {
				wp_enqueue_style( 'shapla-child-style', get_stylesheet_uri(), array() );
			}
		}

		/**
		 * Register Google fonts for Shapla.
		 *
		 * @return string Google fonts URL for the theme.
		 *
		 * @since  0.1.0
		 */
		private function google_fonts_url() {

			$google_fonts = apply_filters( 'shapla_google_font_families', array(
				'roboto'      => 'Roboto:300,400,500,400italic,500italic',
				'inconsolata' => 'Inconsolata:400',
			) );

			$query_args = array(
				'family' => urlencode( implode( '|', $google_fonts ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$fonts_url  = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

			return $fonts_url;
		}
	}

}

return Shapla::init();
