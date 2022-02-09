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
		 * Shapla_Metabox constructor.
		 */
		public function __construct() {
			add_action( 'save_post', [ $this, 'save_meta_box' ], 10, 3 );
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
				update_post_meta( $post_id, $this->option_name, \Shapla\Helpers\Sanitize::deep( $_POST[ $this->option_name ] ) );

				$styles = $this->get_styles();
				if ( ! empty( $styles ) ) {
					update_post_meta( $post_id, '_shapla_page_options_css', $styles );
				}
			}

			do_action( 'shapla_after_save_post_meta', $post_id, $post, $update );
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
		 * @param array $fields
		 */
		public function meta_box_callback( $post, $fields ) {
			if ( ! is_array( $fields ) ) {
				return;
			}

			wp_nonce_field( basename( __FILE__ ), '_shapla_nonce' );

			$values = (array) get_post_meta( $post->ID, $this->option_name, true );

			echo '<table class="form-table shapla-metabox-table">';
			foreach ( $this->get_fields() as $field ) {

				$name = $this->option_name . '[' . $field['id'] . ']';

				$value = empty( $values[ $field['id'] ] ) ? $field['default'] : $values[ $field['id'] ];

				if ( ! isset( $values[ $field['id'] ] ) ) {
					$meta  = get_post_meta( $post->ID, $field['id'], true );
					$value = empty( $meta ) ? $field['default'] : $meta;
				}

				echo '<tr>';

				echo '<th>';

				echo '<label for="' . esc_attr( $field['id'] ) . '">';
				echo '<strong>' . esc_html( $field['label'] ) . '</strong>';
				if ( ! empty( $field['description'] ) ) {
					echo '<span>' . esc_html( $field['description'] ) . '</span>';
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

		/**
		 * Render field
		 *
		 * @param array $settings
		 * @param string $name
		 * @param mixed $value
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
				'select'    => Shapla\Metabox\Fields\Select::class,
			];

			$type      = isset( $settings['type'] ) && array_key_exists( $settings['type'], $types ) ? $settings['type'] : 'text';
			$className = array_key_exists( $type, $types ) ? $types[ $type ] : $types['text'];
			$field     = new $className;
			$field->set_settings( $settings );
			$field->set_name( $name );
			$field->set_value( $value );

			return $field->render();
		}
	}
}

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
