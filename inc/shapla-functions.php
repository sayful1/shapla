<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'shapla_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function shapla_is_woocommerce_activated() {
		return class_exists( 'woocommerce' );
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
		if ( '' === $color ) {
			return '';
		}

		// Trim unneeded whitespace
		$color = str_replace( ' ', '', $color );

		// If this is hex color
		if ( 1 === preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			$r = hexdec( substr( $color, 0, 2 ) );
			$g = hexdec( substr( $color, 2, 2 ) );
			$b = hexdec( substr( $color, 4, 2 ) );
		}
		// If this is rgb color
		if ( 'rgb(' === substr( $color, 0, 4 ) ) {
			list( $r, $g, $b ) = sscanf( $color, 'rgb(%d,%d,%d)' );
		}

		// If this is rgba color
		if ( 'rgba(' === substr( $color, 0, 5 ) ) {
			list( $r, $g, $b, $alpha ) = sscanf( $color, 'rgba(%d,%d,%d,%f)' );
		}

		if ( ! isset( $r, $g, $b ) ) {
			return '';
		}

		$contrast = (
			$r * $r * .299 +
			$g * $g * .587 +
			$b * $b * .114
		);

		if ( $contrast > pow( 130, 2 ) ) {
			//bright color, use dark font
			return '#000';
		} else {
			//dark color, use bright font
			return '#fff';
		}
	}
}

if ( ! function_exists( 'shapla_adjust_color_brightness' ) ) {
	/**
	 * Adjust a hex color brightness
	 * Allows us to create hover styles for custom link colors
	 *
	 * @param  string $hex hex color e.g. #111111.
	 * @param  integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
	 *
	 * @return string        brightened/darkened hex color
	 * @since  1.3.0
	 */
	function shapla_adjust_color_brightness( $hex, $steps ) {
		// Steps should be between -255 and 255. Negative = darker, positive = lighter.
		$steps = max( - 255, min( 255, $steps ) );

		// Format the hex color string.
		$hex = str_replace( '#', '', $hex );

		if ( 3 == strlen( $hex ) ) {
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) .
			       str_repeat( substr( $hex, 1, 1 ), 2 ) .
			       str_repeat( substr( $hex, 2, 1 ), 2 );
		}

		// Get decimal values.
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );

		// Adjust number of steps and keep it inside 0 to 255.
		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );
		$b = max( 0, min( 255, $b + $steps ) );

		$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return '#' . $r_hex . $g_hex . $b_hex;
	}
}


if ( ! function_exists( 'shapla_default_options' ) ) {
	/**
	 * Get theme default options
	 *
	 * @return object
	 * @since  1.3.0
	 */
	function shapla_default_options() {
		$heading_color     = '#323232';
		$text_color        = '#323232';
		$primary_color     = '#2196f3';
		$secondary_color   = '#009688';
		$primary_hover     = shapla_adjust_color_brightness( $primary_color, - 20 );
		$primary_inverse   = shapla_find_color_invert( $primary_color );
		$secondary_hover   = shapla_adjust_color_brightness( $secondary_color, - 20 );
		$secondary_inverse = shapla_find_color_invert( $secondary_color );

		$options = array(
			'heading_color'    => $heading_color,
			'text_color'       => $text_color,
			'primary_color'    => $primary_color,
			'font_family'      => 'Roboto',
			'blog'             => array(
				'layout'             => 'grid',
				'date_format'        => 'human',
				'excerpt_length'     => 20,
				'show_page_title'    => true,
				'show_avatar'        => true,
				'show_author_name'   => true,
				'show_date'          => true,
				'show_category'      => true,
				'show_tag'           => true,
				'show_comments_link' => true,
			),
			'primary_nav'      => array(
				'direction' => 'ltr',
			),
			'primary_button'   => array(
				'background'       => $primary_color,
				'background_hover' => $primary_hover,
				'text'             => $primary_inverse,
				'text_hover'       => $primary_inverse,
				'font_size'        => '1rem',
				'border_radius'    => '3px',
			),
			'secondary_button' => array(
				'background'       => $secondary_color,
				'background_hover' => $secondary_hover,
				'text'             => $secondary_inverse,
				'text_hover'       => $secondary_inverse,
			),
			'header'           => array(
				'logo_font_size'   => '30px',
				'background_color' => '#ffffff',
				'text_color'       => $text_color,
				'link_color'       => $primary_color,
				'show_search_icon' => false,
				'sticky_header'    => false,
			),
			'title_bar'        => array(
				'background_color' => '#f5f5f5',
				'border_color'     => '#cccccc',
				'padding'          => '2rem',
				'font_size'        => '2rem',
				'line_height'      => '1.4',
				'title_font_color' => $heading_color,
				'text_alignment'   => 'left',
				'text_transform'   => 'none',
				'font_weight'      => '300',
			),
			'breadcrumbs'      => array(
				'content_display'   => 'breadcrumb',
				'visible_on_mobile' => 'off',
				'separator'         => 'slash',
				'font_size'         => '0.875rem',
				'font_color'        => $text_color,
				'text_transform'    => 'none',
			),
			'layout'           => array(
				'site_layout'    => 'wide',
				'sidebar_layout' => 'right-sidebar',
				'header_layout'  => 'default',
			),
			'footer'           => array(
				'widget_rows'             => 1,
				'widget_columns'          => 4,
				'widget_background_color' => '#212a34',
				'widget_text_color'       => '#f1f1f1',
				'widget_link_color'       => '#f1f1f1',
				'background_color'        => '#19212a',
				'text_color'              => '#9e9e9e',
				'link_color'              => '#f1f1f1',
				'copyright_text'          => sprintf(
					'<a href="https://wordpress.org/">%1$s</a><span class="sep"> | </span>%2$s %3$s.',
					__( 'Proudly powered by WordPress', 'shapla' ),
					__( 'Theme: Shapla by', 'shapla' ),
					'<a href="https://sayfulislam.com/" rel="designer">Sayful Islam</a>'
				),
			),
			'woocommerce'      => array(
				'products_per_page'      => 16,
				'products_per_row'       => 4,
				'show_cart_icon'         => true,
				'show_search_categories' => true,
				'highlight_color'        => $primary_color,
				'highlight_text_color'   => $primary_inverse,
			),
		);

		$default_options = json_decode( json_encode( $options ), false );

		return apply_filters( 'shapla_default_options', $default_options );
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