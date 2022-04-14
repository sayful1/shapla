<?php

namespace Shapla\Customize;

use Shapla\Helpers\Colors;

class CustomizerConfig extends BaseConfig {
	/**
	 * Initiate panels, sections and fields
	 *
	 * @return void
	 */
	public static function init() {
		self::register_panels();
		self::register_sections();
		self::register_fields();
	}

	/**
	 * Register panels
	 *
	 * @return void
	 */
	public static function register_panels() {
		$panels = [
			'page_title_bar_panel' => [
				'title'    => __( 'Page Title Bar', 'shapla' ),
				'priority' => 30,
			],
			'site_footer_panel'    => [
				'title'       => __( 'Footer', 'shapla' ),
				'description' => __( 'Customise the look & feel of your web site footer.', 'shapla' ),
				'priority'    => 30,
			],
			'typography_panel'     => [
				'title'    => __( 'Typography', 'shapla' ),
				'priority' => 40,
			],
			'blog_panel'           => [
				'title'    => __( 'Blog', 'shapla' ),
				'priority' => 50,
			],
			'extra_panel'          => [
				'title'    => __( 'Extra', 'shapla' ),
				'priority' => 190,
			]
		];

		if ( shapla_is_woocommerce_activated() ) {
			$panels['woocommerce'] = [
				'title'       => __( 'WooCommerce', 'shapla' ),
				'description' => __( 'Customise WooCommerce related look & feel of your web site.', 'shapla' ),
				'priority'    => 200,
			];
		}

		self::set_panels( $panels );
	}

	/**
	 * Register sections
	 *
	 * @return void
	 */
	public static function register_sections() {
		$sections = [
			'general_blog_section'       => [
				'title'       => __( 'General Blog', 'shapla' ),
				'description' => __( 'Customise your site blog layouts and styles.', 'shapla' ),
				'panel'       => 'blog_panel',
				'priority'    => 10,
			],
			'single_blog_section'        => [
				'title'       => __( 'Blog Single Post', 'shapla' ),
				'description' => __( 'Customise your site single blog layouts and styles.', 'shapla' ),
				'panel'       => 'blog_panel',
				'priority'    => 20,
			],
			'blog_meta_section'          => [
				'title'       => __( 'Blog Meta', 'shapla' ),
				'description' => __( 'Customise your site blog meta data and its styles.', 'shapla' ),
				'panel'       => 'blog_panel',
				'priority'    => 30,
			],
			// Extra
			'go_to_top_button_section'   => [
				'title'    => __( 'Go to Top Button', 'shapla' ),
				'panel'    => 'extra_panel',
				'priority' => 10,
			],
			'structured_data_section'    => [
				'title'    => __( 'Structured Data', 'shapla' ),
				'panel'    => 'extra_panel',
				'priority' => 20,
			],
			// Layout
			'layout_section'             => [
				'title'       => __( 'Layout', 'shapla' ),
				'description' => __( 'Customise the look & feel of your web site layout.', 'shapla' ),
				'priority'    => 10,
			],
			// Page Title Bar
			'breadcrumbs'                => [
				'title'    => __( 'Breadcrumbs', 'shapla' ),
				'priority' => 20,
				'panel'    => 'page_title_bar_panel',
			],
			'page_title_bar'             => [
				'title'    => __( 'Page Title Bar', 'shapla' ),
				'priority' => 10,
				'panel'    => 'page_title_bar_panel',
			],
			// Site Footer
			'site_footer_widgets'        => [
				'title'       => __( 'Widgets', 'shapla' ),
				'description' => __( 'Customise the look & feel of your web site footer widget area.', 'shapla' ),
				'panel'       => 'site_footer_panel',
				'priority'    => 10,
			],
			'site_footer_bottom_bar'     => [
				'title'       => __( 'Bottom Bar', 'shapla' ),
				'description' => __( 'Customise the look & feel of your web site footer bottom bar.', 'shapla' ),
				'panel'       => 'site_footer_panel',
				'priority'    => 20,
			],
			// Theme colors
			'theme_colors'               => [
				'title'       => __( 'Colors', 'shapla' ),
				'description' => __( 'Customise colors of your web site.', 'shapla' ),
				'priority'    => 20,
			],
			// Typography
			'body_typography_section'    => [
				'title'    => __( 'Body Typography', 'shapla' ),
				'panel'    => 'typography_panel',
				'priority' => 10,
			],
			'headers_typography_section' => [
				'title'    => __( 'Headers Typography', 'shapla' ),
				'panel'    => 'typography_panel',
				'priority' => 20,
			]
		];

		if ( shapla_is_woocommerce_activated() ) {
			$sections['shapla_woocommerce_section'] = [
				'title'       => __( 'General', 'shapla' ),
				'description' => __( 'Customise WooCommerce related look & feel of your web site.', 'shapla' ),
				'panel'       => 'woocommerce',
				'priority'    => 100,
			];
		}

		self::set_sections( $sections );
	}

