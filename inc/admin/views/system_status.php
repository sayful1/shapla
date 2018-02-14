<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$wp_env         = Shapla_System_Status::wp_environment();
$server_env     = Shapla_System_Status::server_environment();
$active_plugins = Shapla_System_Status::active_plugins();
$_count_plugins = count( $active_plugins );
?>
<table class="widefat table-shapla-system-status" cellspacing="0">
    <thead>
    <tr>
        <th colspan="3"><?php esc_attr_e( 'WordPress Environment', 'shapla' ); ?></th>
    </tr>
    </thead>
    <tbody>
	<?php
	foreach ( $wp_env as $wp_env_info ) {
		echo '<tr>';
		echo '<td>' . $wp_env_info['title'] . '</td>';
		if ( ! empty( $wp_env_info['desc'] ) ) {
			echo '<td class="help">';
			echo '<a href="#" class="help_tip" data-tip="' . $wp_env_info['desc'] . '">[?]</a>';
			echo '</td>';
		} else {
			echo '<td class="help"></td>';
		}
		echo '<td>' . $wp_env_info['value'] . '</td>';
		echo '</tr>';
	}
	?>
    </tbody>
</table>

<table class="widefat table-shapla-system-status" cellspacing="0">
    <thead>
    <tr>
        <th colspan="3"><?php esc_attr_e( 'Server Environment', 'shapla' ); ?></th>
    </tr>
    </thead>
    <tbody>
	<?php
	foreach ( $server_env as $server_env_info ) {
		echo '<tr>';
		echo '<td>' . $server_env_info['title'] . '</td>';
		if ( ! empty( $server_env_info['desc'] ) ) {
			echo '<td class="help">';
			echo '<a href="#" class="help_tip" data-tip="' . $server_env_info['desc'] . '">[?]</a>';
			echo '</td>';
		} else {
			echo '<td class="help"></td>';
		}
		echo '<td>' . $server_env_info['value'] . '</td>';
		echo '</tr>';
	}
	?>
    </tbody>
</table>

<?php if ( $_count_plugins > 0 ): ?>
    <table class="widefat table-shapla-system-status" cellspacing="0">
        <thead>
        <tr>
            <th colspan="3"><?php esc_attr_e( 'Active Plugins', 'shapla' ); ?></th>
        </tr>
        </thead>
        <tbody>
		<?php
		foreach ( $active_plugins as $_plugin ) {
			// Link the plugin name to the plugin url if available.
			$plugin_name = esc_html( $_plugin['Name'] );
			if ( ! empty( $_plugin['PluginURI'] ) ) {
				$plugin_name = '<a target="_blank" href="' . esc_url( $_plugin['PluginURI'] ) . '" title="' . __( 'Visit plugin homepage', 'shapla' ) . '">' . esc_html( $_plugin['Name'] ) . '</a>';
			}

			echo '<tr>';
			echo '<td>' . wp_kses_post( $plugin_name ) . '</td>';
			echo '<td class="help">&nbsp;</td>';
			echo '<td>' . wp_kses_post( sprintf( esc_attr__( 'by %s', 'shapla' ), '<a href="' . esc_url( $_plugin['AuthorURI'] ) . '" target="_blank">' . esc_html( $_plugin['AuthorName'] ) . '</a>' ) . ' &ndash; ' . esc_html( $_plugin['Version'] ) ) . '</td>';
			echo '</tr>';
		}
		?>
        </tbody>
    </table>
<?php endif; ?>

