<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_Customizer' ) ) {

	class Shapla_Customizer {

		/**
		 * @var Shapla_Customizer
		 */
		private static $instance;

		/**
		 * Customize settings configuration
		 *
		 * @var array
		 */
		private $setting = array(
			'option_type' => 'theme_mod',
			'capability'  => 'edit_theme_options',
		);

		/**
		 * Customize fields
		 *
		 * @var array
		 */
		private $fields = array();

		/**
		 * Customize panels
		 *
		 * @var array
		 */
		private $panels = array();

		/**
		 * Customize sections
		 *
		 * @var array
		 */
		private $sections = array();

		/**
		 * Customize available field types
		 *
		 * @var array
		 */
		private $allowed_field_types = array(
			'text',
			'color',
			'image',
			'textarea',
			'checkbox',
			'select',
			'radio',
			'radio-image',
			'radio-button',
			'alpha-color',
			'background',
			'typography',
			'toggle',
			'range-slider',
		);

		/**
		 * Only one instance of the class can be loaded
		 *
		 * @return self
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				add_action( 'customize_register', array( self::$instance, 'modify_customize_defaults' ) );
				add_action( 'customize_register', array( self::$instance, 'customize_register' ) );
				add_action( 'customize_save_after', array( self::$instance, 'generate_css_file' ) );
			}

			return self::$instance;
		}

		/**
		 * Generate custom css file for live customize values
		 */
		public function generate_css_file() {
			if ( 'direct' !== get_filesystem_method() ) {
				return;
			}

			/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
			$credentials = request_filesystem_credentials( admin_url( 'customize.php' ), '', false, false, array() );

			/* initialize the API */
			if ( ! WP_Filesystem( $credentials ) ) {
				/* any problems and we exit */
				return;
			}

			$suffix           = uniqid();
			$created          = time();
			$upload_dir       = wp_get_upload_dir();
			$basedir          = $upload_dir['basedir'];
			$baseurl          = $upload_dir['baseurl'];
			$theme_upload_dir = $basedir . '/shapla';
			$theme_css_dir    = $theme_upload_dir . '/css';
			$css_file_name    = 'customize-style-' . $suffix . '.css';
			$theme_css_file   = $theme_css_dir . '/' . $css_file_name;

			/** @var \WP_Filesystem_Base $wp_filesystem */
			global $wp_filesystem;

			// Create Theme base directory
			if ( ! $wp_filesystem->is_dir( $theme_upload_dir ) ) {
				$wp_filesystem->mkdir( $theme_upload_dir, 0777 );
			}

			// Create Theme css directory
			if ( ! $wp_filesystem->is_dir( $theme_css_dir ) ) {
				$wp_filesystem->mkdir( $theme_css_dir, 0777 );
			}

			// Remove old files
			array_map( 'unlink', glob( $theme_css_dir . '/customize-style-*.css' ) );

			// Create Theme css file
			if ( ! $wp_filesystem->exists( $theme_css_file ) ) {
				$wp_filesystem->touch( $theme_css_file, $created );
			}

			$google_fonts = $this->get_google_fonts();
			if ( ! empty( $google_fonts ) ) {
				update_option( '_shapla_google_fonts', $google_fonts, true );
			}

			$styles = "/*!\n * Theme Name: Shapla\n * Description: Dynamically generated theme style.\n */\n";
			$styles .= wp_strip_all_tags( $this->get_styles() ) . PHP_EOL;

			// Fetch the saved Custom CSS content for rendering.
			$additional_css = '';
			$post           = wp_get_custom_css_post();
			$css            = ! empty( $post->post_content ) ? wp_strip_all_tags( $post->post_content ) : '';
			if ( ! empty( $css ) ) {
				$additional_css = "\n/* Additional CSS */\n";
				$additional_css .= Shapla_CSS_Generator::minify_css( $css );
			}


			$styles = $styles . $additional_css;
			if ( empty( $styles ) ) {
				delete_option( '_shapla_customize_file' );

				return;
			}

			if ( $wp_filesystem->put_contents( $theme_css_file, $styles ) ) {
				$data = array(
					'name'    => $css_file_name,
					'path'    => $theme_css_file,
					'url'     => join( '/', array( $baseurl, 'shapla', 'css', $css_file_name ) ),
					'created' => $created,
				);
				update_option( '_shapla_customize_file', $data, true );
			} else {
				delete_option( '_shapla_customize_file' );
			}

			// Delete Fonts transient
			delete_transient( 'shapla_google_fonts' );
		}

		/**
		 * Modify WordPress default section and control
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object
		 *
		 * @since  1.0.1
		 */
		public function modify_customize_defaults( $wp_customize ) {
			// Change header image section title & priority.
			$wp_customize->get_section( 'header_image' )->title    = __( 'Header', 'shapla' );
			$wp_customize->get_section( 'header_image' )->priority = 25;
			// Change background image section title & priority.
			$wp_customize->get_section( 'background_image' )->title    = __( 'Background', 'shapla' );
			$wp_customize->get_section( 'background_image' )->priority = 30;
			// Move background color setting alongside background image.
			$wp_customize->get_control( 'background_color' )->section  = 'background_image';
			$wp_customize->get_control( 'background_color' )->priority = 20;
		}


		/**
		 * Gets all our styles and returns them as a string.
		 *
		 * @return string
		 */
		public function get_styles() {

			if ( count( $this->fields ) < 1 ) {
				return '';
			}

			// initially we're going to format our styles as an array.
			// This is going to make processing them a lot easier
			// and make sure there are no duplicate styles etc.
			$css = array();

			// start parsing our fields
			foreach ( $this->fields as $field ) {

				// If no setting id, then exist
				if ( ! isset( $field['settings'] ) ) {
					continue;
				}

				// Get the default value of this field
				$default = isset( $field['default'] ) ? $field['default'] : '';
				$value   = get_theme_mod( $field['settings'], $default );

				Shapla_CSS_Generator::css( $css, $field, $value );
			}

			// Process the array of CSS properties and produce the final CSS
			return Shapla_CSS_Generator::styles_parse( $css );
		}

		/**
		 * Get custom customize controls
		 *
		 * @return array
		 */
		public static function get_custom_controls() {
			return [
				'radio-button' => Shapla_Radio_Button_Customize_Control::class,
				'typography'   => Shapla_Typography_Customize_Control::class,
				'toggle'       => Shapla_Toggle_Customize_Control::class,
				'range-slider' => Shapla_Slider_Customize_Control::class,
				'background'   => Shapla_Background_Customize_Control::class,
				'alpha-color'  => Shapla_Color_Customize_Control::class,
				'radio-image'  => Shapla_Radio_Image_Customize_Control::class,
			];
		}

		/**
		 * Add panel, section and settings
		 *
		 * @param WP_Customize_Manager $wp_customize
		 */
		public function customize_register( $wp_customize ) {
			// Registered Control Types
			foreach ( static::get_custom_controls() as $custom_control ) {
				$wp_customize->register_control_type( $custom_control );
			}

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

					// Add settings and controls
					$wp_customize->add_setting( $field['settings'], array(
						'default'           => $field['default'],
						'type'              => $this->setting['option_type'],
						'capability'        => $this->setting['capability'],
						'transport'         => isset( $field['transport'] ) ? $field['transport'] : 'refresh',
						'sanitize_callback' => static::get_sanitize_callback( $field ),
					) );
					$wp_customize->add_control( $this->add_control( $wp_customize, $field ) );
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

			$controls     = static::get_custom_controls();
			$control_args = static::get_control_arguments( $field );

			if ( isset( $controls[ $type ] ) ) {
				$className = $controls[ $type ];

				return new $className( $wp_customize, $field['settings'], $control_args );
			}

			if ( 'image' == $type ) {
				return new WP_Customize_Image_Control( $wp_customize, $field['settings'], $control_args );
			}

			if ( 'color' == $type ) {
				return new WP_Customize_Color_Control( $wp_customize, $field['settings'], $control_args );
			}

			return new WP_Customize_Control( $wp_customize, $field['settings'], $control_args );
		}

		/**
		 * Get customize control arguments
		 *
		 * @param array $args
		 *
		 * @return array
		 */
		public static function get_control_arguments( array $args ) {
			$valid_args = [
				'label'       => '',
				'description' => '',
				'section'     => '',
				'priority'    => 10,
				'settings'    => '',
				'type'        => 'text',
				'choices'     => [],
				'input_attrs' => [],
			];

			$new_args = [];
			foreach ( $args as $key => $value ) {
				if ( array_key_exists( $key, $valid_args ) ) {
					$new_args[ $key ] = $value;
				}
			}

			return $new_args;
		}

		/**
		 * Get customize sanitize method
		 *
		 * @param array $field
		 *
		 * @return array|string
		 */
		public static function get_sanitize_callback( array $field ) {
			if ( isset( $field['sanitize_callback'] ) && is_callable( $field['sanitize_callback'] ) ) {
				return $field['sanitize_callback'];
			}

			$type = isset( $field['type'] ) ? $field['type'] : 'text';
			$type = str_replace( '-', '_', $type );

			$methods = [
				'typography'  => [ Shapla_Sanitize::class, 'typography' ],
				'background'  => [ Shapla_Sanitize::class, 'background' ],
				'number'      => [ Shapla_Sanitize::class, 'number' ],
				'image'       => [ Shapla_Sanitize::class, 'url' ],
				'url'         => [ Shapla_Sanitize::class, 'url' ],
				'email'       => [ Shapla_Sanitize::class, 'email' ],
				'checkbox'    => [ Shapla_Sanitize::class, 'checked' ],
				'textarea'    => [ Shapla_Sanitize::class, 'html' ],
				'alpha_color' => [ Shapla_Sanitize::class, 'color' ],
				'color'       => [ Shapla_Sanitize::class, 'color' ],
			];

			if ( isset( $methods[ $type ] ) ) {
				return $methods[ $type ];
			}

			return [ Shapla_Sanitize::class, 'text' ];
		}

		/**
		 * Get google fonts from customize settings
		 *
		 * @return array
		 */
		public function get_google_fonts() {
			$google_fonts = array();
			$fonts        = array();

			foreach ( $this->fields as $field ) {
				if ( ! isset( $field['settings'], $field['type'] ) ) {
					continue;
				}

				// Check if we've got everything we need.
				$default = isset( $field['default'] ) ? $field['default'] : array();
				$value   = (array) get_theme_mod( $field['settings'], $default );

				// Process typography fields.
				if ( 'typography' !== $field['type'] ) {
					continue;
				}

				if ( empty( $value['font-family'] ) ) {
					continue;
				}

				if ( ! Shapla_Fonts::is_google_font( $value['font-family'] ) ) {
					continue;
				}

				$fonts[ $value['font-family'] ][] = isset( $value['variant'] ) ? $value['variant'] : '';
			}

			foreach ( $fonts as $font_name => $font_variant ) {
				$variant = is_array( $font_variant ) ? implode( ",", array_unique( $font_variant ) ) : '';
				$variant = str_replace( 'regular', '400', $variant );
				if ( ! empty( $variant ) ) {
					$google_fonts[] = $font_name . ":" . $variant;
				} else {
					$google_fonts[] = $font_name;
				}
			}

			return apply_filters( 'shapla_google_font_families', $google_fonts );
		}
	}
}

return Shapla_Customizer::init();
