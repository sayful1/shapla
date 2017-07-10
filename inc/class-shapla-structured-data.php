<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('Shapla_Structured_Data') ):

/**
 * Structured data's handler and generator using JSON-LD format.
 *
 * @class   Shapla_Structured_Data
 * @since   1.0.1
 * @author  Sayful Islam <sayful.islam001@gmail.com>
 */

class Shapla_Structured_Data {

	private $structured_data;

	public function __construct()
	{
		add_action( 'shapla_loop_post', array( $this, 'init_structured_data' ), 40 );
		add_action( 'shapla_single_post', array( $this, 'init_structured_data' ), 40 );
		add_action( 'shapla_page', array( $this, 'init_structured_data' ), 40 );

		add_action( 'wp_footer', array( $this, 'get_structured_data' ) );
	}

	/**
	 * Generates structured data.
	 *
	 * Hooked into the following action hooks:
	 *
	 * - `shapla_loop_post`
	 * - `shapla_single_post`
	 * - `shapla_page`
	 *
	 * Applies `shapla_structured_data` filter hook for structured data customization :)
	 */
	public function init_structured_data() {

		// Post's structured data.
		if ( is_home() || is_category() || is_date() || is_search() || is_single() && ( shapla_is_woocommerce_activated() && ! is_woocommerce() ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'normal' );
			$logo  = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

			$json['@type']            = 'BlogPosting';

			$json['mainEntityOfPage'] = array(
				'@type'                 => 'webpage',
				'@id'                   => get_the_permalink(),
			);

			if ( $logo ) {
				$json['publisher']        = array(
					'@type'                 => 'organization',
					'name'                  => get_bloginfo( 'name' ),
					'logo'                  => array(
						'@type'               => 'ImageObject',
						'url'                 => $logo[0],
						'width'               => $logo[1],
						'height'              => $logo[2],
					),
				);
			}

			$json['author']           = array(
				'@type'                 => 'person',
				'name'                  => get_the_author(),
			);

			if ( $image ) {
				$json['image']            = array(
					'@type'                 => 'ImageObject',
					'url'                   => $image[0],
					'width'                 => $image[1],
					'height'                => $image[2],
				);
			}

			$json['datePublished']    = get_post_time( 'c' );
			$json['dateModified']     = get_the_modified_date( 'c' );
			$json['name']             = get_the_title();
			$json['headline']         = $json['name'];
			$json['description']      = get_the_excerpt();

		// Page's structured data.
		} elseif ( is_page() ) {
			$json['@type']            = 'WebPage';
			$json['url']              = get_the_permalink();
			$json['name']             = get_the_title();
			$json['description']      = get_the_excerpt();
		}

		if ( isset( $json ) ) {
			$this->set_structured_data( apply_filters( 'shapla_structured_data', $json ) );
		}
	}

	/**
	 * Sets `$this->structured_data`.
	 *
	 * @param array $json
	 */
	public function set_structured_data( $json ) {
		if ( ! is_array( $json ) ) {
			return;
		}

		$this->structured_data[] = $json;
	}

	/**
	 * Outputs structured data.
	 *
	 * Hooked into `wp_footer` action hook.
	 */
	public function get_structured_data() {
		if ( ! $this->structured_data ) {
			return;
		}

		$structured_data['@context'] = 'http://schema.org/';

		if ( count( $this->structured_data ) > 1 ) {
			$structured_data['@graph'] = $this->structured_data;
		} else {
			$structured_data = $structured_data + $this->structured_data[0];
		}

		echo '<script type="application/ld+json">' . wp_json_encode( $this->sanitize_structured_data( $structured_data ) ) . '</script>';
	}

	/**
	 * Sanitizes structured data.
	 *
	 * @param  array $data
	 * @return array
	 */
	public function sanitize_structured_data( $data ) {
		$sanitized = array();

		foreach ( $data as $key => $value ) {
			if ( is_array( $value ) ) {
				$sanitized_value = $this->sanitize_structured_data( $value );
			} else {
				$sanitized_value = sanitize_text_field( $value );
			}

			$sanitized[ sanitize_text_field( $key ) ] = $sanitized_value;
		}

		return $sanitized;
	}

}

new Shapla_Structured_Data();

endif;