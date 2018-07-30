<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Shapla_Metabox' ) ) {
	/**
	 * Class Shapla_Metabox
	 */
	class Shapla_Metabox {

		/**
		 * @var self
		 */
		protected static $instance;

		/**
		 * Metabox config
		 * @var array
		 */
		protected $config = array();

		/**
		 * Metabox panels
		 * @var array
		 */
		protected $panels = array();

		/**
		 * Metabox sections
		 * @var array
		 */
		protected $sections = array();

		/**
		 * Metabox fields
		 * @var array
		 */
		protected $fields = array();

		/**
		 * Metabox field name
		 * @var string
		 */
		protected $option_name = '_shapla_page_options';

		/**
		 * @return Shapla_Metabox
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				add_action( 'admin_enqueue_scripts', array( self::$instance, 'meta_box_style' ) );
				add_action( 'admin_print_footer_scripts', array( self::$instance, 'meta_box_script' ), 90 );
			}

			return self::$instance;
		}

		/**
		 * Shapla_Metabox constructor.
		 */
		public function __construct() {
			add_action( 'save_post', array( $this, 'save_meta_box' ), 10, 3 );
			add_action( 'wp_head', array( $this, 'metabox_css' ), 30 );
		}

		/**
		 * Generate inline style for theme customizer
		 */
		public function metabox_css() {
			if ( ! is_singular() ) {
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
		 * Gets all our styles for current page and returns them as a string.
		 *
		 * @return string
		 */
		public function get_styles() {
			global $post;
			$fields = $this->getFields();

			// Check if we need to exit early
			if ( empty( $fields ) || ! is_array( $fields ) ) {
				return '';
			}

			// initially we're going to format our styles as an array.
			// This is going to make processing them a lot easier
			// and make sure there are no duplicate styles etc.
			$css    = array();
			$values = get_post_meta( $post->ID, $this->option_name, true );

			// start parsing our fields
			foreach ( $fields as $field ) {

				// No need to process fields without an output, or an improperly-formatted output
				if ( ! isset( $field['output'] ) || empty( $field['output'] ) || ! is_array( $field['output'] ) ) {
					continue;
				}

				// If no setting id, then exist
				if ( ! isset( $field['id'] ) ) {
					continue;
				}

				// Field Type
				$type = isset( $field['type'] ) ? esc_attr( $field['type'] ) : 'text';

				// Get the default value of this field
				$default = isset( $field['default'] ) ? $field['default'] : '';
				$value   = isset( $values[ $field['id'] ] ) ? $values[ $field['id'] ] : $default;

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

					// If value is array and field is not typography
					if ( is_array( $value ) ) {
						// Spacing Control type
						if ( is_array( $value ) && 'spacing' == $type ) {
							$spacing_list = array();


							foreach ( $value as $property => $property_value ) {
								if ( ! empty( $property_value ) ) {
									if ( ! in_array( $output['property'], array( 'padding', 'margin' ) ) ) {
										continue;
									}
									if ( ! in_array( $property, array( 'top', 'right', 'bottom', 'left' ) ) ) {
										continue;
									}
									$property = $output['property'] . '-' . $property;

									$css[ $output['media_query'] ][ $output['element'] ][ $property ] = $property_value;
								}
							}
						} else {
							foreach ( $value as $property => $property_value ) {
								if ( $property_value ) {
									$css[ $output['media_query'] ][ $output['element'] ][ $property ] = $property_value;
								}
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
		 * Meta box style
		 */
		public static function meta_box_style() {
			$asset_url = get_template_directory_uri() . '/assets';
			wp_enqueue_style( 'shapla-metabox', $asset_url . '/css/admin.css' );

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			// Enqueue selectWoo.
			wp_enqueue_script( 'selectWoo', $asset_url . '/libs/selectWoo/js/selectWoo.full.js', array( 'jquery' ), '1.0.1', true );
			wp_enqueue_style( 'selectWoo', $asset_url . '/libs/selectWoo/css/selectWoo.css', array(), '1.0.1' );
		}

		public static function meta_box_script() {
			?>
            <script>
                (function ($) {
                    $("#shapla-metabox-tabs").tabs();
                    $('select.shapla-select2').each(function () {
                        $(this).selectWoo();
                    });
                })(jQuery);
            </script>
			<?php
		}

		/**
		 * @param $options
		 *
		 * @return WP_Error|bool
		 */
		public function add( $options ) {
			if ( ! is_array( $options ) ) {
				return new WP_Error( 'invalid_options', __( 'Invalid options', 'shapla' ) );
			}

			if ( ! isset( $options['fields'] ) ) {
				return new WP_Error( 'fields_not_set', __( 'Field is not set properly.', 'shapla' ) );
			}

			$this->setConfig( array(
				'id'       => isset( $options['id'] ) ? sanitize_title_with_dashes( $options['id'] ) : 'shapla_meta_box_options',
				'title'    => isset( $options['title'] ) ? esc_attr( $options['title'] ) : __( 'Page Options', 'shapla' ),
				'screen'   => isset( $options['screen'] ) ? self::sanitize_value( $options['screen'] ) : 'page',
				'context'  => isset( $options['context'] ) ? esc_attr( $options['context'] ) : 'advanced',
				'priority' => isset( $options['priority'] ) ? esc_attr( $options['priority'] ) : 'low',
			) );

			$this->panels   = isset( $options['panels'] ) ? $options['panels'] : array();
			$this->sections = isset( $options['sections'] ) ? $options['sections'] : array();
			$this->fields   = isset( $options['fields'] ) ? $options['fields'] : array();

			$config = $this->getConfig();

			add_action( 'add_meta_boxes', function () use ( $config ) {
				add_meta_box(
					$config['id'],
					$config['title'],
					array( $this, 'meta_box_callback' ),
					$config['screen'],
					$config['context'],
					$config['priority'],
					$this->fields
				);
			} );

			return true;
		}

		/**
		 * @param WP_Post $post
		 * @param array $fields
		 */
		public function meta_box_callback( $post, $fields ) {
			if ( ! is_array( $fields ) ) {
				return;
			}

			wp_nonce_field( basename( __FILE__ ), '_shapla_nonce' );

			$values = (array) get_post_meta( $post->ID, $this->option_name, true );
			$panels = $this->getPanels();

			?>
            <div class="shapla-tabs-wrapper">
                <div id="shapla-metabox-tabs" class="shapla-tabs">
                    <ul class="shapla-tabs-list">
						<?php
						foreach ( $panels as $panel ) {
							$class = ! empty( $panel['class'] ) ? $panel['class'] : $panel['id'];
							echo '<li class="' . esc_attr( $class ) . '">';
							echo '<a href="#tab-' . esc_attr( $panel['id'] ) . '"><span>' . esc_html( $panel['title'] ) . '</span></a>';
							echo '</li>';
						}
						?>
                    </ul>
					<?php foreach ( $panels as $panel ) { ?>
                        <div id="tab-<?php echo esc_attr( $panel['id'] ); ?>" class="shapla_options_panel">
                            <!--<h2 class="title"><?php echo esc_html( $panel['title'] ); ?></h2>-->
							<?php
							$sections = $this->getSections( $panel['id'] );
							foreach ( $sections as $section ) {
								$fields = $this->getFields( $section['id'] );
								echo '<table class="form-table shapla-metabox-table">';
								foreach ( $fields as $_field ) {

									$field = self::sanitizeField( $_field );
									$name  = $this->option_name . '[' . $field['id'] . ']';

									$value = empty( $values[ $field['id'] ] ) ? $field['default'] : $values[ $field['id'] ];

									if ( ! isset( $values[ $field['id'] ] ) ) {
										$meta  = get_post_meta( $post->ID, $field['id'], true );
										$value = empty( $meta ) ? $field['default'] : $meta;
									}

									echo '<tr>';

									echo '<th>';

									echo '<label for="' . $field['id'] . '">';
									echo '<strong>' . $field['label'] . '</strong>';
									if ( ! empty( $field['description'] ) ) {
										echo '<span>' . $field['description'] . '</span>';
									}
									echo '</label>';
									echo '</th>';

									echo '<td>';
									switch ( $field['type'] ) {
										case 'checkbox':
											$this->checkbox( $field, $name, $value );
											break;
										case 'buttonset':
											$this->buttonset( $field, $name, $value );
											break;
										case 'spacing':
											$this->spacing( $field, $name, $value );
											break;
										case 'sidebars':
											$this->sidebars( $field, $name, $value );
											break;
										case 'text':
										case 'email':
										case 'number':
										case 'url':
											$this->text( $field, $name, $value );
											break;
									}
									echo '</td>';

									echo '</tr>';
								}

								echo '</table>';
							}
							?>
                        </div>
					<?php } ?>
                </div>
            </div>
			<?php
		}

		/**
		 * Save the meta when the post is saved.
		 *
		 * @param int $post_id Post ID.
		 * @param WP_Post $post Post object.
		 * @param bool $update Whether this is an existing post being updated or not.
		 *
		 * @return void
		 */
		public function save_meta_box( $post_id, $post, $update ) {
			// Check if not an autosave.
			if ( wp_is_post_autosave( $post_id ) ) {
				return;
			}

			// Check if not a revision.
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}

			// Verify that the nonce is valid.
			$nonce = isset( $_POST['_shapla_nonce'] ) && wp_verify_nonce( $_POST['_shapla_nonce'], basename( __FILE__ ) );
			if ( ! $nonce ) {
				return;
			}

			// Check if user has permissions to save data.
			$capability = ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) ? 'edit_page' : 'edit_post';
			if ( ! current_user_can( $capability, $post_id ) ) {
				return;
			}

			do_action( 'shapla_before_save_post_meta', $post_id, $post, $update );

			if ( isset( $_POST[ $this->option_name ] ) ) {
				update_post_meta( $post_id, $this->option_name, self::sanitize_value( $_POST[ $this->option_name ] ) );
			}

			do_action( 'shapla_after_save_post_meta', $post_id, $post, $update );
		}

		/**
		 * @return array
		 */
		public function getPanels() {
			$panels = [];

			foreach ( $this->panels as $panel ) {
				$panels[] = wp_parse_args( $panel, [
					'id'          => '',
					'title'       => '',
					'description' => '',
					'class'       => '',
					'priority'    => 200,
				] );
			}

			// Sort by priority
			usort( $panels, function ( $a, $b ) {
				return $a['priority'] - $b['priority'];
			} );

			return $panels;
		}

		/**
		 * @param array $panels
		 *
		 * @return Shapla_Metabox
		 */
		public function setPanels( $panels ) {
			$this->panels[] = $panels;

			return $this;
		}

		/**
		 * Get sections for current panel
		 *
		 * @param string $panel
		 *
		 * @return array
		 */
		public function getSections( $panel = '' ) {
			$sections = [];

			foreach ( $this->sections as $section ) {
				$sections[] = wp_parse_args( $section, [
					'id'          => '',
					'title'       => '',
					'description' => '',
					'panel'       => '',
					'priority'    => 200,
				] );
			}

			// Sort by priority
			usort( $sections, function ( $a, $b ) {
				return $a['priority'] - $b['priority'];
			} );

			if ( empty( $panel ) ) {
				return $sections;
			}

			$current_panel = [];
			foreach ( $sections as $section ) {
				if ( $section['panel'] == $panel ) {
					$current_panel[] = $section;
				}
			}

			return $current_panel;
		}

		/**
		 * @param array $sections
		 *
		 * @return Shapla_Metabox
		 */
		public function setSections( $sections ) {
			$this->sections[] = $sections;

			return $this;
		}

		/**
		 * @param string $section
		 *
		 * @return array
		 */
		public function getFields( $section = '' ) {
			$fields = [];

			foreach ( $this->fields as $field ) {
				if ( ! isset( $field['priority'] ) ) {
					$field['priority'] = 200;
				}
				$fields[] = $field;
			}

			// Sort by priority
			usort( $fields, function ( $a, $b ) {
				return $a['priority'] - $b['priority'];
			} );

			if ( empty( $section ) ) {
				return $fields;
			}

			$current_field = [];
			foreach ( $fields as $field ) {
				if ( $field['section'] == $section ) {
					$current_field[] = $field;
				}
			}

			return $current_field;
		}

		/**
		 * @param array $fields
		 *
		 * @return Shapla_Metabox
		 */
		public function setFields( $fields ) {
			$this->fields[] = $fields;

			return $this;
		}

		/**
		 * @return array
		 */
		public function getConfig() {
			return $this->config;
		}

		/**
		 * @param array $config
		 */
		public function setConfig( $config ) {
			$this->config = $config;
		}

		/**
		 * Sanitize Field with field default
		 *
		 * @param $field
		 *
		 * @return array
		 */
		private static function sanitizeField( $field ) {
			$is_valid_type = isset( $field['type'] ) && in_array( $field['type'], self::validFieldType() );
			$field_type    = $is_valid_type ? esc_attr( $field['type'] ) : 'text';
			$label_class   = isset( $field['label_class'] ) ? $field['label_class'] : '';
			$field_class   = isset( $field['field_class'] ) ? $field['field_class'] : 'regular-text';

			return array(
				'type'        => $field_type,
				'id'          => isset( $field['id'] ) ? esc_attr( $field['id'] ) : '',
				'section'     => isset( $field['section'] ) ? esc_attr( $field['section'] ) : 'default',
				'label'       => isset( $field['label'] ) ? esc_html( $field['label'] ) : '',
				'description' => isset( $field['description'] ) ? esc_html( $field['description'] ) : '',
				'priority'    => isset( $field['priority'] ) ? intval( $field['priority'] ) : 10,
				'default'     => isset( $field['default'] ) ? $field['default'] : '',
				'choices'     => isset( $field['choices'] ) ? $field['choices'] : array(),
				'field_class' => $field_class,
				'label_class' => $label_class,
			);
		}

		/**
		 * Valid input field type for metabox
		 *
		 * @return array
		 */
		private static function validFieldType() {
			return array(
				'text',
				'number',
				'email',
				'url',
				'checkbox',
				'buttonset',
				'spacing',
				'sidebars',
			);
		}

		/**
		 * Sanitize meta value
		 *
		 * @param $input
		 *
		 * @return array|string
		 */
		private static function sanitize_value( $input ) {
			// Initialize the new array that will hold the sanitize values
			$new_input = array();

			if ( is_array( $input ) ) {
				// Loop through the input and sanitize each of the values
				foreach ( $input as $key => $value ) {
					if ( is_array( $value ) ) {
						$new_input[ $key ] = self::sanitize_value( $value );
					} else {
						$new_input[ $key ] = sanitize_text_field( $value );
					}
				}
			} else {
				return sanitize_text_field( $input );
			}

			return $new_input;
		}

		/**
		 * Text field type
		 *
		 * @param $field
		 * @param $name
		 * @param $value
		 */
		private function text( $field, $name, $value ) {
			$valid_type = array( 'text', 'email', 'number', 'url' );
			$type       = in_array( $value['type'], $valid_type ) ? esc_attr( $value['type'] ) : 'text';
			echo '<input type="' . $type . '" id="' . $field['id'] . '" class="' . $field['field_class'] . '" name="' . $name . '" value="' . $value . '" />';
		}

		/**
		 * Checkbox field type
		 *
		 * @param $field
		 * @param $name
		 * @param $value
		 */
		private function checkbox( $field, $name, $value ) {
			$checked = Shapla_Sanitize::checked( $value ) ? 'checked' : '';
			echo '<input type="hidden" name="' . $name . '" value="off">';
			echo '<label for="' . $field['id'] . '">';
			echo '<input type="checkbox" value="on" id="' . $field['id'] . '" name="' . $name . '" ' . $checked . '><span>' . $field['label'] . '</span></label>';
		}

		/**
		 * Buttonset field type
		 *
		 * @param $field
		 * @param $name
		 * @param $value
		 */
		private function buttonset( $field, $name, $value ) {
			?>
            <div id="<?php echo $field['id']; ?>" class="buttonset">
				<?php foreach ( $field['choices'] as $key => $title ) { ?>
                    <input class="switch-input screen-reader-text" type="radio" value="<?php echo esc_attr( $key ); ?>"
                           name="<?php echo $name; ?>"
                           id="<?php echo $field['id'] . '-' . $key ?>" <?php checked( $key, $value ); ?> />
                    <label class="switch-label switch-label-<?php echo ( $key == $value ) ? 'on' : 'off' ?>"
                           for="<?php echo $field['id'] . '-' . $key ?>"><?php echo $title; ?></label>
				<?php } ?>
            </div>
			<?php
		}

		/**
		 * Dimension field type
		 *
		 * @param $field
		 * @param $name
		 * @param $value
		 */
		public function spacing( $field, $name, $value ) {
			$default = isset( $field['default'] ) ? $field['default'] : array();

			// Top
			if ( isset( $default['top'] ) ) {
				$top_name  = $name . "[top]";
				$top_value = isset( $value['top'] ) ? esc_attr( $value['top'] ) : $default['top'];
				?>
                <div class="shapla-dimension">
                    <span class="add-on"><i class="dashicons dashicons-arrow-up-alt"></i></span>
                    <input type="text" name="<?php echo $top_name; ?>" value="<?php echo $top_value; ?>">
                </div>
				<?php
			}

			// Right
			if ( isset( $default['right'] ) ) {
				$right_name  = $name . "[right]";
				$right_value = isset( $value['right'] ) ? esc_attr( $value['right'] ) : $default['right'];
				?>
                <div class="shapla-dimension">
                    <span class="add-on"><i class="dashicons dashicons-arrow-right-alt"></i></span>
                    <input type="text" name="<?php echo $right_name; ?>" value="<?php echo $right_value; ?>">
                </div>
				<?php
			}
			// Bottom
			if ( isset( $default['bottom'] ) ) {
				$bottom_name  = $name . "[bottom]";
				$bottom_value = isset( $value['bottom'] ) ? esc_attr( $value['bottom'] ) : $default['bottom'];
				?>
                <div class="shapla-dimension">
                    <span class="add-on"><i class="dashicons dashicons-arrow-down-alt"></i></span>
                    <input type="text" name="<?php echo $bottom_name; ?>" value="<?php echo $bottom_value; ?>">
                </div>
				<?php
			}
			// Bottom
			if ( isset( $default['left'] ) ) {
				$left_name  = $name . "[left]";
				$left_value = isset( $value['left'] ) ? esc_attr( $value['left'] ) : $default['left'];
				?>
                <div class="shapla-dimension">
                    <span class="add-on"><i class="dashicons dashicons-arrow-left-alt"></i></span>
                    <input type="text" name="<?php echo $left_name; ?>" value="<?php echo $left_value; ?>">
                </div>
				<?php
			}
		}

		/**
		 * @param $field
		 * @param $name
		 * @param $value
		 */
		public function sidebars( $field, $name, $value ) {
			global $wp_registered_sidebars;

			echo '<select name="' . $name . '" id="" class="regular-text shapla-select2">';
			echo '<option value="">' . esc_attr__( 'Default', 'shapla' ) . '</option>';
			foreach ( $wp_registered_sidebars as $key => $option ) {
				$selected = ( $value == $key ) ? ' selected="selected"' : '';
				echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_attr( $option['name'] ) . '</option>';
			}
			echo '</select>';
		}
	}
}

Shapla_Metabox::instance();

/*
 * Example Usages
 *
add_action( 'add_meta_boxes', function () {

	$options = array(
		'id'       => 'shapla-page-options',
		'title'    => __( 'Page Options', 'shapla' ),
		'screen'   => 'page',
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'type'        => 'checkbox',
				'id'          => 'hide_page_title',
				'label'       => __( 'Hide Page Title', 'shapla' ),
				'description' => __( 'Check to hide title for current page.', 'shapla' ),
				'default'     => 'off',
				'priority'    => 10,
				'section'     => 'page_title_bar',
			),
		)
	);

	Shapla_Metabox::instance()->add( $options );
} );
*/
