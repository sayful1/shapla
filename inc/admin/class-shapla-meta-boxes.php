<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists('Shapla_Meta_Boxes') ):

class Shapla_Meta_Boxes {

	public function __construct()
	{
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes'  ) );
		add_action( 'save_post',      array( $this, 'save_meta_boxes' ) );
	}

	/**
     * Adds the meta box container.
     */
	public function add_meta_boxes( $post )
	{
		add_meta_box(
			'shapla_page_settings_meta_box',
			__( 'Shapla Page Settings', 'shapla' ),
			array( $this, 'page_settings' ),
			'page',
			'side',
			'high'
		);
	}

	/**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
	public function page_settings( $post )
	{
		// Add an nonce field so we can check for it later.
        wp_nonce_field( 'shapla_save_page_settings_meta_box', '_shapla_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $value 		= get_post_meta( $post->ID, '_shapla_hide_page_title', true );
        $checked 	= ($value == 'on') ? 'checked="checked"' : '';
 
        // Display the form, using the current value.
		echo '<input type="hidden" name="_shapla_hide_page_title" value="off">';
		echo sprintf('<fieldset><legend class="screen-reader-text"><span>%1$s</span></legend><label for="_shapla_hide_page_title"><input type="checkbox" value="on" id="_shapla_hide_page_title" name="_shapla_hide_page_title" %2$s><strong>%1$s</strong></label></fieldset>', __('Hide Page Title', 'shapla'), $checked );
	}

	/**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
	public function save_meta_boxes( $post_id )
	{
		// Check if nonce is set.
        if ( ! isset( $_POST['_shapla_nonce'] ) ) {
            return $post_id;
        }
 
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $_POST['_shapla_nonce'], 'shapla_save_page_settings_meta_box' ) ) {
            return $post_id;
        }

		// Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return $post_id;
        }

        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return $post_id;
        }

        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }

        // Sanitize the user input.
        $hide_page_title = sanitize_text_field( $_POST['_shapla_hide_page_title'] );
 
        // Update the meta field.
        update_post_meta( $post_id, '_shapla_hide_page_title', $hide_page_title );
	}
}

new Shapla_Meta_Boxes();

endif;