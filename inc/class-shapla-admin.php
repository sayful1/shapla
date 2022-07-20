<?php

use Shapla\Helpers\AdminUtils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_Admin' ) ) {

	class Shapla_Admin {

		private static $instance;

		/**
		 * @return Shapla_Admin
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				add_filter( 'admin_footer_text', array( self::$instance, 'admin_footer_text' ) );
				add_action( 'admin_menu', array( self::$instance, 'shapla_admin_menu_page' ) );
				add_action( 'admin_enqueue_scripts', array( self::$instance, 'admin_scripts' ) );

				/* activation notice */
				add_action( 'load-themes.php', array( self::$instance, 'activation_admin_notice' ) );

				add_action( 'init', array( self::$instance, 'add_meta_boxes' ) );
			}

			return self::$instance;
		}

		/**
		 * Adds the meta box container.
		 */
		public function add_meta_boxes() {
			$options = array(
				'id'       => 'shapla-page-options',
				'title'    => __( 'Shapla Settings', 'shapla' ),
				'screen'   => array( 'page', 'post', 'product' ),
				'context'  => 'side',
				'priority' => 'low',
				'fields'   => array(
					array(
						'type'        => 'spacing',
						'id'          => 'page_content_padding',
						'label'       => __( 'Content Padding', 'shapla' ),
						'description' => __( 'Leave empty to use value from theme options.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'page_section',
						'default'     => array(
							'top'    => '',
							'bottom' => '',
						),
						'output'      => array(
							array(
								'element'  => array(
									'.site-content .content-area',
									'.site-content .widget-area',
								),
								'property' => 'padding',
							),
						),
					),
					array(
						'type'        => 'buttonset',
						'id'          => 'interior_content_width',
						'label'       => __( 'Interior Content Width', 'shapla' ),
						'description' => __( '"100% Width" will take all screen width. Useful when using page builder like Elementor. On block editor, only certain blocks takes 100% width.', 'shapla' ),
						'priority'    => 15,
						'section'     => 'page_section',
						'default'     => 'site-width',
						'choices'     => array(
							'site-width' => __( 'Site Width', 'shapla' ),
							'full-width' => __( '100% Width', 'shapla' ),
						),
					),
					array(
						'type'        => 'select',
						'id'          => 'sidebar_position',
						'label'       => __( 'Sidebar Position', 'shapla' ),
						'description' => __( 'Controls sidebar position for current page.', 'shapla' ),
						'priority'    => 10,
						'section'     => 'sidebar_section',
						'default'     => 'default',
						'choices'     => array(
							'default'       => __( 'Default', 'shapla' ),
							'left-sidebar'  => __( 'Left', 'shapla' ),
							'right-sidebar' => __( 'Right', 'shapla' ),
							'full-width'    => __( 'Disabled', 'shapla' ),
						),
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
						),
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
						),
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
						),
					),
					array(
						'type'        => 'buttonset',
						'id'          => 'transparent_header',
						'label'       => __( 'Transparent Header', 'shapla' ),
						'description' => __( 'Show transparent header.', 'shapla' ),
						'priority'    => 30,
						'section'     => 'page_title_bar_section',
						'default'     => 'default',
						'choices'     => array(
							'default' => __( 'Default', 'shapla' ),
							'on'      => __( 'Enable', 'shapla' ),
							'off'     => __( 'Disable', 'shapla' ),
						),
					),
				),
			);

			( new \Shapla\Metabox\ClassicMetabox() )->add( $options );
		}

		/**
		 * Adds an admin notice upon successful activation.
		 */
		public function activation_admin_notice() {

			global $pagenow;
			if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
				add_action( 'admin_notices', array( $this, 'about_page_welcome_admin_notice' ), 99 );
			}
		}

		public function about_page_welcome_admin_notice() {
			$welcome_url   = admin_url( 'themes.php?page=shapla-welcome' );
			$customize_url = admin_url( 'customize.php' );
			echo '<div class="updated notice is-dismissible">';
			echo '<p>' . esc_html__(
					'Welcome! Thank you for choosing Shapla! To fully take advantage of the best our theme can offer please make sure you visit our ',
					'shapla'
				) . '</p>';
			echo '<p>';
			echo '<a href="' . $welcome_url . '" class="button button-primary">' . esc_html__(
					'About Shapla',
					'shapla'
				) . '</a>';
			echo '<a href="' . $customize_url . '" class="button button-default" style="margin-left: 5px;">' . esc_html__(
					'Start Customize',
					'shapla'
				) . '</a>';
			echo '</p>';
			echo '</div>';
		}

		/**
		 * Load theme page scripts
		 */
		public function admin_scripts() {
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'shapla-admin-style', SHAPLA_THEME_URI . '/assets/css/admin.css' );
		}

		/**
		 * Add custom footer text on plugins page.
		 *
		 * @param string $text
		 *
		 * @return string
		 */
		public function admin_footer_text( $text ) {
			global $hook_suffix;

			$footer_text = sprintf(
				esc_html__(
					'If you like %1$s Shapla %2$s please leave us a %3$s rating. A huge thanks in advance!',
					'shapla'
				),
				'<strong>',
				'</strong>',
				'<a href="https://wordpress.org/support/theme/shapla/reviews/?filter=5" target="_blank" data-rated="Thanks :)">&starf;&starf;&starf;&starf;&starf;</a>'
			);

			if ( $hook_suffix == 'appearance_page_shapla-welcome' ) {
				return $footer_text;
			}

			return $text;
		}

		/**
		 * Add theme page
		 */
		public function shapla_admin_menu_page() {
			add_theme_page(
				__( 'Shapla', 'shapla' ),
				__( 'Shapla', 'shapla' ),
				'manage_options',
				'shapla-welcome',
				array( $this, 'welcome_page_callback' )
			);
		}

		/**
		 * Theme page callback
		 */
		public function welcome_page_callback() {
			$theme            = wp_get_theme( 'shapla' );
			$ThemeName        = $theme->get( 'Name' );
			$ThemeVersion     = $theme->get( 'Version' );
			$ThemeDescription = $theme->get( 'Description' );

			$welcome_title   = sprintf( __( 'Welcome to %s!', 'shapla' ), $ThemeName );
			$welcome_version = sprintf( __( 'Version %s', 'shapla' ), $ThemeVersion );

			$tabs = array(
				'getting_started'     => __( 'Getting Started', 'shapla' ),
				'recommended_plugins' => __( 'Useful Plugins', 'shapla' ),
				'changelog'           => __( 'Change log', 'shapla' ),
			);
			$tab  = isset( $_GET['tab'] ) ? wp_unslash( $_GET['tab'] ) : 'getting_started';

			echo '<div class="wrap about-wrap shapla-about-wrap">';

			if ( ! empty( $welcome_title ) ) {
				echo '<h1>' . esc_html( $welcome_title ) . '</h1>';
			}

			if ( ! empty( $ThemeDescription ) ) {
				echo '<div class="about-text">' . wp_kses_post( $ThemeDescription ) . '</div>';
			}

			echo '<div class="wp-badge shapla-welcome-logo">' . $welcome_version . '</div>';

			// Tabs
			echo '<h2 class="nav-tab-wrapper wp-clearfix">';
			foreach ( $tabs as $tab_key => $tab_name ) {
				echo '<a href="' . esc_url( admin_url( 'themes.php?page=shapla-welcome' ) ) . '&tab=' . $tab_key . '" class="nav-tab ' . ( $tab == $tab_key ? 'nav-tab-active' : '' ) . '" role="tab" data-toggle="tab">';
				echo esc_html( $tab_name );
				echo '</a>';
			}
			echo '</h2>';

			// Display content for current tab
			switch ( $tab ) {
				case 'changelog':
					$file_path = file_get_contents( SHAPLA_THEME_PATH . '/CHANGELOG.md' );
					echo AdminUtils::parse_changelog( $file_path );
					break;

				case 'recommended_plugins':
					echo '<div class="shapla-about-content">';
					self::recommended_plugins_html();
					echo '</div>';
					break;

				case 'getting_started':
				default:
					echo '<div class="shapla-about-content">';
					echo self::getting_started_html();
					echo '</div>';
					break;
			}

			echo '</div><!--/.wrap.about-wrap-->';
		}

		private static function getting_started_html() {
			$contents = array(
				array(
					'title'       => __( 'Go to the Customizer', 'shapla' ),
					'description' => array(
						__( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'shapla' ),
					),
					'action'      => array(
						'text' => __( 'Go to the Customizer', 'shapla' ),
						'url'  => admin_url( 'customize.php' ),
					),
				),
				array(
					'title'       => __( 'Get support', 'shapla' ),
					'description' => array(
						__( 'If you need support, you can try posting on the theme support forum.', 'shapla' ),
					),
					'action'      => array(
						'text' => __( 'Visit support forum', 'shapla' ),
						'url'  => 'https://wordpress.org/support/theme/shapla',
					),
				),
				array(
					'title'       => __( 'Contribute to Shapla', 'shapla' ),
					'description' => array(
						__( 'Would you like to translate Shapla into your language? You can get involved on WordPress.org', 'shapla' ),
					),
					'action'      => array(
						'text' => __( 'Translate Shapla', 'shapla' ),
						'url'  => 'https://translate.wordpress.org/projects/wp-themes/shapla',
					),
				),
			);

			$html = '<div class="shapla-columns">';
			foreach ( $contents as $content ) {
				$html .= '<div class="shapla-column">';
				$html .= '<h3>' . esc_html( $content['title'] ) . '</h3>';
				foreach ( $content['description'] as $description ) {
					$html .= '<p>' . esc_html( $description ) . '</p>';
				}
				if ( $content['action'] ) {
					$html .= '<p><a target="_blank" href="' . esc_url( $content['action']['url'] ) . '"
					class="button button-primary">' . esc_html( $content['action']['text'] ) . '</a></p>';
				}
				$html .= '</div>';
			}
			$html .= '</div>';

			return $html;
		}

		private static function recommended_plugins_html() {
			$recommended_plugins = [
				[ 'directory' => 'elementor', 'file' => 'class-coblocks.php' ],
				[ 'directory' => 'coblocks', 'file' => 'elementor.php' ],
				[ 'directory' => 'carousel-slider', 'file' => 'carousel-slider.php', ],
				[ 'directory' => 'filterable-portfolio', 'file' => 'filterable-portfolio.php', ],
				[ 'directory' => 'contact-form-7', 'file' => 'wp-contact-form-7.php', ],
				[ 'directory' => 'wordpress-seo', 'file' => 'wp-seo.php', ],
				[ 'directory' => 'woocommerce', 'file' => 'woocommerce.php', ],
				[ 'directory' => 'ti-woocommerce-wishlist', 'file' => 'ti-woocommerce-wishlist.php' ],
				[ 'directory' => 'updraftplus', 'file' => 'updraftplus.php', ],
				[ 'directory' => 'motopress-hotel-booking-lite', 'file' => 'motopress-hotel-booking.php', ],
				[ 'directory' => 'give', 'file' => 'give.php', ],
				[ 'directory' => 'stripe-payments', 'file' => 'accept-stripe-payments.php', ],
			];

			echo '<div class="recommended-plugins shapla-columns is-multiline" id="plugin-filter">';

			foreach ( $recommended_plugins as $recommended_plugin ) {

				$info   = AdminUtils::plugin_api( $recommended_plugin['directory'] );
				$active = AdminUtils::is_plugin_active( $recommended_plugin );
				$icon   = AdminUtils::get_plugin_icon( $info->icons ? $info->icons : array() );
				$url    = AdminUtils::create_action_link( $active['needs'], $recommended_plugin );

				echo '<div class="shapla-column is-4">';
				echo '<div class="shapla-plugin-box">';

				if ( ! empty( $icon ) ) {
					echo '<div class="shapla-plugin-box__image">';
					$plugin_information_url = AdminUtils::plugin_thickbox_url( $recommended_plugin['directory'] );
					echo '<a class="thickbox" href="' . $plugin_information_url . '">';
					echo '<img src="' . esc_url( $icon ) . '" alt="plugin box image">';
					echo '</a>';
					echo '</div>';
				}

				echo '<div class="shapla-plugin-box__info">';
				if ( ! empty( $info->version ) ) {
					echo '<span class="shapla-plugin-box__version">' . esc_html__( 'Version: ', 'shapla' ) . esc_html( $info->version ) . '</span>';
				}

				if ( ! empty( $info->author ) ) {
					echo '<span class="shapla-plugin-box__separator"> | </span>' . wp_kses_post( $info->author );
				}
				echo '</div>';

				if ( ! empty( $info->name ) && ! empty( $active ) ) {
					echo '<div class="shapla-plugin-box__action_bar action_bar ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
					echo '<span class="shapla-plugin-box__plugin_name">' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'Active: ' : '' ) . esc_html( $info->name ) . '</span>';

					$class = '';
					$label = '';

					switch ( $active['needs'] ) {
						case 'install':
							$class = 'install-now button';
							$label = esc_html__( 'Install', 'shapla' );
							break;
						case 'activate':
							$class = 'activate-now button button-primary';
							$label = esc_html__( 'Activate', 'shapla' );
							break;
						case 'deactivate':
							$class = 'deactivate-now button';
							$label = esc_html__( 'Deactivate', 'shapla' );
							break;
					}

					echo '<span class="plugin-card-' . esc_attr( $recommended_plugin['directory'] ) . ' shapla-plugin-box__action_button ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
					echo '<a data-slug="' . esc_attr( $recommended_plugin['directory'] ) . '" class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
					echo '</span>';

					echo '</div>';
				}
				echo '</div><!-- .col.plugin_box -->';
				echo '</div><!-- .shapla-column -->';
			}

			echo '</div>';
		}
	}
}

Shapla_Admin::init();
