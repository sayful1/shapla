<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_Admin' ) ):

	class Shapla_Admin {

		private static $instance;
		private $admin_path;
		private $admin_uri;
		private $tabs = array();

		/**
		 * @return Shapla_Admin
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Shapla_Admin constructor.
		 */
		public function __construct() {
			add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
			add_action( 'admin_menu', array( $this, 'shapla_admin_menu_page' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'admin_print_footer_scripts', array( $this, 'admin_inline_scripts' ), 90 );

			/* activation notice */
			add_action( 'load-themes.php', array( $this, 'activation_admin_notice' ) );

			$this->admin_path = get_template_directory() . '/inc/admin/';
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
			echo '<p>' . esc_html__( 'Welcome! Thank you for choosing Shapla! To fully take advantage of the best our theme can offer please make sure you visit our ',
					'shapla' ) . '</p>';
			echo '<p>';
			echo '<a href="' . $welcome_url . '" class="button button-primary">' . esc_html__( 'About Shapla',
					'shapla' ) . '</a>';
			echo '<a href="' . $customize_url . '" class="button button-default" style="margin-left: 5px;">' . esc_html__( 'Start Customize',
					'shapla' ) . '</a>';
			echo '</p>';
			echo '</div>';
		}

		/**
		 * Inline scripts for admin page
		 */
		public function admin_inline_scripts() {
			global $hook_suffix;
			if ( $hook_suffix != 'appearance_page_shapla-welcome' ) {
				return;
			}
			?>
            <script type="text/javascript">
                (function ($) {
                    'use strict';
                    // Initializing TipTip
                    $(".help_tip").each(function () {
                        $(this).tipTip({
                            attribute: "data-tip"
                        });
                    });
                })(jQuery);
            </script>
			<?php
		}

		/**
		 * Load theme page scripts
		 *
		 * @param $hook_suffix
		 */
		public function admin_scripts( $hook_suffix ) {
			if ( $hook_suffix != 'appearance_page_shapla-welcome' ) {
				return;
			}

			$assets_url = get_template_directory_uri() . '/assets';

			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script(
				'jquery-tiptip',
				$assets_url . '/libs/jquery-tiptip/jquery.tipTip.js',
				array( 'jquery' ),
				'1.3',
				false
			);
			wp_enqueue_style( 'shapla-admin-style', get_template_directory_uri() . '/assets/css/admin.css' );
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

			$footer_text = sprintf( esc_html__( 'If you like %1$s Shapla %2$s please leave us a %3$s rating. A huge thanks in advance!',
				'shapla' ), '<strong>', '</strong>',
				'<a href="https://wordpress.org/support/theme/shapla/reviews/?filter=5" target="_blank" data-rated="Thanks :)">&starf;&starf;&starf;&starf;&starf;</a>' );

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
			$ThemeURI         = $theme->get( 'ThemeURI' );
			$template_path    = $this->admin_path . 'views';

			$welcome_title   = sprintf( __( 'Welcome to %s!', 'shapla' ), $ThemeName );
			$welcome_version = sprintf( __( 'Version %s', 'shapla' ), $ThemeVersion );

			$tab = isset( $_GET['tab'] ) ? wp_unslash( $_GET['tab'] ) : 'getting_started';

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
			foreach ( $this->tabs() as $tab_key => $tab_name ) {
				echo '<a href="' . esc_url( admin_url( 'themes.php?page=shapla-welcome' ) ) . '&tab=' . $tab_key . '" class="nav-tab ' . ( $tab == $tab_key ? 'nav-tab-active' : '' ) . '" role="tab" data-toggle="tab">';
				echo esc_html( $tab_name );
				echo '</a>';
			}
			echo '</h2>';

			// Display content for current tab
			switch ( $tab ) {
				case 'changelog':
					$template = $template_path . '/changelog.php';
					break;

				case 'system_status':
					$template = $template_path . '/system_status.php';
					break;

				case 'recommended_plugins':
					$template = $template_path . '/recommended_plugins.php';
					break;

				case 'getting_started':
				default:
					$template = $template_path . '/getting_started.php';
					break;
			}

			if ( file_exists( $template ) ) {
				include $template;
			}

			echo '</div><!--/.wrap.about-wrap-->';
		}

		private function tabs() {
			$this->tabs = array(
				'getting_started'     => __( 'Getting Started', 'shapla' ),
				'recommended_plugins' => __( 'Useful Plugins', 'shapla' ),
				'changelog'           => __( 'Change log', 'shapla' ),
				'system_status'       => __( 'System Status', 'shapla' ),
			);

			return $this->tabs;
		}

		/**
		 * Retrieves plugin installer pages from the WordPress.org Plugins API.
		 *
		 * @param $slug
		 *
		 * @return array|mixed|object|WP_Error
		 */
		public function call_plugin_api( $slug ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

			$call_api = get_transient( 'shapla_about_plugin_info_' . $slug );

			if ( false === $call_api ) {
				$call_api = plugins_api( 'plugin_information', array(
						'slug'   => $slug,
						'fields' => array(
							'downloaded'        => false,
							'rating'            => false,
							'description'       => false,
							'short_description' => true,
							'donate_link'       => false,
							'tags'              => false,
							'sections'          => true,
							'homepage'          => true,
							'added'             => false,
							'last_updated'      => false,
							'compatibility'     => false,
							'tested'            => false,
							'requires'          => false,
							'downloadlink'      => false,
							'icons'             => true,
						),
					)
				);
				set_transient( 'shapla_about_plugin_info_' . $slug, $call_api, HOUR_IN_SECONDS );
			}

			return $call_api;
		}

		/**
		 * Get icon of wordpress.org plugin
		 *
		 * @param array $arr array of image formats.
		 *
		 * @return mixed
		 */
		public function get_plugin_icon( $arr ) {

			if ( ! empty( $arr['svg'] ) ) {
				$plugin_icon_url = $arr['svg'];
			} elseif ( ! empty( $arr['2x'] ) ) {
				$plugin_icon_url = $arr['2x'];
			} elseif ( ! empty( $arr['1x'] ) ) {
				$plugin_icon_url = $arr['1x'];
			} else {
				$plugin_icon_url = get_template_directory_uri() . '/assets/images/placeholder_plugin.png';
			}

			return $plugin_icon_url;
		}

		/**
		 * Check if plugin is active
		 *
		 * @param array $slug the plugin slug.
		 *
		 * @return array
		 */
		public function check_if_plugin_active( $slug ) {

			$plugin = $slug['directory'] . DIRECTORY_SEPARATOR . $slug['file'];

			$path = WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . $plugin;
			if ( ! file_exists( $path ) ) {
				$path = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $plugin;
				if ( ! file_exists( $path ) ) {
					$path = false;
				}
			}

			if ( file_exists( $path ) ) {

				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

				$needs = is_plugin_active( $plugin ) ? 'deactivate' : 'activate';

				return array(
					'status' => is_plugin_active( $plugin ),
					'needs'  => $needs,
				);
			}

			return array(
				'status' => false,
				'needs'  => 'install',
			);
		}

		/**
		 * Function that crates the action link for install/activate/deactivate.
		 *
		 * @param string $state the plugin state (uninstalled/active/inactive).
		 * @param array $plugin_info
		 *
		 * @return string
		 *
		 */
		public function create_action_link( $state, $plugin_info ) {

			$slug             = $plugin_info['directory'];
			$plugin_root_file = $plugin_info['file'];
			$plugin           = $slug . DIRECTORY_SEPARATOR . $plugin_root_file;

			switch ( $state ) {
				case 'install':
					return wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => $slug,
							),
							network_admin_url( 'update.php' )
						),
						'install-plugin_' . $slug
					);
					break;
				case 'deactivate':
					return add_query_arg(
						array(
							'action'        => 'deactivate',
							'plugin'        => rawurlencode( $plugin ),
							'plugin_status' => 'all',
							'paged'         => '1',
							'_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $plugin ),
						), network_admin_url( 'plugins.php' )
					);
					break;
				case 'activate':
					return add_query_arg(
						array(
							'action'        => 'activate',
							'plugin'        => rawurlencode( $plugin ),
							'plugin_status' => 'all',
							'paged'         => '1',
							'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $plugin ),
						), network_admin_url( 'plugins.php' )
					);
					break;
			}// End switch().
		}

		/**
		 * Get ThikBox URL for a plugin
		 *
		 * @param string $plugin_directory
		 *
		 * @return string
		 */
		public function plugin_thickbox_url( $plugin_directory ) {
			return add_query_arg( array(
				'tab'       => 'plugin-information',
				'plugin'    => $plugin_directory,
				'TB_iframe' => 'true',
			), admin_url( 'plugin-install.php' ) );
		}
	}


endif;

Shapla_Admin::init();
