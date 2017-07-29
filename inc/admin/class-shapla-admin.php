<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_Admin' ) ):

	class Shapla_Admin {

		private $admin_path;
		private $admin_uri;

		public function __construct() {
			add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
			add_action( 'admin_menu', array( $this, 'shapla_admin_menu_page' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

			$this->admin_path = get_template_directory() . '/inc/admin/';
		}

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
		 */
		public function admin_footer_text( $text ) {
			global $hook_suffix;

			$footer_text = sprintf( esc_html__( 'If you like %1$s Shapla %2$s please leave us a %3$s rating. A huge thanks in advance!', 'shapla' ), '<strong>', '</strong>', '<a href="https://wordpress.org/support/theme/shapla/reviews/?filter=5" target="_blank" data-rated="Thanks :)">&starf;&starf;&starf;&starf;&starf;</a>' );

			if ( $hook_suffix == 'appearance_page_shapla-welcome' ) {
				return $footer_text;
			}

			return $text;
		}

		public function shapla_admin_menu_page() {
			add_theme_page(
				__( 'Shapla', 'shapla' ),
				__( 'Shapla', 'shapla' ),
				'manage_options',
				'shapla-welcome',
				array( $this, 'welcome_page_callback' )
			);
		}

		public function welcome_page_callback() {
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
	}

	new Shapla_Admin();

endif;