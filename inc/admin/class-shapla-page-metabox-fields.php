<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_Page_Metabox_Fields' ) ) {

	class Shapla_Page_Metabox_Fields {

		private static $instance;

		/**
		 * @return Shapla_Page_Metabox_Fields
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Shapla_Meta_Boxes constructor.
		 */
		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		}

		/**
		 * Adds the meta box container.
		 */
		public function add_meta_boxes() {
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
		}
	}
}

Shapla_Page_Metabox_Fields::init();
