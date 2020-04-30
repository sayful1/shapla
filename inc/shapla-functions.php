<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'shapla_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function shapla_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' );
	}
}

if ( ! function_exists( 'shapla_is_shaplatools_activated' ) ) {
	/**
	 * Query ShaplaTools activation
	 */
	function shapla_is_shaplatools_activated() {
		return class_exists( 'shaplatools' );
	}
}

if ( ! function_exists( 'shapla_is_carousel_slider_activated' ) ) {
	/**
	 * Query Carousel_Slider activation
	 */
	function shapla_is_carousel_slider_activated() {
		return class_exists( 'Carousel_Slider' );
	}
}

if ( ! function_exists( 'shapla_is_elementor_pro_active' ) ) {
	/**
	 * Query Carousel_Slider activation
	 */
	function shapla_is_elementor_pro_active() {
		return (
			class_exists( '\Elementor\Plugin' ) &&
			class_exists( '\ElementorPro\Modules\ThemeBuilder\Module' ) &&
			version_compare( PHP_VERSION, '5.4', '>=' )
		);
	}
}

if ( ! function_exists( 'shapla_header_styles' ) ) {
	/**
	 * Apply inline style to the Shapla header.
	 *
	 * @uses  get_header_image()
	 */
	function shapla_header_styles() {
		$get_header_image = get_header_image();

		if ( $get_header_image ) {
			$header_bg_image = 'url(' . esc_url( $get_header_image ) . ')';
		} else {
			$header_bg_image = 'none';
		}

		$styles = apply_filters( 'shapla_header_styles', array(
			'background-image' => $header_bg_image,
		) );

		foreach ( $styles as $style => $value ) {
			echo esc_attr( $style . ': ' . $value . '; ' );
		}
	}
}

if ( ! function_exists( 'shapla_find_color_invert' ) ) {
	/**
	 * Find light or dark color for given color
	 *
	 * @param $color
	 *
	 * @return string
	 * @since  1.3.0
	 */
	function shapla_find_color_invert( $color ) {
		return Shapla_Colors::find_color_invert( $color );
	}
}

if ( ! function_exists( 'shapla_adjust_color_brightness' ) ) {
	/**
	 * Adjust a hex color brightness
	 * Allows us to create hover styles for custom link colors
	 *
	 * @param string $color color e.g. #111111.
	 * @param integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
	 *
	 * @return string        brightened/darkened hex color
	 * @since  1.3.0
	 */
	function shapla_adjust_color_brightness( $color, $steps ) {
		return Shapla_Colors::adjust_color_brightness( $color, $steps );
	}
}


