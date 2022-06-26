<?php

defined( 'ABSPATH' ) || exit;

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

			add_action( 'wp_enqueue_scripts', array( self::$instance, 'enqueue_fonts' ), 1 );
			add_action( 'enqueue_block_editor_assets', array( self::$instance, 'enqueue_fonts' ), 1, 1 );

			add_action( 'wp_enqueue_scripts', array( self::$instance, 'shapla_scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'customize_scripts' ), 30 );
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'child_scripts' ), 90 );

			add_action( 'admin_head', array( self::$instance, 'dynamic_css_variables' ), 5 );
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
		wp_enqueue_style(
			'fontawesome-free',
			SHAPLA_THEME_URI . '/assets/css/fontawesome-free.css',
			array(),
			'6.0.0',
			'all'
		);

		// Theme stylesheet.
		wp_enqueue_style(
			'shapla-style',
			apply_filters( 'shapla_main_stylesheet_uri', SHAPLA_THEME_URI . '/assets/css/main.css' ),
			array(),
			SHAPLA_THEME_VERSION,
			'all'
		);

		// Theme block stylesheet.
		if ( function_exists( 'has_blocks' ) && has_blocks() ) {
			wp_enqueue_style(
				'shapla-block-style',
				SHAPLA_THEME_URI . '/assets/css/blocks.css',
				array( 'shapla-style' ),
				SHAPLA_THEME_VERSION
			);
		}

		// Load theme script.
		wp_enqueue_script(
			'shapla-script',
			SHAPLA_THEME_URI . '/assets/js/main.js',
			array(),
			SHAPLA_THEME_VERSION,
			true
		);

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
		if ( is_child_theme() && apply_filters( 'shapla_load_child_style', true ) ) {
			wp_enqueue_style( 'shapla-child-style', get_stylesheet_uri() );
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
		$colors           = \Shapla\Helpers\Colors::get_colors();
		$fonts            = Shapla_Fonts::get_site_fonts();
		$widget_styles    = static::footer_widget_dynamic_css_variables();
		$footer_styles    = static::footer_dynamic_css_variables();
		$title_bar_styles = static::page_title_bar_dynamic_css_variables();
		$header_styles    = static::page_header_dynamic_css_variables();

		$style = '<style id="shapla-styles-inline-css" type="text/css">' . PHP_EOL;
		// Root style
		$style .= 'body{';
		foreach ( $colors as $key => $color ) {
			$style .= '--shapla-' . $key . ':' . $color . ';';
		}
		$style .= '}' . PHP_EOL;

		$style .= 'body{';
		foreach ( $fonts as $key => $font ) {
			$style .= '--shapla-' . $key . ':' . $font . ';';
		}
		$style .= '}' . PHP_EOL;

		// Page title bar
		$style .= '.site-header{';
		$style .= $header_styles;
		$style .= '}' . PHP_EOL;

		// Page title bar
		$style .= '.page-title-bar{';
		$style .= $title_bar_styles;
		$style .= '}' . PHP_EOL;

		// Footer Widget Area
		$style .= '.footer-widget-area{';
		$style .= $widget_styles;
		$style .= '}' . PHP_EOL;

		// Footer Area
		$style .= '.site-footer{';
		$style .= $footer_styles;
		$style .= '}' . PHP_EOL;

		$style .= '</style>' . PHP_EOL;

		echo $style;
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
		$google_fonts = get_option( '_shapla_google_fonts', array( 'Roboto:400,500' ) );

		if ( ! ( is_array( $google_fonts ) && count( $google_fonts ) ) ) {
			return;
		}

		$query_args = array(
			'family'  => urlencode( implode( '|', $google_fonts ) ),
			'subset'  => urlencode( apply_filters( 'shapla_google_font_families_subset', 'latin,latin-ext' ) ),
			'display' => 'swap',
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		wp_enqueue_style( 'shapla-fonts', shapla_get_webfont_url( $fonts_url ), array(), null );

		if ( shapla_get_option( 'preload_local_fonts', true ) ) {
			shapla_load_preload_local_fonts( $fonts_url );
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
				'isEnabled' => shapla_get_option( 'sticky_header', false ),
				'minWidth'  => 1025,
				'classes'   => array(
					'body'    => 'has-fixed-header',
					'initial' => 'header--fixed',
					'top'     => 'header--top',
					'notTop'  => 'header--not-top',
				),
			),
			'BackToTopButton'  => array(
				'isEnabled' => shapla_get_option( 'display_go_to_top_button', true ),
			),
		);

		return apply_filters( 'shapla_localize_script', $localize_script );
	}

	/**
	 * Dynamic CSS variables for footer widget area
	 *
	 * @return string
	 */
	public static function footer_widget_dynamic_css_variables() {
		$background_default = array(
			'background-color'      => shapla_default_options( 'footer_widget_background_color' ),
			'background-image'      => 'none',
			'background-repeat'     => 'no-repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'fixed',
		);

		$background = (array) shapla_get_option( 'footer_widget_background', $background_default );
		$text_color = shapla_get_option( 'footer_widget_text_color', shapla_default_options( 'footer_widget_text_color' ) );
		$link_color = shapla_get_option( 'footer_widget_link_color', shapla_default_options( 'footer_widget_link_color' ) );

		$styles = array(
			'text-primary' => $text_color,
			'text-accent'  => $link_color,
		);

		// Background style
		foreach ( $background as $property => $value ) {
			if ( empty( $value ) || empty( $property ) ) {
				continue;
			}

			if ( isset( $background_default[ $property ] ) && $value == $background_default[ $property ] ) {
				continue;
			}

			if ( 'background-image' == $property ) {
				if ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
					$value = 'url(' . $value . ')';
				} else {
					$value = 'none';
				}
			}
			$styles[ $property ] = $value;
		}

		$string = '';
		foreach ( $styles as $key => $color ) {
			$string .= '--footer-widget-' . $key . ':' . $color . ';';
		}

		return $string;
	}

	/**
	 * Footer dynamic CSS variables
	 *
	 * @return string
	 */
	public static function footer_dynamic_css_variables() {
		$default_background_color = shapla_default_options( 'site_footer_bg_color' );
		$default_text_color       = shapla_default_options( 'site_footer_text_color' );
		$default_link_color       = shapla_default_options( 'site_footer_link_color' );

		$background_color = shapla_get_option( 'site_footer_bg_color', $default_background_color );
		$text_color       = shapla_get_option( 'site_footer_text_color', $default_text_color );
		$link_color       = shapla_get_option( 'site_footer_link_color', $default_link_color );

		$string = '--footer-background-color:' . $background_color . ';';
		$string .= '--footer-text-primary:' . $text_color . ';';
		$string .= '--footer-text-accent:' . $link_color . ';';

		return $string;
	}

	/**
	 * Page title bar dynamic CSS variables
	 *
	 * @return string
	 */
	public static function page_title_bar_dynamic_css_variables() {
		$background_default = array(
			'background-color'      => shapla_default_options( 'page_title_bar_background_color' ),
			'background-image'      => shapla_default_options( 'page_title_bar_background_image' ),
			'background-repeat'     => shapla_default_options( 'page_title_bar_background_repeat' ),
			'background-position'   => shapla_default_options( 'page_title_bar_background_position' ),
			'background-size'       => shapla_default_options( 'page_title_bar_background_size' ),
			'background-attachment' => shapla_default_options( 'page_title_bar_background_attachment' ),
		);

		$background = shapla_get_option( 'page_title_bar_background', $background_default );

		$typography_default = array(
			'font-size'      => shapla_default_options( 'page_title_font_size' ),
			'line-height'    => shapla_default_options( 'page_title_line_height' ),
			'color'          => shapla_default_options( 'page_title_font_color' ),
			'text-transform' => shapla_default_options( 'page_title_text_transform' ),
		);
		$typography         = shapla_get_option( 'page_title_typography', $typography_default );

		$defaults = array_merge(
			$background_default,
			$typography_default,
			array(
				'padding'      => shapla_default_options( 'page_title_bar_padding' ),
				'border-color' => shapla_default_options( 'page_title_bar_border_color' ),
			)
		);

		$values = array_merge(
			$background,
			$typography,
			array(
				'padding'      => shapla_get_option( 'page_title_bar_padding', $defaults['padding'] ),
				'border-color' => shapla_get_option( 'page_title_bar_border_color', $defaults['border-color'] ),
			)
		);

		$string = '';
		foreach ( $values as $property => $value ) {
			if ( empty( $value ) || empty( $property ) ) {
				continue;
			}
			if ( isset( $defaults[ $property ] ) && $value == $defaults[ $property ] ) {
				continue;
			}

			if ( 'font-backup' == $property ) {
				continue;
			}

			if ( 'background-image' == $property ) {
				if ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
					$value = 'url(' . $value . ')';
				} else {
					$value = 'none';
				}
			}

			$string .= '--title-bar-' . $property . ':' . $value . ';';
		}

		return $string;
	}

	/**
	 * Page title bar dynamic CSS variables
	 *
	 * @return string
	 */
	public static function page_header_dynamic_css_variables() {
		$default_logo_font_size = shapla_default_options( 'site_logo_text_font_size' );
		$default_background     = shapla_default_options( 'header_background_color' );
		$default_text_color     = shapla_default_options( 'header_text_color' );
		$default_link_color     = shapla_default_options( 'header_link_color' );

		$logo_font_size   = shapla_get_option( 'site_logo_text_font_size', $default_logo_font_size );
		$background_color = shapla_get_option( 'header_background_color', $default_background );
		$text_color       = shapla_get_option( 'header_text_color', $default_text_color );
		$link_color       = shapla_get_option( 'header_link_color', $default_link_color );
		$submenu_bg       = shapla_get_option( 'submenu_background_color', $default_background );
		$submenu_text     = shapla_get_option( 'submenu_text_color', $default_text_color );
		$submenu_accent   = shapla_get_option( 'submenu_accent_color', $default_link_color );

		$get_header_image = get_header_image();

		if ( $get_header_image ) {
			$background_image = 'url(' . $get_header_image . ')';
		} else {
			$background_image = 'none';
		}

		$string = '--header-logo-font-size:' . $logo_font_size . ';';
		$string .= '--header-background-image:' . $background_image . ';';
		$string .= '--header-background-color:' . $background_color . ';';
		$string .= '--header-text-color:' . $text_color . ';';
		$string .= '--header-accent-color:' . $link_color . ';';
		$string .= '--submenu-background-color:' . $submenu_bg . ';';
		$string .= '--submenu-text-color:' . $submenu_text . ';';
		$string .= '--submenu-accent-color:' . $submenu_accent . ';';

		return $string;
	}
}

Shapla_Assets::init();