	/**
	 * Register fields
	 *
	 * @return void
	 */
	public static function register_fields() {
		self::register_layout_fields();
		self::register_color_themes_fields();
		self::register_typography_fields();
		self::register_header_fields();
		self::register_page_title_bar_fields();
		self::register_site_footer_fields();
		self::register_blog_fields();
		self::register_extra_fields();
		if ( shapla_is_woocommerce_activated() ) {
			self::register_woocommerce_fields();
		}
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_layout_fields() {
		$fields = [
			'site_layout'    => [
				'type'        => 'radio-button',
				'section'     => 'layout_section',
				'label'       => __( 'Site Layout', 'shapla' ),
				'description' => __( 'Controls the site layout.', 'shapla' ),
				'default'     => shapla_default_options( 'site_layout' ),
				'priority'    => 10,
				'choices'     => [
					'wide'  => __( 'Wide', 'shapla' ),
					'boxed' => __( 'Boxed', 'shapla' ),
				],
			],
			'general_layout' => [
				'type'        => 'radio-image',
				'section'     => 'layout_section',
				'label'       => __( 'Sidebar Layout', 'shapla' ),
				'description' => __( 'Controls the site sidebar layout.', 'shapla' ),
				'default'     => shapla_default_options( 'general_layout' ),
				'priority'    => 20,
				'choices'     => [
					'right-sidebar' => get_template_directory_uri() . '/assets/static-images/2cr.svg',
					'left-sidebar'  => get_template_directory_uri() . '/assets/static-images/2cl.svg',
					'full-width'    => get_template_directory_uri() . '/assets/static-images/1c.svg',
				],
			],
			'header_layout'  => [
				'type'        => 'radio-image',
				'section'     => 'layout_section',
				'label'       => __( 'Header Layout', 'shapla' ),
				'description' => __( 'Controls the site header layout.', 'shapla' ),
				'default'     => shapla_default_options( 'header_layout' ),
				'priority'    => 30,
				'choices'     => [
					'layout-1' => get_template_directory_uri() . '/assets/static-images/layout-1.svg',
					'layout-2' => get_template_directory_uri() . '/assets/static-images/layout-2.svg',
					'layout-3' => get_template_directory_uri() . '/assets/static-images/layout-3.svg',
				],
			]
		];

		self::set_fields( $fields );
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_color_themes_fields() {
		$fields = Colors::customizer_colors_settings();
		self::set_fields( $fields );
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_typography_fields() {
		$fields = [
			'body_typography'        => [
				'type'        => 'typography',
				'section'     => 'body_typography_section',
				'label'       => esc_attr__( 'Body Typography', 'shapla' ),
				'description' => esc_attr__( 'These settings control the typography for all body text.', 'shapla' ),
				'default'     => [
					'font-family' => shapla_default_options( 'font_family' ),
					'variant'     => '400',
					'font-size'   => '1rem',
					'line-height' => '1.5',
				],
				'priority'    => 10,
				'choices'     => [
					'fonts'       => [
						'standard' => [ 'serif', 'sans-serif', ],
					],
					'font-backup' => true
				],
				'output'      => [
					[
						'element' => [ 'body', 'button', 'input', 'select', 'textarea', ],
					],
				],
			],
			'headers_typography'     => [
				'type'        => 'typography',
				'section'     => 'headers_typography_section',
				'label'       => esc_attr__( 'Headers Typography', 'shapla' ),
				'description' => esc_attr__( 'These settings control the typography for all H1, H2, H3, H4, H5, H6 Headers.', 'shapla' ),
				'default'     => [
					'font-family'    => shapla_default_options( 'font_family' ),
					'variant'        => '500',
					'text-transform' => 'none',
				],
				'priority'    => 10,
				'choices'     => [
					'fonts' => [
						'standard' => [
							'serif',
							'sans-serif',
						],
					],
				],
				'output'      => [
					[
						'element' => 'h1,h2,h3,h4,h5,h6',
					],
				],
			],
			'h1_headers_typography'  => [
				'type'        => 'typography',
				'section'     => 'headers_typography_section',
				'label'       => esc_attr__( 'H1 Headers Typography', 'shapla' ),
				'description' => esc_attr__( 'These settings control the typography for all H1 Headers.', 'shapla' ),
				'default'     => [
					'font-size'   => '2.5rem',
					'line-height' => '1.2',
				],
				'priority'    => 20,
				'output'      => [
					[
						'element' => 'h1',
					],
				],
			],
			'h2_headers_typography'  => [
				'type'        => 'typography',
				'section'     => 'headers_typography_section',
				'label'       => esc_attr__( 'H2 Headers Typography', 'shapla' ),
				'description' => esc_attr__( 'These settings control the typography for all H2 Headers.', 'shapla' ),
				'priority'    => 30,
				'default'     => [
					'font-size'   => '2rem',
					'line-height' => '1.2',
				],
				'output'      => [
					[
						'element' => 'h2',
					],
				],
			],
			'h3_headers_typography'  => [
				'type'        => 'typography',
				'section'     => 'headers_typography_section',
				'label'       => esc_attr__( 'H3 Headers Typography', 'shapla' ),
				'description' => esc_attr__( 'These settings control the typography for all H3 Headers.', 'shapla' ),
				'priority'    => 40,
				'default'     => [
					'font-size'   => '1.75rem',
					'line-height' => '1.2',
				],
				'output'      => [
					[
						'element' => 'h3',
					],
				],
			],
			'h4_headers_typography'  => [
				'type'        => 'typography',
				'section'     => 'headers_typography_section',
				'label'       => esc_attr__( 'H4 Headers Typography', 'shapla' ),
				'description' => esc_attr__( 'These settings control the typography for all H4 Headers.', 'shapla' ),
				'priority'    => 50,
				'default'     => [
					'font-size'   => '1.5rem',
					'line-height' => '1.2',
				],
				'output'      => [
					[
						'element' => 'h4',
					],
				],
			],
			'h5_headers_typography'  => [
				'type'        => 'typography',
				'section'     => 'headers_typography_section',
				'label'       => esc_attr__( 'H5 Headers Typography', 'shapla' ),
				'description' => esc_attr__( 'These settings control the typography for all H5 Headers.', 'shapla' ),
				'priority'    => 50,
				'default'     => [
					'font-size'   => '1.25rem',
					'line-height' => '1.2',
				],
				'output'      => [
					[
						'element' => 'h5',
					],
				],
			],
			'h6_headers_typography'  => [
				'type'        => 'typography',
				'section'     => 'headers_typography_section',
				'label'       => esc_attr__( 'H6 Headers Typography', 'shapla' ),
				'description' => esc_attr__( 'These settings control the typography for all H6 Headers.', 'shapla' ),
				'priority'    => 50,
				'default'     => [
					'font-size'   => '1rem',
					'line-height' => '1.2',
				],
				'output'      => [
					[
						'element' => 'h6',
					],
				],
			],
			'post_titles_typography' => [
				'type'        => 'typography',
				'section'     => 'headers_typography_section',
				'label'       => esc_attr__( 'Post Titles Typography', 'shapla' ),
				'description' => esc_attr__( 'Controls the font size and line height of post titles including archive and single posts. This is a H2 heading. Enter value including CSS unit (px, em, rem), ex: 18px.', 'shapla' ),
				'priority'    => 50,
				'default'     => [
					'font-size'   => '1.25rem',
					'line-height' => '1.2',
				],
				'output'      => [
					[
						'element' => [
							'.blog-grid .blog-grid-inside .entry-title',
						],
					],
				],
			],
		];
		self::set_fields( $fields );
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_header_fields() {
		$fields = [
			'site_logo_text_font_size' => [
				'type'     => 'text',
				'section'  => 'header_image',
				'label'    => __( 'Site Title Font Size', 'shapla' ),
				'default'  => shapla_default_options( 'site_logo_text_font_size' ),
				'priority' => 40,
			],
			'header_background_color'  => [
				'type'     => 'alpha-color',
				'section'  => 'header_image',
				'label'    => __( 'Header Background Color', 'shapla' ),
				'default'  => shapla_default_options( 'header_background_color' ),
				'priority' => 10,
			],
			'header_text_color'        => [
				'type'     => 'alpha-color',
				'section'  => 'header_image',
				'label'    => __( 'Header Text Color', 'shapla' ),
				'default'  => shapla_default_options( 'header_text_color' ),
				'priority' => 20,
			],
			'header_link_color'        => [
				'type'     => 'alpha-color',
				'section'  => 'header_image',
				'label'    => __( 'Header Link Color', 'shapla' ),
				'default'  => shapla_default_options( 'header_link_color' ),
				'priority' => 30,
			],
			'sticky_header'            => [
				'type'        => 'toggle',
				'section'     => 'header_image',
				'label'       => __( 'Sticky Header', 'shapla' ),
				'description' => __( 'Check to to enable a sticky header.', 'shapla' ),
				'default'     => shapla_default_options( 'sticky_header' ),
				'priority'    => 40,
			],
			'show_search_icon'         => [
				'type'        => 'toggle',
				'section'     => 'header_image',
				'label'       => __( 'Show Search Icon', 'shapla' ),
				'description' => __( 'Check to show search icon on navigation bar in header area.', 'shapla' ),
				'default'     => shapla_default_options( 'show_search_icon' ),
				'priority'    => 50,
			],
			'dropdown_direction'       => [
				'type'     => 'radio-button',
				'section'  => 'header_image',
				'label'    => __( 'Dropdown direction', 'shapla' ),
				'default'  => shapla_default_options( 'dropdown_direction' ),
				'priority' => 60,
				'choices'  => [
					'ltr' => esc_html__( 'Left to Right', 'shapla' ),
					'rtl' => esc_html__( 'Right to Left', 'shapla' ),
				]
			],
		];
		self::set_fields( $fields );
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_page_title_bar_fields() {
		$fields = [
			'page_title_bar_padding'        => [
				'type'        => 'text',
				'section'     => 'page_title_bar',
				'label'       => __( 'Page Title Bar Top &amp; Bottom Padding', 'shapla' ),
				'description' => __( 'Controls the top and bottom padding of the page title bar. Enter value including any valid CSS unit(px,em,rem)',
					'shapla' ),
				'default'     => shapla_default_options( 'page_title_bar_padding' ),
				'priority'    => 10,
			],
			'page_title_bar_border_color'   => [
				'type'        => 'alpha-color',
				'section'     => 'page_title_bar',
				'label'       => __( 'Page Title Bar Borders Color', 'shapla' ),
				'description' => __( 'Controls the border colors of the page title bar.', 'shapla' ),
				'default'     => shapla_default_options( 'page_title_bar_border_color' ),
				'priority'    => 20,
			],
			'page_title_bar_text_alignment' => [
				'type'        => 'select',
				'section'     => 'page_title_bar',
				'label'       => __( 'Page Title Bar Text Alignment', 'shapla' ),
				'description' => __( 'Controls the page title bar text alignment.', 'shapla' ),
				'default'     => shapla_default_options( 'page_title_bar_text_alignment' ),
				'priority'    => 30,
				'choices'     => [
					'all_left'  => __( 'Left', 'shapla' ),
					'centered'  => __( 'Centered', 'shapla' ),
					'all_right' => __( 'Right', 'shapla' ),
					'left'      => __( 'Left Title &amp; Right Breadcrumbs', 'shapla' ),
					'right'     => __( 'Left Breadcrumbs &amp; Right Title', 'shapla' ),
				],
			],
			'page_title_bar_background'     => [
				'type'        => 'background',
				'label'       => esc_attr__( 'Page Title Bar Background', 'shapla' ),
				'description' => esc_attr__( 'Controls the background of the page title bar.', 'shapla' ),
				'section'     => 'page_title_bar',
				'priority'    => 40,
				'default'     => [
					'background-color'      => shapla_default_options( 'page_title_bar_background_color' ),
					'background-image'      => shapla_default_options( 'page_title_bar_background_image' ),
					'background-repeat'     => shapla_default_options( 'page_title_bar_background_repeat' ),
					'background-position'   => shapla_default_options( 'page_title_bar_background_position' ),
					'background-size'       => shapla_default_options( 'page_title_bar_background_size' ),
					'background-attachment' => shapla_default_options( 'page_title_bar_background_attachment' ),
				],
			],
			'page_title_typography'         => [
				'type'        => 'typography',
				'section'     => 'page_title_bar',
				'label'       => esc_attr__( 'Page Title Typography', 'shapla' ),
				'description' => esc_attr__( 'Control the typography for page title.', 'shapla' ),
				'default'     => [
					'font-size'      => shapla_default_options( 'page_title_font_size' ),
					'line-height'    => shapla_default_options( 'page_title_line_height' ),
					'color'          => shapla_default_options( 'page_title_font_color' ),
					'text-transform' => shapla_default_options( 'page_title_text_transform' ),
				],
				'priority'    => 50,
				'choices'     => [
					'fonts'       => [
						'standard' => [
							'serif',
							'sans-serif',
						],
					],
					'font-backup' => true
				],
			],
			'breadcrumbs_content_display'   => [
				'type'        => 'radio-button',
				'section'     => 'breadcrumbs',
				'label'       => __( 'Breadcrumbs Content Display', 'shapla' ),
				'description' => __( 'Controls what displays in the breadcrumbs area.', 'shapla' ),
				'default'     => shapla_default_options( 'breadcrumbs_content_display' ),
				'priority'    => 10,
				'choices'     => [
					'none'       => __( 'None', 'shapla' ),
					'breadcrumb' => __( 'Breadcrumbs', 'shapla' ),
				],
			],
			'breadcrumbs_on_mobile_devices' => [
				'type'        => 'radio-button',
				'section'     => 'breadcrumbs',
				'label'       => __( 'Breadcrumbs on Mobile Devices', 'shapla' ),
				'description' => __( 'Turn on to display breadcrumbs on mobile devices.', 'shapla' ),
				'default'     => shapla_default_options( 'breadcrumbs_on_mobile_devices' ),
				'priority'    => 20,
				'choices'     => [
					'off' => __( 'Off', 'shapla' ),
					'on'  => __( 'On', 'shapla' ),
				],
			],
			'breadcrumbs_separator'         => [
				'type'        => 'select',
				'section'     => 'breadcrumbs',
				'label'       => __( 'Breadcrumbs Separator', 'shapla' ),
				'description' => __( 'Controls the type of separator between each breadcrumb. ', 'shapla' ),
				'default'     => shapla_default_options( 'breadcrumbs_separator' ),
				'priority'    => 30,
				'choices'     => [
					'slash'    => __( 'Slash', 'shapla' ),
					'arrow'    => __( 'Arrow', 'shapla' ),
					'bullet'   => __( 'Bullet', 'shapla' ),
					'dot'      => __( 'Dot', 'shapla' ),
					'succeeds' => __( 'Succeeds', 'shapla' ),
				],
			],
		];
		self::set_fields( $fields );
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_site_footer_fields() {
		$fields = [
			'footer_widget_rows'       => [
				'type'        => 'range-slider',
				'section'     => 'site_footer_widgets',
				'label'       => __( 'Footer Widget Rows', 'shapla' ),
				'description' => __( 'Select the number of widgets rows you want in the footer. After changing value, save and refresh the page.', 'shapla' ),
				'default'     => shapla_default_options( 'footer_widget_rows' ),
				'priority'    => 10,
				'input_attrs' => [
					'min'  => 1,
					'max'  => 10,
					'step' => 1,
				],
			],
			'footer_widget_columns'    => [
				'type'        => 'range-slider',
				'section'     => 'site_footer_widgets',
				'label'       => __( 'Footer Widget Columns', 'shapla' ),
				'description' => __( 'Select the number of columns you want in each widgets rows in the footer.  After changing value, save and refresh the page.', 'shapla' ),
				'default'     => shapla_default_options( 'footer_widget_columns' ),
				'priority'    => 20,
				'input_attrs' => [
					'min'  => 1,
					'max'  => 10,
					'step' => 1,
				],
			],
			'footer_widget_background' => [
				'type'        => 'background',
				'label'       => esc_attr__( 'Footer Widget Area Background', 'shapla' ),
				'description' => esc_attr__( 'Controls the background of the footer widget area.', 'shapla' ),
				'section'     => 'site_footer_widgets',
				'priority'    => 50,
				'default'     => [
					'background-color'      => shapla_default_options( 'footer_widget_background_color' ),
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-position'   => 'center center',
					'background-size'       => 'cover',
					'background-attachment' => 'fixed',
				],
			],
			'footer_widget_text_color' => [
				'type'     => 'alpha-color',
				'section'  => 'site_footer_widgets',
				'label'    => __( 'Text Color', 'shapla' ),
				'default'  => shapla_default_options( 'footer_widget_text_color' ),
				'priority' => 30,
			],
			'footer_widget_link_color' => [
				'type'     => 'alpha-color',
				'section'  => 'site_footer_widgets',
				'label'    => __( 'Link Color', 'shapla' ),
				'default'  => shapla_default_options( 'footer_widget_link_color' ),
				'priority' => 40,
			],
			'site_footer_bg_color'     => [
				'type'     => 'alpha-color',
				'section'  => 'site_footer_bottom_bar',
				'label'    => __( 'Background Color', 'shapla' ),
				'default'  => shapla_default_options( 'site_footer_bg_color' ),
				'priority' => 10,
			],
			'site_footer_text_color'   => [
				'type'     => 'alpha-color',
				'section'  => 'site_footer_bottom_bar',
				'label'    => __( 'Text Color', 'shapla' ),
				'default'  => shapla_default_options( 'site_footer_text_color' ),
				'priority' => 20,
			],
			'site_footer_link_color'   => [
				'type'     => 'alpha-color',
				'section'  => 'site_footer_bottom_bar',
				'label'    => __( 'Link Color', 'shapla' ),
				'default'  => shapla_default_options( 'site_footer_link_color' ),
				'priority' => 30,
			],
			'site_copyright_text'      => [
				'type'        => 'textarea',
				'section'     => 'site_footer_bottom_bar',
				'label'       => __( 'Copyright Text', 'shapla' ),
				'description' => __( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'shapla' ),
				'default'     => shapla_default_options( 'site_copyright_text' ),
				'priority'    => 40,
			],
		];
		self::set_fields( $fields );
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_blog_fields() {
		$fields = [
			'show_blog_page_title'    => [
				'type'              => 'toggle',
				'section'           => 'general_blog_section',
				'label'             => __( 'Blog Page Title Bar', 'shapla' ),
				'description'       => __( 'Controls how the page title bar displays on the assigned blog page in "settings > reading".', 'shapla' ),
				'default'           => shapla_default_options( 'show_blog_page_title' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 10,
			],
			'blog_page_title'         => [
				'type'              => 'text',
				'section'           => 'general_blog_section',
				'label'             => __( 'Blog Page Title', 'shapla' ),
				'description'       => __( 'Controls the title text that displays in the page title bar only if your front page displays your latest post in "settings > reading".', 'shapla' ),
				'default'           => shapla_default_options( 'blog_page_title' ),
				'priority'          => 20,
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'text' ],
			],
			'blog_layout'             => [
				'type'              => 'select',
				'section'           => 'general_blog_section',
				'label'             => __( 'Blog layout', 'shapla' ),
				'description'       => __( 'Controls the layout for the assigned blog page in "settings > reading".', 'shapla' ),
				'default'           => shapla_default_options( 'blog_layout' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'customize_choices' ],
				'priority'          => 30,
				'choices'           => [
					'default' => esc_html__( 'Default', 'shapla' ),
					'grid'    => esc_html__( 'Grid', 'shapla' ),
				],
			],
			'blog_excerpt_length'     => [
				'type'              => 'range-slider',
				'section'           => 'general_blog_section',
				'label'             => __( 'Excerpt length', 'shapla' ),
				'description'       => __( 'Controls the number of words in the post excerpts for the assigned blog page in "settings > reading" or blog archive pages.', 'shapla' ),
				'default'           => shapla_default_options( 'blog_excerpt_length' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'number' ],
				'priority'          => 40,
				'input_attrs'       => [
					'min'  => 5,
					'max'  => 200,
					'step' => 1,
				],
			],
			'blog_date_format'        => [
				'type'              => 'radio-button',
				'section'           => 'general_blog_section',
				'label'             => __( 'Blog date format', 'shapla' ),
				'description'       => __( 'Default date format is format you set from Settings --> General --> Date Format', 'shapla' ),
				'default'           => shapla_default_options( 'blog_date_format' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'customize_choices' ],
				'priority'          => 50,
				'choices'           => [
					'default' => esc_html__( 'Default', 'shapla' ),
					'human'   => esc_html__( 'Human readable', 'shapla' ),
				]
			],
			'show_blog_author_avatar' => [
				'type'              => 'toggle',
				'section'           => 'blog_meta_section',
				'label'             => __( 'Post Meta Author Avatar', 'shapla' ),
				'description'       => __( 'Turn on to display the post meta author avatar.', 'shapla' ),
				'default'           => shapla_default_options( 'show_blog_author_avatar' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 10,
			],
			'show_blog_author_name'   => [
				'type'              => 'toggle',
				'section'           => 'blog_meta_section',
				'label'             => __( 'Post Meta Author Name', 'shapla' ),
				'description'       => __( 'Turn on to display the post meta author name.', 'shapla' ),
				'default'           => shapla_default_options( 'show_blog_author_name' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 20,
			],
			'show_blog_date'          => [
				'type'              => 'toggle',
				'section'           => 'blog_meta_section',
				'label'             => __( 'Post Meta Date', 'shapla' ),
				'description'       => __( 'Turn on to display the post meta date.', 'shapla' ),
				'default'           => shapla_default_options( 'show_blog_date' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 30,
			],
			'show_blog_category_list' => [
				'type'              => 'toggle',
				'section'           => 'blog_meta_section',
				'label'             => __( 'Post Meta Categories', 'shapla' ),
				'description'       => __( 'Turn on to display the post meta categories.', 'shapla' ),
				'default'           => shapla_default_options( 'show_blog_category_list' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 40,
			],
			'show_blog_tag_list'      => [
				'type'              => 'toggle',
				'section'           => 'blog_meta_section',
				'label'             => __( 'Post Meta Tags', 'shapla' ),
				'description'       => __( 'Turn on to display the post meta tags.', 'shapla' ),
				'default'           => shapla_default_options( 'show_blog_tag_list' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 50,
			],
			'show_blog_comments_link' => [
				'type'              => 'toggle',
				'section'           => 'blog_meta_section',
				'label'             => __( 'Post Meta Comments', 'shapla' ),
				'description'       => __( 'Turn on to display the post meta comments.', 'shapla' ),
				'default'           => shapla_default_options( 'show_blog_comments_link' ),
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 60,
			],

		];
		self::set_fields( $fields );
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_extra_fields() {
		$fields = [
			'display_go_to_top_button' => [
				'type'              => 'toggle',
				'section'           => 'go_to_top_button_section',
				'label'             => __( 'Display Go to top button', 'shapla' ),
				'description'       => __( 'Enable it to display Go to Top button.', 'shapla' ),
				'default'           => true,
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 10,
			],
			'show_structured_data'     => [
				'type'              => 'toggle',
				'section'           => 'structured_data_section',
				'label'             => __( 'Enable Structured Data', 'shapla' ),
				'description'       => __( 'Structured Data helps search engine to understand the content of a web page. You may disable it if you are already using a SEO plugin.', 'shapla' ),
				'default'           => true,
				'sanitize_callback' => [ '\Shapla\Helpers\Sanitize', 'checked' ],
				'priority'          => 10,
			],
		];
		self::set_fields( $fields );
	}

	/**
	 * Register layout fields
	 *
	 * @return void
	 */
	private static function register_woocommerce_fields() {
		$fields = [
			'wc_products_per_page' => [
				'type'        => 'range-slider',
				'section'     => 'shapla_woocommerce_section',
				'label'       => __( 'Products per page', 'shapla' ),
				'description' => __( 'Change number of products displayed per page', 'shapla' ),
				'default'     => shapla_default_options( 'wc_products_per_page' ),
				'priority'    => 10,
				'input_attrs' => [
					'min'  => 1,
					'max'  => 120,
					'step' => 1,
				],
			],
			'wc_products_per_row'  => [
				'type'        => 'range-slider',
				'section'     => 'shapla_woocommerce_section',
				'label'       => __( 'Products per row', 'shapla' ),
				'description' => __( 'Change number of products displayed per row', 'shapla' ),
				'default'     => shapla_default_options( 'wc_products_per_row' ),
				'priority'    => 20,
				'input_attrs' => [
					'min'  => 3,
					'max'  => 6,
					'step' => 1,
				],
			],
			'show_cart_icon'       => [
				'type'        => 'toggle',
				'section'     => 'shapla_woocommerce_section',
				'label'       => __( 'Show Cart Icon', 'shapla' ),
				'description' => __( 'Check to show cart icon on navigation bar in header area.', 'shapla' ),
				'default'     => shapla_default_options( 'show_cart_icon' ),
				'priority'    => 30,
			],
		];
		self::set_fields( $fields );
	}
}
