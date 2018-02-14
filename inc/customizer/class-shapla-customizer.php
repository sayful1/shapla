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
			add_action( 'customize_save_after', array( $this, 'generate_css_file' ) );

			add_filter( 'wp_get_custom_css', array( $this, 'wp_get_custom_css' ) );
			add_action( 'wp_head', array( $this, 'customize_css' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'customize_scripts' ), 90 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fonts' ), 5 );
		}

		/**
		 * Filters the Custom CSS Output into the <head>.
		 *
		 * @param $css
		 *
		 * @return string
		 */
		public function wp_get_custom_css( $css ) {
			if ( ( false !== get_option( '_shapla_customize_file' ) ) && ! is_customize_preview() ) {
				return '';
			}

			return $css;
		}

		/**
		 * Generate inline style for theme customizer
		 */
		public function customize_css() {
			if ( ( false !== get_option( '_shapla_customize_file' ) ) && ! is_customize_preview() ) {
				return;
			}

			$styles = $this->get_styles();
			if ( empty( $styles ) ) {
				return;
			}

			?>
            <style type="text/css" id="shapla-custom-css">
                <?php echo wp_strip_all_tags( $styles ); ?>
            </style>
			<?php
		}

		/**
		 * Load customize css file if available
		 */
		public function customize_scripts() {
			$customize_file = get_option( '_shapla_customize_file' );

			if ( isset( $customize_file['url'] ) && ! is_customize_preview() ) {
				wp_enqueue_style(
					'shapla-customize',
					$customize_file['url'],
					array(),
					$customize_file['created'],
					'all'
				);
			}
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
			$theme_css_file   = $theme_css_dir . DIRECTORY_SEPARATOR . $css_file_name;

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

			$styles = "/*!\n * Theme Name: Shapla\n * Description: Dynamically generated theme style.\n */\n";
			$styles .= wp_strip_all_tags( $this->get_styles() ) . PHP_EOL;

			// Fetch the saved Custom CSS content for rendering.
			$additional_css = '';
			$post           = wp_get_custom_css_post();
			$css            = ! empty( $post->post_content ) ? wp_strip_all_tags( $post->post_content ) : '';
			if ( ! empty( $css ) ) {
				$additional_css = "\n/* Additional CSS */\n";
				$additional_css .= $this->minify_css( $css );
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
					'url'     => join( DIRECTORY_SEPARATOR, array( $baseurl, 'shapla', 'css', $css_file_name ) ),
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
		 * @param  WP_Customize_Manager $wp_customize Theme Customizer object
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

				// If no setting id, then exist
				if ( ! isset( $field['settings'] ) ) {
					continue;
				}

				// Field Type
				$type = isset( $field['type'] ) ? esc_attr( $field['type'] ) : 'text';

				// Get the default value of this field
				$default = isset( $field['default'] ) ? $field['default'] : '';
				$value   = get_theme_mod( $field['settings'], $default );

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
						'choice'        => '',
						'brightness'    => 0,
						'invert'        => false,
					);
					$output   = wp_parse_args( $output, $defaults );

					// If element is an array, convert it to a string
					if ( is_array( $output['element'] ) ) {
						$output['element'] = array_unique( $output['element'] );
						sort( $output['element'] );
						$output['element'] = implode( ',', $output['element'] );
					}

					// If field type typography and value is array
					if ( is_array( $value ) && 'typography' == $type ) {
						$typography_list = array();
						foreach ( $value as $property => $property_value ) {
							// Early exit if the value is not saved in the values.
							if ( ! in_array( $property, $this->get_valid_typography_properties() ) ) {
								continue;
							}

							if ( 'font-family' == $property ) {
								$font_category = null;
								if ( Shapla_Fonts::is_google_font( $property_value ) ) {
									$font_category = Shapla_Fonts::get_google_font_category( $property_value );
								}
								if ( false !== strpos( $property_value, ' ' ) && false === strpos( $property_value, '"' ) ) {
									if ( false !== strpos( $property_value, ',' ) ) {
										$property_value = htmlspecialchars_decode( $property_value );
									} else {
										$property_value = '"' . $property_value . '"' . $font_category;
									}
								} else {
									$property_value = $property_value . $font_category;
								}
							}

							if ( ! empty( $property_value ) ) {
								$typography_list[ $property ] = $property_value;
							}
						}
						$value = $typography_list;
					}


					// If value is array and field is not typography
					if ( is_array( $value ) ) {
						foreach ( $value as $property => $property_value ) {
							if ( $property_value ) {
								$css[ $output['media_query'] ][ $output['element'] ][ $property ] = $property_value;
							}
						}
					}

					// if value is not array
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
				$final_css .= ( 'global' != $media_query ) ? $media_query . '{' . PHP_EOL : '';
				foreach ( $styles as $style => $style_array ) {
					$final_css .= $style . '{';
					foreach ( $style_array as $property => $value ) {
						$value = (string) $value;
						// Make sure background-images are properly formatted
						if ( 'background-image' == $property ) {
							if ( false === strrpos( $value, 'url(' ) ) {
								$value = 'url("' . esc_url_raw( $value ) . '")';
							}
						}

						$final_css .= $property . ':' . $value . ';';
					}
					$final_css .= '}' . PHP_EOL;
				}
				$final_css .= ( 'global' != $media_query ) ? '}' : '';
			}

			return $final_css;
		}

		/**
		 * Enqueue google fonts.
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_fonts() {
			// Check if we need to exit early.
			if ( empty( $this->fields ) || ! is_array( $this->fields ) ) {
				return;
			}

			if ( false === ( $google_fonts = get_transient( 'shapla_google_fonts' ) ) ) {

				$fonts = array();

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

				$google_fonts = apply_filters( 'shapla_google_font_families', $google_fonts );
				set_transient( 'shapla_google_fonts', $google_fonts, DAY_IN_SECONDS );
			}

			if ( count( $google_fonts ) < 1 ) {
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
		 * Add panel, section and settings
		 *
		 * @param WP_Customize_Manager $wp_customize
		 */
		public function customize_register( $wp_customize ) {
			/**
			 * Include theme custom customize controls
			 */
			require 'controls/class-shapla-customize-control.php';
			require 'controls/class-shapla-slider-customize-control.php';
			require 'controls/class-shapla-background-customize-control.php';
			require 'controls/class-shapla-toggle-customize-control.php';
			require 'controls/class-shapla-color-customize-control.php';
			require 'controls/class-shapla-radio-image-customize-control.php';
			require 'controls/class-shapla-radio-button-customize-control.php';
			require 'controls/class-shapla-typography-customize-control.php';

			// Registered Control Types
			$wp_customize->register_control_type( 'Shapla_Slider_Customize_Control' );
			$wp_customize->register_control_type( 'Shapla_Background_Customize_Control' );
			$wp_customize->register_control_type( 'Shapla_Toggle_Customize_Control' );
			$wp_customize->register_control_type( 'Shapla_Color_Customize_Control' );
			$wp_customize->register_control_type( 'Shapla_Radio_Image_Customize_Control' );
			$wp_customize->register_control_type( 'Shapla_Radio_Button_Customize_Control' );
			$wp_customize->register_control_type( 'Shapla_Typography_Customize_Control' );

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

					if ( isset( $field['sanitize_callback'] ) && is_callable( $field['sanitize_callback'] ) ) {
						$sanitize_callback = $field['sanitize_callback'];
					} else {
						$sanitize_method = str_replace( '-', '_', $field['type'] );
						if ( method_exists( $this, "sanitize_{$sanitize_method}" ) ) {
							$sanitize_callback = array( $this, "sanitize_{$sanitize_method}" );
						} else {
							$sanitize_callback = array( $this, 'sanitize_text' );
						}
					}

					// Add settings and controls
					$wp_customize->add_setting( $field['settings'], array(
						'default'           => $field['default'],
						'type'              => $this->setting['option_type'],
						'capability'        => $this->setting['capability'],
						'transport'         => isset( $field['transport'] ) ? $field['transport'] : 'refresh',
						'sanitize_callback' => $sanitize_callback,
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
		 * Add typography field
		 *
		 * @param WP_Customize_Manager $wp_customize
		 * @param array $field
		 *
		 * @return Shapla_Typography_Customize_Control
		 */
		public function typography( $wp_customize, $field ) {
			return new Shapla_Typography_Customize_Control( $wp_customize, $field['settings'], array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $field['section'],
				'priority'    => isset( $field['priority'] ) ? $field['priority'] : 10,
				'settings'    => $field['settings'],
				'choices'     => isset( $field['choices'] ) ? $field['choices'] : array(),
			) );
		}

		/**
		 * Add a complete background control
		 *
		 * @param $wp_customize
		 * @param $field
		 *
		 * @return Shapla_Background_Customize_Control
		 */
		public function background( $wp_customize, $field ) {
			return new Shapla_Background_Customize_Control( $wp_customize, $field['settings'], array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $field['section'],
				'priority'    => isset( $field['priority'] ) ? $field['priority'] : 10,
				'settings'    => $field['settings'],
			) );
		}

		/**
		 * Add a simple toggle input replacing checkbox
		 *
		 * @param $wp_customize
		 * @param $field
		 *
		 * @return Shapla_Toggle_Customize_Control
		 */
		public function toggle( $wp_customize, $field ) {
			return new Shapla_Toggle_Customize_Control( $wp_customize, $field['settings'], array(
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
		 * add a simple, color input.
		 *
		 * @param  WP_Customize_Manager $wp_customize
		 * @param  array $field
		 *
		 * @return Shapla_Color_Customize_Control
		 */
		public function alpha_color( $wp_customize, $field ) {
			return new Shapla_Color_Customize_Control( $wp_customize, $field['settings'], array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $field['section'],
				'priority'    => isset( $field['priority'] ) ? $field['priority'] : 10,
				'settings'    => $field['settings'],
			) );
		}

		/**
		 * Add slider field
		 *
		 * @param WP_Customize_Manager $wp_customize
		 * @param array $field
		 *
		 * @return Shapla_Slider_Customize_Control
		 */
		public function range_slider( $wp_customize, $field ) {
			return new Shapla_Slider_Customize_Control( $wp_customize, $field['settings'], array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $field['section'],
				'priority'    => isset( $field['priority'] ) ? $field['priority'] : 10,
				'input_attrs' => isset( $field['input_attrs'] ) ? $field['input_attrs'] : array(),
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
		 * add radio buttons
		 *
		 * @param  WP_Customize_Manager $wp_customize
		 * @param  array $field
		 *
		 * @return Shapla_Radio_Button_Customize_Control
		 */
		public function radio_button( $wp_customize, $field ) {
			return new Shapla_Radio_Button_Customize_Control( $wp_customize, $field['settings'], array(
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
		 * @param  mixed $value
		 *
		 * @return array
		 */
		public function sanitize_background( $value ) {
			return Shapla_Sanitize::background( $value );
		}

		/**
		 * Sanitize text
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_text( $input ) {
			return Shapla_Sanitize::text( $input );
		}

		/**
		 * Sanitizes a Hex, RGB or RGBA color
		 *
		 * @param  string $color
		 *
		 * @return string
		 */
		public function sanitize_alpha_color( $color ) {
			return $this->sanitize_color( $color );
		}

		/**
		 * Sanitizes a Hex, RGB or RGBA color
		 *
		 * @param  string $color
		 *
		 * @return string
		 */
		public function sanitize_color( $color ) {
			return Shapla_Sanitize::color( $color );
		}

		/**
		 * Sanitize textarea
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_textarea( $input ) {
			return Shapla_Sanitize::html( $input );
		}

		/**
		 * Sanitize checkbox
		 *
		 * @param  boolean $input
		 *
		 * @return boolean
		 */
		public function sanitize_checkbox( $input ) {
			return Shapla_Sanitize::checked( $input );
		}

		/**
		 * Sanitize email
		 *
		 * @param  string $input
		 *
		 * @return string
		 */
		public function sanitize_email( $input ) {
			return Shapla_Sanitize::email( $input );
		}

		/**
		 * Sanitize url
		 *
		 * @param  string $input
		 *
		 * @return string
		 */
		public function sanitize_url( $input ) {
			return Shapla_Sanitize::url( $input );
		}

		/**
		 * Sanitize image
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_image( $input ) {
			return Shapla_Sanitize::url( $input );
		}

		/**
		 * Sanitize number
		 *
		 * @param  boolean $input
		 *
		 * @return string
		 */
		public function sanitize_number( $input ) {
			return Shapla_Sanitize::number( $input );
		}

		/**
		 * Sanitize typography field
		 *
		 * @param $input
		 *
		 * @return array
		 */
		public function sanitize_typography( $input ) {
			return Shapla_Sanitize::typography( $input );
		}

		/**
		 * Minify CSS
		 *
		 * @param string $content
		 * @param bool $newline
		 *
		 * @return string
		 */
		private function minify_css( $content = '', $newline = true ) {
			// Strip comments
			$content = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content );
			// remove leading & trailing whitespace
			$content = preg_replace( '/^\s*/m', '', $content );
			$content = preg_replace( '/\s*$/m', '', $content );

			// replace newlines with a single space
			$content = preg_replace( '/\s+/', ' ', $content );

			// remove whitespace around meta characters
			// inspired by stackoverflow.com/questions/15195750/minify-compress-css-with-regex
			$content = preg_replace( '/\s*([\*$~^|]?+=|[{};,>~]|!important\b)\s*/', '$1', $content );
			$content = preg_replace( '/([\[(:])\s+/', '$1', $content );
			$content = preg_replace( '/\s+([\]\)])/', '$1', $content );
			$content = preg_replace( '/\s+(:)(?![^\}]*\{)/', '$1', $content );

			// whitespace around + and - can only be stripped inside some pseudo-
			// classes, like `:nth-child(3+2n)`
			// not in things like `calc(3px + 2px)`, shorthands like `3px -2px`, or
			// selectors like `div.weird- p`
			$pseudos = array( 'nth-child', 'nth-last-child', 'nth-last-of-type', 'nth-of-type' );
			$content = preg_replace( '/:(' . implode( '|', $pseudos ) . ')\(\s*([+-]?)\s*(.+?)\s*([+-]?)\s*(.*?)\s*\)/',
				':$1($2$3$4$5)', $content );

			// remove semicolon/whitespace followed by closing bracket
			$content = str_replace( ';}', '}', $content );

			// Add new line after closing bracket
			if ( $newline ) {
				$content = str_replace( '}', '}' . PHP_EOL, $content );
			}

			return trim( $content );
		}

		/**
		 * @return array
		 */
		private function get_valid_typography_properties() {
			$valid_properties = array(
				'font-family',
				'font-weight',
				'font-size',
				'line-height',
				'letter-spacing',
				'color',
				'text-transform',
				'text-align',
				'font-style',
			);

			return $valid_properties;
		}
	}
}

return Shapla_Customizer::init();
