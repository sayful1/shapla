<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$recommended_plugins = array(
	'already_activated_message' => esc_html__( 'Already activated', 'shapla' ),
	'version_label'             => esc_html__( 'Version: ', 'shapla' ),
	'install_label'             => esc_html__( 'Install', 'shapla' ),
	'activate_label'            => esc_html__( 'Activate', 'shapla' ),
	'deactivate_label'          => esc_html__( 'Deactivate', 'shapla' ),
	'content'                   => array(
		array(
			'directory' => 'elementor',
			'file'      => 'elementor.php',
		),
		array(
			'directory' => 'carousel-slider',
			'file'      => 'carousel-slider.php',
		),
		array(
			'directory' => 'dialog-contact-form',
			'file'      => 'dialog-contact-form.php',
		),
		array(
			'directory' => 'filterable-portfolio',
			'file'      => 'filterable-portfolio.php',
		),
		array(
			'directory' => 'woocommerce',
			'file'      => 'woocommerce.php',
		),
		array(
			'directory' => 'wordpress-seo',
			'file'      => 'wp-seo.php',
		),
		array(
			'directory' => 'updraftplus',
			'file'      => 'updraftplus.php',
		),
		array(
			'directory' => 'loginizer',
			'file'      => 'loginizer.php',
		),
		array(
			'directory' => 'display-latest-tweets',
			'file'      => 'init.php',
		),
	),
);

echo '<div class="feature-section recommended-plugins three-col demo-import-boxed" id="plugin-filter">';

foreach ( $recommended_plugins['content'] as $recommended_plugins_item ) {

	if ( ! empty( $recommended_plugins_item['directory'] ) ) {

		$info = $this->call_plugin_api( $recommended_plugins_item['directory'] );

		if ( ! empty( $info->icons ) ) {
			$icon = $this->get_plugin_icon( $info->icons );
		}

		$active = $this->check_if_plugin_active( $recommended_plugins_item );

		if ( ! empty( $active['needs'] ) ) {
			$url = $this->create_action_link( $active['needs'], $recommended_plugins_item );
		}

		echo '<div class="col plugin_box">';

		if ( ! empty( $icon ) ) {
			$plugin_information_url = $this->plugin_thickbox_url( $recommended_plugins_item['directory'] );
			echo '<a class="thickbox" href="' . $plugin_information_url . '">';
			echo '<img src="' . esc_url( $icon ) . '" alt="plugin box image">';
			echo '</a>';
		}

		if ( ! empty( $info->version ) ) {
			echo '<span class="version">' . ( ! empty( $recommended_plugins['version_label'] ) ? esc_html( $recommended_plugins['version_label'] ) : '' ) . esc_html( $info->version ) . '</span>';
		}

		if ( ! empty( $info->author ) ) {
			echo '<span class="separator"> | </span>' . wp_kses_post( $info->author );
		}

		if ( ! empty( $info->name ) && ! empty( $active ) ) {
			echo '<div class="action_bar ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
			echo '<span class="plugin_name">' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'Active: ' : '' ) . esc_html( $info->name ) . '</span>';
			echo '</div>';

			$label = '';

			switch ( $active['needs'] ) {
				case 'install':
					$class = 'install-now button';
					if ( ! empty( $recommended_plugins['install_label'] ) ) {
						$label = $recommended_plugins['install_label'];
					}
					break;
				case 'activate':
					$class = 'activate-now button button-primary';
					if ( ! empty( $recommended_plugins['activate_label'] ) ) {
						$label = $recommended_plugins['activate_label'];
					}
					break;
				case 'deactivate':
					$class = 'deactivate-now button';
					if ( ! empty( $recommended_plugins['deactivate_label'] ) ) {
						$label = $recommended_plugins['deactivate_label'];
					}
					break;
			}

			echo '<span class="plugin-card-' . esc_attr( $recommended_plugins_item['directory'] ) . ' action_button ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
			echo '<a data-slug="' . esc_attr( $recommended_plugins_item['directory'] ) . '" class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
			echo '</span>';
		}
		echo '</div><!-- .col.plugin_box -->';
	}
}

echo '</div>';

