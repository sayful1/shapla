<?php

namespace Shapla\Helpers;

use WP_Error;

/**
 * AdminUtils class
 */
class AdminUtils {
	/**
	 * Retrieves plugin installer pages from the WordPress.org Plugins API.
	 *
	 * @param $slug
	 *
	 * @return object|WP_Error
	 */
	public static function plugin_api( $slug ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

		$call_api = get_transient( 'shapla_about_plugin_info_' . $slug );

		if ( false === $call_api ) {
			$call_api = plugins_api( 'plugin_information',
				[
					'slug'   => $slug,
					'fields' => [
						'short_description' => true,
						'sections'          => true,
						'homepage'          => true,
						'icons'             => true,
						'downloaded'        => false,
						'rating'            => false,
						'description'       => false,
						'donate_link'       => false,
						'tags'              => false,
						'added'             => false,
						'last_updated'      => false,
						'compatibility'     => false,
						'tested'            => false,
						'requires'          => false,
						'downloadlink'      => false,
					],
				]
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
	public static function get_plugin_icon( $arr ) {
		if ( ! empty( $arr['svg'] ) ) {
			$plugin_icon_url = $arr['svg'];
		} elseif ( ! empty( $arr['2x'] ) ) {
			$plugin_icon_url = $arr['2x'];
		} elseif ( ! empty( $arr['1x'] ) ) {
			$plugin_icon_url = $arr['1x'];
		} else {
			$plugin_icon_url = get_template_directory_uri() . '/assets/static-images/placeholder.svg';
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
	public static function is_plugin_active( $slug ) {
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

			return [
				'status' => is_plugin_active( $plugin ),
				'needs'  => $needs,
			];
		}

		return [
			'status' => false,
			'needs'  => 'install',
		];
	}

	/**
	 * Function that crates the action link for install/activate/deactivate.
	 *
	 * @param string $state the plugin state (uninstalled/active/inactive).
	 * @param array $plugin_info
	 *
	 * @return string
	 */
	public static function create_action_link( $state, $plugin_info ) {
		$slug   = $plugin_info['directory'];
		$plugin = $slug . DIRECTORY_SEPARATOR . $plugin_info['file'];

		if ( 'install' === $state ) {
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
		}

		if ( 'deactivate' === $state ) {
			return add_query_arg(
				array(
					'action'        => 'deactivate',
					'plugin'        => rawurlencode( $plugin ),
					'plugin_status' => 'all',
					'paged'         => '1',
					'_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $plugin ),
				), network_admin_url( 'plugins.php' )
			);
		}

		if ( 'activate' === $state ) {
			return add_query_arg(
				array(
					'action'        => 'activate',
					'plugin'        => rawurlencode( $plugin ),
					'plugin_status' => 'all',
					'paged'         => '1',
					'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $plugin ),
				), network_admin_url( 'plugins.php' )
			);
		}

		return '';
	}

	/**
	 * Get ThickBox URL for a plugin
	 *
	 * @param string $plugin_directory
	 *
	 * @return string
	 */
	public static function plugin_thickbox_url( $plugin_directory ) {
		return add_query_arg( array(
			'tab'       => 'plugin-information',
			'plugin'    => $plugin_directory,
			'TB_iframe' => 'true',
		), admin_url( 'plugin-install.php' ) );
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	public static function parse_changelog( $string ) {
		$html = '';
		$logs = explode( "####", $string );
		foreach ( $logs as $_log ) {
			if ( empty( $_log ) ) {
				continue;
			}
			$log = explode( '*', $_log );
			if ( count( $log ) < 2 ) {
				continue;
			}

			$html .= '<table class="widefat table-shapla-changelog">';
			$html .= '<thead><tr><th>' . esc_html( $log[0] ) . '</th></tr></thead>';
			$html .= '<tbody><tr><td><ul>';
			foreach ( $log as $log_num => $log_info ) {
				if ( 0 == $log_num ) {
					continue;
				}
				$html .= '<li>' . esc_html( $log_info ) . '</li>';
			}
			$html .= '</ul></td></tr></tbody>';
			$html .= '</table>';
		}

		return $html;
	}
}
