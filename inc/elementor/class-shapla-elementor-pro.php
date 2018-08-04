<?php
/**
 * Elementor Compatibility File.
 *
 * @package Shapla
 */

// If plugin - 'Elementor' not exist then return.
if ( ! class_exists( '\Elementor\Plugin' ) || ! class_exists( '\ElementorPro\Modules\ThemeBuilder\Module' ) ) {
	return;
}

use ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager;
use ElementorPro\Modules\ThemeBuilder\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Shapla_Elementor_Pro' ) ) {
	/**
	 * Astra Elementor Compatibility
	 *
	 * @since 1.4.5
	 */
	class Shapla_Elementor_Pro {

		private static $instance;

		/**
		 * @return Shapla_Elementor_Pro
		 */
		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				// Add locations.
				add_action( 'elementor/theme/register_locations', array( self::$instance, 'register_locations' ) );

				// Override theme templates.
				add_action( 'shapla_header', array( self::$instance, 'do_header' ), 0 );
				add_action( 'shapla_footer', array( self::$instance, 'do_footer' ), 0 );
				add_action( 'shapla_404_page_content', array( self::$instance, 'do_template_part_404' ), 0 );
				add_action( 'shapla_single_post_content', array( self::$instance, 'do_template_part_single' ), 0 );
				add_action( 'shapla_archive_page_content', array( self::$instance, 'do_template_part_archive' ), 0 );
			}

			return self::$instance;
		}

		/**
		 * Register Locations
		 *
		 * @param Locations_Manager $manager Location manager.
		 *
		 * @return void
		 */
		public function register_locations( $manager ) {
			$manager->register_all_core_location();
		}

		/**
		 * Header Support
		 *
		 * @return void
		 */
		public function do_header() {
			$did_location = Module::instance()->get_locations_manager()->do_location( 'header' );
			if ( $did_location ) {
				remove_action( 'shapla_header', 'shapla_header_markup', 10 );
			}
		}

		/**
		 * Footer Support
		 *
		 * @return void
		 */
		public function do_footer() {
			$did_location = Module::instance()->get_locations_manager()->do_location( 'footer' );
			if ( $did_location ) {
				remove_action( 'shapla_footer', 'shapla_footer_markup', 10 );
			}
		}

		/**
		 * Override 404 page
		 *
		 * @return void
		 */
		public function do_template_part_404() {
			if ( is_404() ) {
				$did_location = Module::instance()->get_locations_manager()->do_location( 'single' );
				if ( $did_location ) {
					remove_action( 'shapla_404_page_content', 'shapla_404_page_content', 10 );
				}
			}
		}

		/**
		 * Override single post template
		 *
		 * @return void
		 */
		public function do_template_part_single() {
			if ( is_single() ) {
				$did_location = Module::instance()->get_locations_manager()->do_location( 'single' );
				if ( $did_location ) {
					remove_action( 'shapla_single_post_content', 'shapla_single_post_content', 10 );
				}
			}
		}

		/**
		 * Override archive page template
		 *
		 * @return void
		 */
		public function do_template_part_archive() {
			$did_location = Module::instance()->get_locations_manager()->do_location( 'archive' );
			if ( $did_location ) {
				remove_action( 'shapla_archive_page_content', 'shapla_archive_page_content', 10 );
			}
		}
	}
}

return Shapla_Elementor_Pro::init();
