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

				add_action( 'init', array( self::$instance, 'add_meta_boxes' ) );
			}

			return self::$instance;
		}

		/**
		 * Adds the meta box container.
		 */
		public function add_meta_boxes() {
			$metabox = Shapla_Metabox::instance();
			$options = [
				'id'       => 'shapla-page-options',
				'title'    => __( 'Shapla Page Options', 'shapla' ),
				'screen'   => [ 'page', 'post', 'product' ],
				'context'  => 'advanced',
				'priority' => 'low',
				'panels'   => [
					[
						'id'       => 'page_panel',
						'title'    => __( 'Content', 'shapla' ),
						'priority' => 20,
					],
					[
						'id'       => 'sidebar_panel',
						'title'    => __( 'Sidebar', 'shapla' ),
						'priority' => 50,
					],
					[
						'id'       => 'page_title_bar_panel',
						'title'    => __( 'Page Title Bar', 'shapla' ),
						'priority' => 70,
					],
				],
				'sections' => [
					[
						'id'       => 'page_section',
						'title'    => __( 'Content', 'shapla' ),
						'panel'    => 'page_panel',
						'priority' => 10,
					],
					[
						'id'       => 'sidebar_section',
						'title'    => __( 'Sidebar', 'shapla' ),
						'panel'    => 'sidebar_panel',
						'priority' => 20,
					],
					[
						'id'       => 'page_title_bar_section',
						'title'    => __( 'Page Title Bar', 'shapla' ),
						'panel'    => 'page_title_bar_panel',
						'priority' => 30,
					],
				],
				'fields'   => [
					[
						'type'        => 'spacing',
						'id'          => 'page_content_padding',
						'label'       => __( 'Content Padding', 'shapla' ),
						'description' => __( 'Leave empty to use value from theme options.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'page_section',
						'default'     => [
							'top'    => '',
							'bottom' => '',
						],
						'output'      => [
							[
								'element'  => [
									'.site-content .content-area',
									'.site-content .widget-area',
								],
								'property' => 'padding',
							],
						],
					],
					[
						'type'        => 'buttonset',
						'id'          => 'sidebar_position',
						'label'       => __( 'Sidebar Position', 'shapla' ),
						'description' => __( 'Controls sidebar position for current page.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'sidebar_section',
						'default'     => 'default',
						'choices'     => [
							'default'       => __( 'Default', 'shapla' ),
							'left-sidebar'  => __( 'Left', 'shapla' ),
							'right-sidebar' => __( 'Right', 'shapla' ),
							'full-width'    => __( 'Disabled', 'shapla' ),
						]
					],
					[
						'type'        => 'sidebars',
						'id'          => 'sidebar_widget_area',
						'label'       => __( 'Sidebar widget area', 'shapla' ),
						'description' => __( 'Controls sidebar widget area for current page.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'sidebar_section',
						'default'     => 'default',
						'choices'     => [
							'default'  => __( 'Default', 'shapla' ),
							'left'     => __( 'Left', 'shapla' ),
							'right'    => __( 'Right', 'shapla' ),
							'disabled' => __( 'Disabled', 'shapla' ),
						]
					],
					[
						'type'        => 'buttonset',
						'id'          => 'hide_page_title',
						'label'       => __( 'Page Title Bar', 'shapla' ),
						'description' => __( 'Controls title for current page.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'page_title_bar_section',
						'default'     => 'off',
						'choices'     => [
							'off' => __( 'Show', 'shapla' ),
							'on'  => __( 'Hide', 'shapla' ),
						]
					],
					[
						'type'        => 'buttonset',
						'id'          => 'show_breadcrumbs',
						'label'       => __( 'Breadcrumbs', 'shapla' ),
						'description' => __( 'Controls breadcrumbs for current page.', 'shapla' ),
						'priority'    => 20,
						'section'     => 'page_title_bar_section',
						'default'     => 'default',
						'choices'     => [
							'default' => __( 'Default', 'shapla' ),
							'on'      => __( 'Show', 'shapla' ),
							'off'     => __( 'Hide', 'shapla' ),
						]
					],
				]
			];

			$metabox->add( $options );
		}
	}
}

Shapla_Page_Metabox_Fields::init();
