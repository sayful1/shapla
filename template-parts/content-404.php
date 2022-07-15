<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Shapla
 */
?>
<section class="error-404 not-found">
	<div class="page-content">
		<?php
		echo '<p>';
		esc_html_e(
				'It looks like nothing was found at this location. Maybe try one of the links below or a search?',
				'shapla'
		);
		echo '</p>';

		get_search_form();

		the_widget( 'WP_Widget_Recent_Posts' );

		/* translators: %1$s: smiley */
		$archive_content = '<p>' . sprintf(
						esc_html__(
								'Try looking in the monthly archives. %1$s',
								'shapla'
						),
						convert_smilies( ':)' )
				) . '</p>';
		the_widget(
				'WP_Widget_Archives',
				array( 'dropdown' => true ),
				array( 'after_title' => '</h2>' . $archive_content )
		);

		the_widget( 'WP_Widget_Tag_Cloud' );
		?>
	</div><!-- .page-content -->
</section><!-- .error-404 -->
