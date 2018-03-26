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

				add_action( 'admin_enqueue_scripts', array( __CLASS__, 'meta_box_style' ) );
			}

			return self::$instance;
		}

		/**
		 * Shapla_Metabox constructor.
		 */
		public function __construct() {
			add_action( 'save_post', array( $this, 'save_meta_box' ), 10, 3 );
		}

		/**
		 * Meta box style
		 */
		public static function meta_box_style() {
			wp_enqueue_style(
				'shapla-metabox',
				get_template_directory_uri() . '/assets/css/admin.css'
			);
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
				'screen'   => isset( $options['screen'] ) ? $options['screen'] : 'page',
				'context'  => isset( $options['context'] ) ? esc_attr( $options['context'] ) : 'advanced',
				'priority' => isset( $options['priority'] ) ? esc_attr( $options['priority'] ) : 'low',
			) );

			$this->fields = $options['fields'];

			$config = $this->getConfig();

			add_meta_box(
				$config['id'],
				$config['title'],
				array( $this, 'meta_box_callback' ),
				$config['screen'],
				$config['context'],
				$config['priority'],
				$this->fields
			);

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
			foreach ( $this->getFields() as $_field ) {

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
				update_post_meta( $post_id, $this->option_name, $this->sanitize_value( $_POST[ $this->option_name ] ) );
			}

			do_action( 'shapla_after_save_post_meta', $post_id, $post, $update );
		}

		/**
		 * @return array
		 */
		public function getPanels() {
			return $this->panels;
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
		 * @return array
		 */
		public function getSections() {
			return $this->sections;
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
		 * @return array
		 */
		public function getFields() {
			return $this->fields;
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
			);
		}

		/**
		 * Sanitize meta value
		 *
		 * @param $input
		 *
		 * @return array|string
		 */
		private function sanitize_value( $input ) {
			// Initialize the new array that will hold the sanitize values
			$new_input = array();

			if ( is_array( $input ) ) {
				// Loop through the input and sanitize each of the values
				foreach ( $input as $key => $value ) {
					if ( is_array( $value ) ) {
						$new_input[ $key ] = $this->sanitize_value( $value );
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
