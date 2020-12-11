<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Shapla_Metabox' ) ) {
	/**
	 * Class Shapla_Metabox
	 */
	class Shapla_Metabox extends \Shapla\Metabox\MetaboxApi {

		/**
		 * @var self
		 */
		protected static $instance;

		/**
		 * Metabox field name
		 *
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
			add_action( 'save_post', [ $this, 'save_meta_box' ], 10, 3 );
		}

		/**
		 * Gets all our styles for current page and returns them as a string.
		 *
		 * @return string
		 */
		public function get_styles() {
			global $post;
			$fields = $this->get_fields();

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
				// If no setting id, then exist
				if ( ! isset( $field['id'] ) ) {
					continue;
				}

				// Get the default value of this field
				$default = isset( $field['default'] ) ? $field['default'] : '';
				$value   = isset( $values[ $field['id'] ] ) ? $values[ $field['id'] ] : $default;

				Shapla_CSS_Generator::css( $css, $field, $value );
			}

			return Shapla_CSS_Generator::styles_parse( $css );
		}

		/**
		 * Meta box style
		 */
		public static function meta_box_style() {
			wp_enqueue_style( 'shapla-metabox', SHAPLA_THEME_URI . '/assets/css/admin.css' );

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-tabs' );
		}

		public static function meta_box_script() {
			?>
			<script>
				(function ($) {
					$("#shapla-metabox-tabs").tabs();
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

			$this->set_config( $options );

			if ( isset( $options['panels'] ) ) {
				$this->set_panels( $options['panels'] );
			}

			if ( isset( $options['sections'] ) ) {
				$this->set_sections( $options['sections'] );
			}

			if ( isset( $options['fields'] ) ) {
				$this->set_fields( $options['fields'] );
			}

			add_action( 'add_meta_boxes', function () {
				$config = $this->get_config();
				add_meta_box( $config['id'], $config['title'], [ $this, 'meta_box_callback' ], $config['screen'],
						$config['context'], $config['priority'], $this->fields );
			} );

			return true;
		}

		/**
		 * @param WP_Post $post
		 * @param array   $fields
		 */
		public function meta_box_callback( $post, $fields ) {
			if ( ! is_array( $fields ) ) {
				return;
			}

			wp_nonce_field( basename( __FILE__ ), '_shapla_nonce' );

			$values = (array) get_post_meta( $post->ID, $this->option_name, true );
			$panels = $this->get_panels();

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
							$sections = $this->get_sections_by_panel( $panel['id'] );
							foreach ( $sections as $section ) {
								$fields = $this->get_fields_by_section( $section['id'] );
								echo '<table class="form-table shapla-metabox-table">';
								foreach ( $fields as $field ) {

									$name = $this->option_name . '[' . $field['id'] . ']';

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
									echo $this->render( $field, $name, $value );
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
		 * @param int     $post_id Post ID.
		 * @param WP_Post $post    Post object.
		 * @param bool    $update  Whether this is an existing post being updated or not.
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
				update_post_meta( $post_id, $this->option_name, Shapla_Sanitize::deep( $_POST[ $this->option_name ] ) );

				$styles = $this->get_styles();
				if ( ! empty( $styles ) ) {
					update_post_meta( $post_id, '_shapla_page_options_css', $styles );
				}
			}

			do_action( 'shapla_after_save_post_meta', $post_id, $post, $update );
		}

		/**
		 * Get sections by panel
		 *
		 * @param string $panel
		 *
		 * @return array
		 */
		public function get_sections_by_panel( $panel ) {
			$sections = [];
			foreach ( $this->get_sections() as $section ) {
				if ( $section['panel'] == $panel ) {
					$sections[] = $section;
				}
			}

			return $sections;
		}

		/**
		 * Get fields by section
		 *
		 * @param string $section
		 *
		 * @return array
		 */
		public function get_fields_by_section( $section ) {
			$current_field = [];
			foreach ( $this->get_fields() as $field ) {
				if ( $field['section'] == $section ) {
					$current_field[] = $field;
				}
			}

			return $current_field;
		}

		/**
		 * Render field
		 *
		 * @param array  $settings
		 * @param string $name
		 * @param mixed  $value
		 *
		 * @return string
		 */
		public function render( $settings, $name, $value ) {
			$types = [
					'text'      => Shapla\Metabox\Fields\Text::class,
					'checkbox'  => Shapla\Metabox\Fields\Checkbox::class,
					'buttonset' => Shapla\Metabox\Fields\ButtonGroup::class,
					'spacing'   => Shapla\Metabox\Fields\Spacing::class,
					'sidebars'  => Shapla\Metabox\Fields\Sidebar::class,
			];

			$type      = isset( $settings['type'] ) && array_key_exists( $settings['type'], $types ) ? $settings['type'] : 'text';
			$className = array_key_exists( $type, $types ) ? $types[ $type ] : $types['text'];
			$spacing   = new $className;
			$spacing->set_settings( $settings );
			$spacing->set_name( $name );
			$spacing->set_value( $value );

			return $spacing->render();
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
