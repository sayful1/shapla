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
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'customize_scripts' ), 90 );

			add_action( 'wp_enqueue_scripts', array( self::$instance, 'enqueue_fonts' ), 5 );
			add_action( 'enqueue_block_editor_assets', array( self::$instance, 'enqueue_fonts' ), 1, 1 );
		}

		return self::$instance;
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
}

Shapla_Assets::init();