if ( ! function_exists( 'shapla_default_options' ) ) {
	/**
	 * Get theme default options
	 *
	 * @param null $key option key
	 * $key has been added since 1.4.5
	 *
	 * @return object
	 * @since  1.3.0
	 */
	function shapla_default_options( $key = null ) {
		$text_color      = Shapla_Colors::get_color( 'text-primary' );
		$heading_color   = Shapla_Colors::get_color( 'text-primary' );
		$primary_color   = Shapla_Colors::get_color( 'primary' );
		$primary_hover   = Shapla_Colors::get_color( 'primary-variant' );
		$primary_inverse = Shapla_Colors::get_color( 'on-primary' );

		$options = apply_filters( 'shapla_default_options', array(
			'heading_color'                         => $heading_color,
			'text_color'                            => $text_color,
			'primary_color'                         => $primary_color,
			'font_family'                           => 'Roboto',
			// Form
			'form_background_color'                 => '#ffffff',
			'form_text_color'                       => $text_color,
			'form_border_color'                     => '#dbdbdb',
			// Blog
			'show_blog_page_title'                  => true,
			'blog_page_title'                       => __( 'Blog', 'shapla' ),
			'blog_layout'                           => 'grid',
			'blog_excerpt_length'                   => 20,
			'blog_date_format'                      => 'human',
			'show_blog_author_avatar'               => true,
			'show_blog_author_name'                 => true,
			'show_blog_date'                        => true,
			'show_blog_category_list'               => true,
			'show_blog_tag_list'                    => false,
			'show_blog_comments_link'               => true,
			// Primary Nav
			'dropdown_direction'                    => 'ltr',
			// Primary Button
			'button_primary_background_color'       => $primary_color,
			'button_primary_background_hover_color' => $primary_hover,
			'button_primary_text_color'             => $primary_inverse,
			'button_primary_text_hover_color'       => $primary_inverse,
			'button_primary_border_radius'          => 3,
			// Header
			'site_logo_text_font_size'              => '30px',
			'header_background_color'               => '#ffffff',
			'header_text_color'                     => $text_color,
			'header_link_color'                     => $primary_color,
			'show_search_icon'                      => false,
			'sticky_header'                         => false,
			// Page Title Bar
			'page_title_bar_padding'                => '2rem',
			'page_title_bar_border_color'           => '#cccccc',
			'page_title_font_size'                  => '2rem',
			'page_title_line_height'                => '1.4',
			'page_title_font_color'                 => $heading_color,
			'page_title_text_transform'             => 'none',
			'page_title_bar_text_alignment'         => 'left',
			'page_title_bar_background_color'       => '#f5f5f5',
			'page_title_bar_background_repeat'      => 'no-repeat',
			'page_title_bar_background_size'        => 'cover',
			'page_title_bar_background_attachment'  => 'fixed',
			'page_title_bar_background_position'    => 'center center',
			'page_title_bar_background_image'       => 'none',
			// Breadcrumbs
			'breadcrumbs_content_display'           => 'breadcrumb',
			'breadcrumbs_on_mobile_devices'         => 'off',
			'breadcrumbs_separator'                 => 'slash',
			'breadcrumbs_font_size'                 => '0.875rem',
			'breadcrumbs_text_color'                => $text_color,
			'breadcrumbs_text_transform'            => 'none',
			// Layout
			'site_layout'                           => 'wide',
			'general_layout'                        => 'right-sidebar',
			'header_layout'                         => 'default',
			// Footer
			'footer_widget_rows'                    => 1,
			'footer_widget_columns'                 => 4,
			'footer_widget_background_color'        => '#212a34',
			'footer_widget_text_color'              => '#f1f1f1',
			'footer_widget_link_color'              => '#f1f1f1',
			'site_footer_bg_color'                  => '#19212a',
			'site_footer_text_color'                => '#9e9e9e',
			'site_footer_link_color'                => '#f1f1f1',
			'site_copyright_text'                   => shapla_footer_credits(),
			// WooCommerce
			'wc_products_per_page'                  => 16,
			'wc_products_per_row'                   => 4,
			'show_cart_icon'                        => true,
			'show_product_search_categories'        => true,
			'wc_highlight_color'                    => $primary_color,
			'wc_highlight_text_color'               => $primary_inverse,
		) );

		if ( ! empty( $key ) && isset( $options[ $key ] ) ) {
			return $options[ $key ];
		}

		return null;
	}
}

if ( ! function_exists( 'shapla_standard_fonts' ) ) {
	/**
	 * Get standard fonts
	 *
	 * @return object
	 * @since  1.3.0
	 */
	function shapla_standard_fonts() {
		$standard_fonts = array(
			'serif'      => 'Georgia,Times,"Times New Roman",serif',
			'sans-serif' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
			'monospace'  => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
		);

		return apply_filters( 'shapla_standard_fonts', $standard_fonts );
	}
}

if ( ! function_exists( 'shapla_footer_credits' ) ) {
	/**
	 * Shapla theme footer credit
	 *
	 * @return string
	 * @since  1.4.0
	 */
	function shapla_footer_credits() {
		return sprintf(
			'<a href="https://wordpress.org/">%1$s</a><span class="sep"> | </span>%2$s %3$s.',
			__( 'Proudly powered by WordPress', 'shapla' ),
			__( 'Theme: Shapla by', 'shapla' ),
			'<a href="https://sayfulislam.com/" rel="designer">Sayful Islam</a>'
		);
	}
}

if ( ! function_exists( 'shapla_page_option' ) ) {
	/**
	 * Get singular post type meta option
	 *
	 * @param string $key
	 * @param string $default
	 *
	 * @return mixed
	 */
	function shapla_page_option( $key = '', $default = '' ) {
		/** \WP_Post $post */
		global $post;
		if ( ! is_singular() ) {
			return '';
		}

		$page_options = get_post_meta( $post->ID, '_shapla_page_options', true );
		if ( ! is_array( $page_options ) ) {
			return '';
		}

		return isset( $page_options[ $key ] ) ? $page_options[ $key ] : $default;
	}
}

if ( ! function_exists( 'shapla_get_post_format' ) ) {

	/**
	 * Get post format
	 *
	 * @return string Return post format.
	 */
	function shapla_get_post_format() {
		$post_format = get_post_format();

		if ( is_single() ) {
			$post_format = 'single';
		}

		if ( is_singular( 'page' ) ) {
			$post_format = 'page';
		}

		if ( is_search() ) {
			$post_format = 'search';
		}

		return apply_filters( 'shapla_get_post_format', $post_format );
	}
}
