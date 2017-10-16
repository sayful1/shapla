<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_Customizer' ) ) {

	class Shapla_Customizer {

		private static $instance;
		private $setting = array();
		private $fields = array();
		private $panels = array();
		private $sections = array();
		private $allowed_field_types = array(
			'text',
			'color',
			'image',
			'textarea',
			'checkbox',
			'select',
			'radio',
			'radio-image',
		);

		/**
		 * @return Shapla_Customizer
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Shapla_Customizer constructor.
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'modify_customize_defaults' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ) );
			add_action( 'wp_head', array( $this, 'customize_css' ) );
		}

		/**
		 * Modify WordPress default section and control
		 *
		 * @param  WP_Customize_Manager $wp_customize Theme Customizer object
		 *
		 * @since  1.0.1
		 */
		public function modify_customize_defaults( $wp_customize ) {
			// Move background color setting alongside background image.
			$wp_customize->get_control( 'background_color' )->section  = 'background_image';
			$wp_customize->get_control( 'background_color' )->priority = 20;
			// Change background image section title & priority.
			$wp_customize->get_section( 'background_image' )->title    = __( 'Background', 'shapla' );
			$wp_customize->get_section( 'background_image' )->priority = 30;
			// Change header image section title & priority.
			$wp_customize->get_section( 'header_image' )->title    = __( 'Header', 'shapla' );
			$wp_customize->get_section( 'header_image' )->priority = 25;
		}

		/**
		 * Generate inline style for theme customizer
		 */
		public function customize_css() {
			$styles = $this->get_styles();

			if ( $styles ) {
				printf(
					'<style type="text/css" id="shapla-inline-style">%s</style>',
					wp_strip_all_tags( $styles )
				);
			}
		}


		/**
		 * Gets all our styles and returns them as a string.
		 *
		 * @return string
		 */
		public function get_styles() {
			// Get an array of all our fields
			$fields = $this->fields;
			// Check if we need to exit early
			if ( empty( $fields ) || ! is_array( $fields ) ) {
				return '';
			}
			// initially we're going to format our styles as an array.
			// This is going to make processing them a lot easier
			// and make sure there are no duplicate styles etc.
			$css = array();
			// start parsing our fields
			foreach ( $fields as $field ) {
				// No need to process fields without an output, or an improperly-formatted output
				if ( ! isset( $field['output'] ) || empty( $field['output'] ) || ! is_array( $field['output'] ) ) {
					continue;
				}
				// Get the default value of this field
				$value = get_theme_mod( $field['settings'], $field['default'] );
				// start parsing the output arguments of the field
				foreach ( $field['output'] as $output ) {
					$defaults = array(
						'element'       => '',
						'property'      => '',
						'media_query'   => 'global',
						'prefix'        => '',
						'units'         => '',
						'suffix'        => '',
						'value_pattern' => '$',
					);
					$output   = wp_parse_args( $output, $defaults );
					// If element is an array, convert it to a string
					if ( is_array( $output['element'] ) ) {
						$output['element'] = array_unique( $output['element'] );
						sort( $output['element'] );
						$output['element'] = implode( ',', $output['element'] );
					}
					// Simple fields
					if ( ! is_array( $value ) ) {
						$value = str_replace( '$', $value, $output['value_pattern'] );
						if ( ! empty( $output['element'] ) && ! empty( $output['property'] ) ) {
							$css[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $value . $output['units'] . $output['suffix'];
						}
					}
				}
			}
			// Process the array of CSS properties and produce the final CSS
			$final_css = '';
			if ( ! is_array( $css ) || empty( $css ) ) {
				return '';
			}
			// Parse the generated CSS array and create the CSS string for the output.
			foreach ( $css as $media_query => $styles ) {
				// Handle the media queries
				$final_css .= ( 'global' != $media_query ) ? $media_query . '{' : '';
				foreach ( $styles as $style => $style_array ) {
					$final_css .= $style . '{';
					foreach ( $style_array as $property => $value ) {
						$value = ( is_string( $value ) ) ? $value : '';
						// Make sure background-images are properly formatted
						if ( 'background-image' == $property ) {
							if ( false === strrpos( $value, 'url(' ) ) {
								$value = 'url("' . esc_url_raw( $value ) . '")';
							}
						} else {
							$value = esc_textarea( $value );
						}
						$final_css .= $property . ':' . $value . ';';
					}
					$final_css .= '}';
				}
				$final_css .= ( 'global' != $media_query ) ? '}' : '';
			}

			return $final_css;
		}

		/**
		 * Add panel, section and settings
		 *
		 * @param WP_Customize_Manager $wp_customize
		 */
		public function customize_register( $wp_customize ) {
			// Add panel to customizer
			if ( count( $this->panels ) > 0 ) {
				foreach ( $this->panels as $panel ) {
					$wp_customize->add_panel( $panel['id'], array(
						'priority'    => isset( $panel['priority'] ) ? $panel['priority'] : 30,
						'capability'  => $this->setting['capability'],
						'title'       => $panel['title'],
						'description' => isset( $panel['description'] ) ? $panel['description'] : '',
					) );
				}
			}

			// Add section to customizer
			if ( count( $this->sections ) > 0 ) {
				foreach ( $this->sections as $section ) {
					$wp_customize->add_section( $section['id'], array(
						'title'       => $section['title'],
						'panel'       => isset( $section['panel'] ) ? $section['panel'] : '',
						'priority'    => isset( $section['priority'] ) ? $section['priority'] : 30,
						'description' => isset( $section['description'] ) ? $section['description'] : '',
					) );
				}
			}

			// Add field to customizer
			if ( count( $this->fields ) > 0 ) {
				foreach ( $this->fields as $field ) {
					$sanitize_callback = str_replace( '-', '_', $field['type'] );
					// Add settings and controls
					$wp_customize->add_setting( $field['settings'], array(
						'default'           => $field['default'],
						'type'              => $this->setting['option_type'],
						'capability'        => $this->setting['capability'],
						'transport'         => isset( $field['transport'] ) ? $field['transport'] : 'refresh',
						'sanitize_callback' => array( $this, "sanitize_{$sanitize_callback}" ),
					) );
					$wp_customize->add_control(
						$this->add_control( $wp_customize, $field )
					);
				}
			}
		}

		/**
		 * Set settings configuration
		 *
		 * @param array $params
		 */
		public function add_config( array $params ) {
			$this->setting = array(
				'option_type' => isset( $params['option_type'] ) ? $params['option_type'] : 'theme_mod',
				'capability'  => isset( $params['capability'] ) ? $params['capability'] : 'edit_theme_options',
			);
		}

		/**
		 * Add settings panel
		 *
		 * @param string $id
		 * @param array $args
		 *
		 * @throws Exception
		 */
		public function add_panel( $id, array $args ) {
			if ( ! isset( $id, $args['title'] ) ) {
				throw new Exception( __( 'Required key is not set properly for adding panel.', 'shapla' ) );
			}

			$this->panels[] = array_merge( array( 'id' => $id ), $args );
		}

		/**
		 * Add settings section
		 *
		 * @param string $id
		 * @param array $args
		 *
		 * @throws Exception
		 */
		public function add_section( $id, array $args ) {
			if ( ! isset( $id, $args['title'] ) ) {
				throw new Exception( __( 'Required key is not set properly for adding section.', 'shapla' ) );
			}

			$this->sections[] = array_merge( array( 'id' => $id ), $args );
		}

		/**
		 * Add settings field
		 *
		 * @param array $args
		 *
		 * @throws Exception
		 */
		public function add_field( array $args ) {
			if ( ! isset( $args['settings'], $args['default'], $args['label'] ) ) {
				throw new Exception( __( 'Required key is not set properly for adding field.', 'shapla' ) );
			}

			$this->fields[] = $args;
		}

		/**
		 * Displays a new controller on the Theme Customization admin screen
		 *
		 * @param WP_Customize_Manager $wp_customize
		 * @param array $field
		 *
		 * @return WP_Customize_Control
		 */
		public function add_control( $wp_customize, $field ) {
			$type = isset( $field['type'] ) ? $field['type'] : 'text';

			if ( ! in_array( $type, $this->allowed_field_types ) ) {
				$type = 'text';
			}

			$type = str_replace( '-', '_', $type );

			if ( method_exists( $this, $type ) ) {
				return $this->$type( $wp_customize, $field );
			} else {
				return $this->text( $wp_customize, $field );
			}
		}

		/**
		 * add a simple, image uploader.
		 *
		 * @param  WP_Customize_Manager $wp_customize
		 * @param  array $field
		 *
		 * @return WP_Customize_Image_Control
		 */
		public function image( $wp_customize, $field ) {
			return new WP_Customize_Image_Control( $wp_customize, $field['settings'], array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $field['section'],
				'priority'    => isset( $field['priority'] ) ? $field['priority'] : 10,
				'settings'    => $field['settings'],
			) );
		}

		/**
		 * add a simple, color input.
		 *
		 * @param  WP_Customize_Manager $wp_customize
		 * @param  array $field
		 *
		 * @return WP_Customize_Color_Control
		 */
		public function color( $wp_customize, $field ) {
			return new WP_Customize_Color_Control( $wp_customize, $field['settings'], array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $field['section'],
				'priority'    => isset( $field['priority'] ) ? $field['priority'] : 10,
				'settings'    => $field['settings'],
			) );
		}

		/**
		 * add a simple, single-line text input.
		 *
		 * @param  WP_Customize_Manager $wp_customize
		 * @param  array $field
		 *
		 * @return WP_Customize_Control
		 */
		public function text( $wp_customize, $field ) {
			return new WP_Customize_Control( $wp_customize, $field['settings'], array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $field['section'],
				'priority'    => isset( $field['priority'] ) ? $field['priority'] : 10,
				'choices'     => isset( $field['choices'] ) ? $field['choices'] : array(),
				'type'        => $field['type'],
				'settings'    => $field['settings'],
			) );
		}

		/**
		 * add radio images
		 *
		 * @param  WP_Customize_Manager $wp_customize
		 * @param  array $field
		 *
		 * @return Shapla_Radio_Image_Customize_Control
		 */
		public function radio_image( $wp_customize, $field ) {
			if ( ! class_exists( 'Shapla_Radio_Image_Customize_Control' ) ) {
				require_once 'controls/class-shapla-radio-image-customize-control.php';
			}

			return new Shapla_Radio_Image_Customize_Control( $wp_customize, $field['settings'], array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $field['section'],
				'priority'    => isset( $field['priority'] ) ? $field['priority'] : 10,
				'choices'     => isset( $field['choices'] ) ? $field['choices'] : array(),
				'settings'    => $field['settings'],
			) );
		}

		/**
		 * Sanitize image
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_image( $input ) {
			return esc_url_raw( $input );
		}

		/**
		 * Sanitize text
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_text( $input ) {
			return sanitize_text_field( $input );
		}

		/**
		 * Sanitizes a Hex, RGB or RGBA color
		 *
		 * @param  string $color
		 *
		 * @return string
		 */
		public function sanitize_color( $color ) {
			if ( '' === $color ) {
				return '';
			}

			// Trim unneeded whitespace
			$color = str_replace( ' ', '', $color );

			// If this is hex color, validate and return it
			if ( 1 === preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
				return $color;
			}

			// If this is rgb, validate and return it
			if ( 'rgb(' === substr( $color, 0, 4 ) ) {
				list( $red, $green, $blue ) = sscanf( $color, 'rgb(%d,%d,%d)' );

				if ( ( $red >= 0 && $red <= 255 ) &&
				     ( $green >= 0 && $green <= 255 ) &&
				     ( $blue >= 0 && $blue <= 255 )
				) {
					return "rgb({$red},{$green},{$blue})";
				}
			}

			// If this is rgba, validate and return it
			if ( 'rgba(' === substr( $color, 0, 5 ) ) {
				list( $red, $green, $blue, $alpha ) = sscanf( $color, 'rgba(%d,%d,%d,%f)' );

				if ( ( $red >= 0 && $red <= 255 ) &&
				     ( $green >= 0 && $green <= 255 ) &&
				     ( $blue >= 0 && $blue <= 255 ) &&
				     $alpha >= 0 && $alpha <= 1
				) {
					return "rgba({$red},{$green},{$blue},{$alpha})";
				}
			}

			return '';
		}

		/**
		 * Sanitize textarea
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_textarea( $input ) {
			return wp_filter_post_kses( $input );
		}

		/**
		 * Sanitize checkbox
		 *
		 * @param  boolean $input
		 *
		 * @return boolean
		 */
		public function sanitize_checkbox( $input ) {
			return ( $input == true ) ? true : false;
		}

		/**
		 * Sanitize email
		 *
		 * @param  string $input
		 *
		 * @return string
		 */
		public function sanitize_email( $input ) {
			return sanitize_email( $input );
		}

		/**
		 * Sanitize url
		 *
		 * @param  string $input
		 *
		 * @return string
		 */
		public function sanitize_url( $input ) {
			return esc_url_raw( $input );
		}

		/**
		 * Sanitize a value from a list of allowed values.
		 *
		 * @param  string $input
		 *
		 * @return string
		 */
		public function sanitize_select( $input ) {
			return sanitize_text_field( $input );
		}

		/**
		 * Sanitize radio
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_radio( $input ) {
			return sanitize_text_field( $input );
		}

		/**
		 * Sanitize radio
		 *
		 * @param $input
		 *
		 * @return string
		 */
		public function sanitize_radio_image( $input ) {
			return sanitize_text_field( $input );
		}

		/**
		 * Sanitize number
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_number( $input ) {
			return intval( $input );
		}
	}
}

return Shapla_Customizer::init();
