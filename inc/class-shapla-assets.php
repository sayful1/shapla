<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Shapla_Assets {

	/**
	 * The instance of the class
	 *
	 * @var self
	 */
	private static $instance;

	/**
	 * Only one instance of the class can be loaded
	 *
	 * @return self
	 */
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();

			add_filter( 'wp_get_custom_css', array( self::$instance, 'wp_get_custom_css' ) );

			add_action( 'wp_enqueue_scripts', array( self::$instance, 'enqueue_fonts' ), 5 );
			add_action( 'enqueue_block_editor_assets', array( self::$instance, 'enqueue_fonts' ), 1, 1 );

			add_action( 'wp_enqueue_scripts', array( self::$instance, 'shapla_scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'customize_scripts' ), 30 );
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'child_scripts' ), 90 );

			add_action( 'wp_head', array( self::$instance, 'dynamic_css_variables' ), 5 );
			add_action( 'wp_head', array( self::$instance, 'page_inline_style' ), 35 );
		}

		return self::$instance;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since  0.1.0
	 */
	public function shapla_scripts() {
		// Font Awesome Free icons
		wp_enqueue_style( 'shapla-icons', SHAPLA_THEME_URI . '/assets/font-awesome/css/all.min.css',
			array(), '5.5.0', 'all' );

		// Theme stylesheet.
		wp_enqueue_style( 'shapla-style', SHAPLA_THEME_URI . '/assets/css/main.css',
			array(), SHAPLA_THEME_VERSION, 'all' );

		// Theme block stylesheet.
		if ( function_exists( 'has_blocks' ) && has_blocks() ) {
			wp_enqueue_style( 'shapla-block-style', SHAPLA_THEME_URI . '/assets/css/blocks.css',
				array( 'shapla-style' ), SHAPLA_THEME_VERSION );
		}

		// Load theme script.
		wp_enqueue_script( 'shapla-script', SHAPLA_THEME_URI . '/assets/js/main.js',
			array(), SHAPLA_THEME_VERSION, true );

		wp_localize_script( 'shapla-script', 'Shapla', $this->localize_script() );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
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
	 * Filters the Custom CSS Output into the <head>.
	 *
	 * @param string $css
	 *
	 * @return string
	 */
	public function wp_get_custom_css( $css ) {
		if ( is_customize_preview() ) {
			return $css;
		}

		if ( false === get_option( '_shapla_customize_file' ) ) {
			return $css;
		}

		return '';
	}


	/**
	 * Load customize css file if available
	 */
	public function customize_scripts() {
		$customize_file = get_option( '_shapla_customize_file' );

		if ( isset( $customize_file['url'] ) && ! is_customize_preview() ) {
			wp_enqueue_style( 'shapla-customize', $customize_file['url'], array(), $customize_file['created'], 'all' );
		}
	}

	/**
	 * Inline color style
	 */
	public function dynamic_css_variables() {
		$colors = Shapla_Colors::get_colors();
		$fonts  = Shapla_Fonts::get_site_fonts();

		echo '<style type="text/css">:root{';
		foreach ( $colors as $key => $color ) {
			echo '--shapla-' . $key . ':' . $color . ';';
		}
		foreach ( $fonts as $key => $font ) {
			echo '--shapla-' . $key . ':' . $font . ';';
		}
		echo '}</style>' . PHP_EOL;
	}

	/**
	 * Page inline style from meta box
	 */
	public function page_inline_style() {
		if ( ! is_singular() ) {
			return;
		}
		global $post;

		$css = get_post_meta( $post->ID, '_shapla_page_options_css', true );

		if ( empty( $css ) ) {
			return;
		}

		echo '<style type="text/css">' . wp_strip_all_tags( $css ) . '</style>' . PHP_EOL;
	}

	/**
	 * Enqueue google fonts.
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue_fonts() {
		$google_fonts = get_option( '_shapla_google_fonts' );

		if ( ! ( is_array( $google_fonts ) && count( $google_fonts ) ) ) {
			return;
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $google_fonts ) ),
			'subset' => urlencode( apply_filters( 'shapla_google_font_families_subset', 'latin,latin-ext' ) ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		wp_enqueue_style( 'shapla-fonts', $fonts_url, array(), null );
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
			'BackToTopButton'  => array(
				'isEnabled' => get_theme_mod( 'display_go_to_top_button', true ),
			),
		);

		return apply_filters( 'shapla_localize_script', $localize_script );
	}
}

Shapla_Assets::init();
