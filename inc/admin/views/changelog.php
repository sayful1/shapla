<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

ob_start();
$file_path = get_template_directory() . '/CHANGELOG.md';
include $file_path;
$homepage = ob_get_clean();

$logs = explode( "####", $homepage );
foreach ( $logs as $_log ) {
	if ( empty( $_log ) ) {
		continue;
	}
	$log = explode( '*', $_log );
	if ( count( $log ) < 2 ) {
		continue;
	}

	echo '<table class="widefat table-shapla-changelog">';
	echo '<thead><tr><th>' . esc_attr( $log[0] ) . '</th></tr></thead>';
	echo '<tbody><tr><td><ul>';
	foreach ( $log as $log_num => $log_info ) {
		if ( 0 == $log_num ) {
			continue;
		}
		echo '<li>' . esc_attr( $log_info ) . '</li>';
	}
	echo '</ul></td></tr></tbody>';
	echo '</table>';
}
