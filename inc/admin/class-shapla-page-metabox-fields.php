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
			$metabox = Shapla_Metabox::instance();
			$options = array(
				'id'       => 'shapla-page-options',
				'title'    => __( 'Page Options', 'shapla' ),
				'screen'   => 'page',
				'context'  => 'normal',
				'priority' => 'high',
				'panels'   => array(
					array(
						'id'       => 'page_panel',
						'title'    => __( 'Page', 'shapla' ),
						'priority' => 20,
					),
					array(
						'id'       => 'sidebar_panel',
						'title'    => __( 'Sidebar', 'shapla' ),
						'priority' => 50,
					),
					array(
						'id'       => 'page_title_bar_panel',
						'title'    => __( 'Page Title Bar', 'shapla' ),
						'priority' => 70,
					),
				),
				'sections' => array(
					array(
						'id'       => 'page_section',
						'title'    => __( 'Page', 'shapla' ),
						'panel'    => 'page_panel',
						'priority' => 10,
					),
					array(
						'id'       => 'sidebar_section',
						'title'    => __( 'Sidebar', 'shapla' ),
						'panel'    => 'sidebar_panel',
						'priority' => 10,
					),
					array(
						'id'       => 'page_title_bar_section',
						'title'    => __( 'Page Title Bar', 'shapla' ),
						'panel'    => 'page_title_bar_panel',
						'priority' => 20,
					),
				),
				'fields'   => array(
					array(
						'type'        => 'dimensions',
						'id'          => 'page_content_padding',
						'label'       => __( 'Page Content Padding', 'shapla' ),
						'description' => __( 'Leave empty to use value from theme options.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'page_section',
						'default'     => array(
							'top'    => '',
							'bottom' => '',
						)
					),
					array(
						'type'        => 'buttonset',
						'id'          => 'sidebar_position',
						'label'       => __( 'Sidebar Position', 'shapla' ),
						'description' => __( 'Controls sidebar position for current page.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'sidebar_section',
						'default'     => 'default',
						'choices'     => array(
							'default'  => __( 'Default', 'shapla' ),
							'left'     => __( 'Left', 'shapla' ),
							'right'    => __( 'Right', 'shapla' ),
							'disabled' => __( 'Disabled', 'shapla' ),
						)
					),
					array(
						'type'        => 'sidebars',
						'id'          => 'sidebar_widget_area',
						'label'       => __( 'Sidebar widget area', 'shapla' ),
						'description' => __( 'Controls sidebar widget area for current page.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'sidebar_section',
						'default'     => 'default',
						'choices'     => array(
							'default'  => __( 'Default', 'shapla' ),
							'left'     => __( 'Left', 'shapla' ),
							'right'    => __( 'Right', 'shapla' ),
							'disabled' => __( 'Disabled', 'shapla' ),
						)
					),
					array(
						'type'        => 'buttonset',
						'id'          => 'hide_page_title',
						'label'       => __( 'Page Title Bar', 'shapla' ),
						'description' => __( 'Controls title for current page.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'page_title_bar_section',
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
						'section'     => 'page_title_bar_section',
						'default'     => 'default',
						'choices'     => array(
							'default' => __( 'Default', 'shapla' ),
							'on'      => __( 'Show', 'shapla' ),
							'off'     => __( 'Hide', 'shapla' ),
						)
					),
				)
			);

			$metabox->add( $options );
		}
	}
}

Shapla_Page_Metabox_Fields::init();
