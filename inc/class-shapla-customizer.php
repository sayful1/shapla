<?php

use Shapla\Helpers\ShaplaFonts;

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
		 * Customize fields
		 *
		 * @var array
		 */
		private $fields = array();

		/**
		 * Only one instance of the class can be loaded
		 *
		 * @return self
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				add_action( 'customize_register', [ self::$instance, 'modify_customize_defaults' ] );
				add_action( 'customize_register', [ self::$instance, 'register_control_type' ] );
				add_action( 'customize_register', [ self::$instance, 'init_field_settings' ] );
				add_action( 'customize_save_after', [ self::$instance, 'generate_css_file' ] );
				add_action( 'wp_ajax_shapla_regenerate_fonts_folder', [ self::$instance, 'regenerate_fonts_folder' ] );
			}

			return self::$instance;
		}

		/**
		 * Re-generate fonts folder
		 *
		 * @return void
		 */
		public function regenerate_fonts_folder() {
			check_ajax_referer( 'shapla-regenerate-local-fonts', 'nonce' );

			// Check if current can delete theme options.
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_send_json_error( 'invalid_permissions' );
			}

			$flushed = shapla_webfont_loader_instance()->delete_fonts_folder();

			if ( ! $flushed ) {
				wp_send_json_error( 'failed_to_flush' );
			}

			wp_send_json_success();
		}

		/**
		 * Generate custom css file for live customize values
		 */
		public function generate_css_file() {
			if ( 'direct' !== get_filesystem_method() ) {
				return;
			}

			$google_fonts = $this->get_google_fonts();
			if ( ! empty( $google_fonts ) ) {
				update_option( '_shapla_google_fonts', $google_fonts, true );
			}

			$dynamic_style = wp_strip_all_tags( $this->get_styles() );

			$styles = "/*!\n * Theme Name: Shapla\n * Description: Dynamically generated theme style.\n */\n";
			$styles .= $dynamic_style . PHP_EOL;

			// Fetch the saved Custom CSS content for rendering.
			$additional_css = '';
			$post           = wp_get_custom_css_post();
			$css            = ! empty( $post->post_content ) ? wp_strip_all_tags( $post->post_content ) : '';
			if ( ! empty( $css ) ) {
				$additional_css = "\n/* Additional CSS */\n";
				$additional_css .= \Shapla\Helpers\CssGenerator::minify_css( $css );
			}


			$styles = $styles . $additional_css;
			if ( empty( $dynamic_style ) && empty( $additional_css ) ) {
				delete_option( '_shapla_customize_file' );
				// Delete Fonts transient
				delete_transient( 'shapla_google_fonts' );
				delete_transient( 'shapla_fonts_css_variables' );
				shapla_webfont_loader_instance()->delete_fonts_folder();

				return;
			}

			$file_info = \Shapla\Helpers\Filesystem::update_customize_css( $styles );
			if ( is_array( $file_info ) ) {
				update_option( '_shapla_customize_file', $file_info, true );
			} else {
				delete_option( '_shapla_customize_file' );
			}

			// Delete Fonts transient
			delete_transient( 'shapla_google_fonts' );
			delete_transient( 'shapla_fonts_css_variables' );
			shapla_webfont_loader_instance()->delete_fonts_folder();
		}

		/**
		 * Modify WordPress default section and control
		 *
		 * @param  WP_Customize_Manager  $wp_customize  Theme Customizer object
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
				$value   = shapla_get_option( $field['settings'], $default );

				\Shapla\Helpers\CssGenerator::css( $css, $field, $value );
			}

			// Process the array of CSS properties and produce the final CSS
			return \Shapla\Helpers\CssGenerator::styles_parse( $css );
		}

		/**
		 * Get custom customize controls
		 *
		 * @return array
		 */
		public static function get_custom_controls() {
			return array(
				'radio-button' => \Shapla\Customize\Controls\RadioButton::class,
				'typography'   => \Shapla\Customize\Controls\Typography::class,
				'toggle'       => \Shapla\Customize\Controls\Toggle::class,
				'range-slider' => \Shapla\Customize\Controls\Slider::class,
				'background'   => \Shapla\Customize\Controls\Background::class,
				'alpha-color'  => \Shapla\Customize\Controls\ColorAlpha::class,
				'radio-image'  => \Shapla\Customize\Controls\RadioImage::class,
			);
		}

		/**
		 * Registered Control Types
		 *
		 * @param  \WP_Customize_Manager  $wp_customize
		 */
		public function register_control_type( $wp_customize ) {
			foreach ( static::get_custom_controls() as $custom_control ) {
				$wp_customize->register_control_type( $custom_control );
			}
		}

		/**
		 * @param  WP_Customize_Manager  $wp_customize
		 */
		public function init_field_settings( $wp_customize ) {
			\Shapla\Customize\CustomizerConfig::init();

			$panels   = \Shapla\Customize\CustomizerConfig::get_panels();
			$sections = \Shapla\Customize\CustomizerConfig::get_sections();
			$fields   = \Shapla\Customize\CustomizerConfig::get_fields();

			// @todo remove it
			$this->fields = $fields;

			// Add panels
			foreach ( $panels as $panel_id => $panel_args ) {
				$wp_customize->add_panel( $panel_id, $panel_args );
			}

			// Add sections
			foreach ( $sections as $section_id => $section_args ) {
				$wp_customize->add_section( $section_id, $section_args );
			}

			// Add fields
			foreach ( $fields as $field_id => $field ) {
				$wp_customize->add_setting(
					$field_id,
					array(
						'default'           => $field['default'],
						'transport'         => $field['transport'],
						'sanitize_callback' => $field['sanitize_callback'],
					)
				);
				$wp_customize->add_control( $this->add_control( $wp_customize, $field ) );
			}
		}

		/**
		 * Displays a new controller on the Theme Customization admin screen
		 *
		 * @param  WP_Customize_Manager  $wp_customize
		 * @param  array  $field
		 *
		 * @return WP_Customize_Control
		 */
		public function add_control( $wp_customize, $field ) {
			$type         = isset( $field['type'] ) ? $field['type'] : 'text';
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
				return new \Shapla\Customize\Controls\ColorAlpha( $wp_customize, $field['settings'], $control_args );
			}

			return new WP_Customize_Control( $wp_customize, $field['settings'], $control_args );
		}

		/**
		 * Get customize control arguments
		 *
		 * @param  array  $args
		 *
		 * @return array
		 */
		public static function get_control_arguments( array $args ) {
			$valid_args = array(
				'label'       => '',
				'description' => '',
				'section'     => '',
				'priority'    => 10,
				'settings'    => '',
				'type'        => 'text',
				'choices'     => array(),
				'input_attrs' => array(),
			);

			$new_args = array();
			foreach ( $args as $key => $value ) {
				if ( array_key_exists( $key, $valid_args ) ) {
					$new_args[ $key ] = $value;
				}
			}

			return $new_args;
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
				$value   = (array) shapla_get_option( $field['settings'], $default );

				// Process typography fields.
				if ( 'typography' !== $field['type'] ) {
					continue;
				}

				if ( empty( $value['font-family'] ) ) {
					continue;
				}

				if ( ! ShaplaFonts::is_google_font( $value['font-family'] ) ) {
					continue;
				}

				$fonts[ $value['font-family'] ][] = isset( $value['variant'] ) ? $value['variant'] : '';
			}

			foreach ( $fonts as $font_name => $font_variant ) {
				$variant = is_array( $font_variant ) ? implode( ',', array_unique( $font_variant ) ) : '';
				$variant = str_replace( 'regular', '400', $variant );
				if ( ! empty( $variant ) ) {
					$google_fonts[] = $font_name . ':' . $variant;
				} else {
					$google_fonts[] = $font_name;
				}
			}

			return apply_filters( 'shapla_google_font_families', $google_fonts );
		}
	}
}

return Shapla_Customizer::init();
