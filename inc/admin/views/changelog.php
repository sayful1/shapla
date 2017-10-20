<?php

ob_start();
$file_path = get_template_directory() . '/CHANGELOG.md';
include $file_path;
$homepage = ob_get_clean();

echo '<div class="shapla-changelog" style="background: white;margin: 1rem 0;padding: 1rem;">';
echo nl2br( $homepage );
echo '</div>';
