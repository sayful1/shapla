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
						'type'        => 'buttonset',
						'id'          => 'hide_page_title',
						'label'       => __( 'Page Title Bar', 'shapla' ),
						'description' => __( 'Controls title for current page.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'page_title_bar',
						'default'     => 'off',
						'choices'     => array(
							'off' => __( 'Show', 'shapla' ),
							'on'  => __( 'Hide', 'shapla' ),
						)
					),
					array(
						'type'        => 'buttonset',
						'id'          => 'show_breadcrumbs',
						'label'       => __( 'Breadcrumbs', 'shapla' ),
						'description' => __( 'Controls breadcrumbs for current page.', 'shapla' ),
						'priority'    => 20,
						'section'     => 'page_title_bar',
						'default'     => 'default',
						'choices'     => array(
							'default' => __( 'Default', 'shapla' ),
							'on'      => __( 'Show', 'shapla' ),
							'off'     => __( 'Hide', 'shapla' ),
						)
					),
				)
			);

			Shapla_Metabox::instance()->add( $options );
		}
	}
}

Shapla_Page_Metabox_Fields::init();
