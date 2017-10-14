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

			$this->admin_path = get_template_directory() . '/inc/admin/';
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

			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'thickbox' );
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

			$footer_text = sprintf( esc_html__( 'If you like %1$s Shapla %2$s please leave us a %3$s rating. A huge thanks in advance!', 'shapla' ), '<strong>', '</strong>', '<a href="https://wordpress.org/support/theme/shapla/reviews/?filter=5" target="_blank" data-rated="Thanks :)">&starf;&starf;&starf;&starf;&starf;</a>' );

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
				__( 'About Shapla', 'shapla' ),
				__( 'About Shapla', 'shapla' ),
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

			$welcome_title = sprintf( __( 'Welcome to %s! - Version %s', 'shapla' ), $ThemeName, $ThemeVersion );

			$tab = isset( $_GET['tab'] ) ? wp_unslash( $_GET['tab'] ) : 'getting_started';

			echo '<div class="wrap about-wrap shapla-wrap">';

			if ( ! empty( $welcome_title ) ) {
				echo '<h1>' . esc_html( $welcome_title ) . '</h1>';
			}

			if ( ! empty( $ThemeDescription ) ) {
				echo '<div class="about-text">' . wp_kses_post( $ThemeDescription ) . '</div>';
			}

			echo '<a href="' . $ThemeURI . '" target="_blank" class="wp-badge shapla-welcome-logo"></a>';

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
				case 'add':
					$template = $template_path . 'add.php';
					break;

				case 'edit':
					$template = $template_path . 'edit.php';
					break;

				case 'getting_started':
					$template = $template_path . '/getting_started.php';
					break;
				default:
					$template = $template_path . '/getting_started.php';
					break;
			}

			if ( file_exists( $template ) ) {
				ob_start();
				include $template;
				echo ob_get_clean();
			}

			echo '</div><!--/.wrap.about-wrap-->';
			return;
			?>
            <div class="columns">
                <div class="column is-8">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
								<?php esc_html_e( 'Shapla Features', 'shapla' ); ?>
                            </p>
                        </header>
                        <div class="card-content">
							<?php require $this->admin_path . '/views/features.php'; ?>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
					<?php require $this->admin_path . '/views/supports.php'; ?>
                </div>
            </div>
			<?php
		}

		private function tabs() {
			$this->tabs = array(
				'getting_started'     => __( 'Getting Started', 'shapla' ),
				'recommended_plugins' => __( 'Useful Plugins', 'shapla' ),
			);

			return $this->tabs;
		}
	}


endif;

Shapla_Admin::init();
