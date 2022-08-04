<?php

namespace Shapla\Helpers;

class SvgIcon {
	/**
	 * User Interface icons – svg sources.
	 *
	 * @var array
	 */
	protected static $icons = [
		'search'        => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" fill="currentColor"/></svg>',
		'shopping_cart' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" fill="currentColor"/></svg>',
		'close'         => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" fill="currentColor"/></svg>',
		'arrow_forward' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8-8-8z" fill="currentColor"/></svg>',
		'menu'          => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" fill="currentColor"/></svg>',
	];

	/**
	 * Social Icons – svg sources.
	 *
	 * @var array
	 */
	protected static $social_icons = [];

	/**
	 * Gets the SVG code for a given icon.
	 *
	 * @static
	 *
	 * @param string $group The icon group.
	 * @param string $icon The icon.
	 * @param int $size The icon-size in pixels.
	 *
	 * @return string
	 */
	public static function get_svg( $group, $icon, $size ) {
		if ( 'ui' === $group ) {
			$arr = self::$icons;
		} elseif ( 'social' === $group ) {
			$arr = self::$social_icons;
		} else {
			$arr = array();
		}

		/**
		 * Filters array of icons.
		 *
		 * The dynamic portion of the hook name, `$group`, refers to
		 * the name of the group of icons, either "ui" or "social".
		 *
		 * @param array $arr Array of icons.
		 */
		$arr = apply_filters( "shapla_svg_icons_{$group}", $arr );

		$svg = '';
		if ( array_key_exists( $icon, $arr ) ) {
			$repl = sprintf( '<svg class="svg-icon" width="%d" height="%d" aria-hidden="true" role="img" focusable="false" ', $size, $size );

			$svg = preg_replace( '/^<svg /', $repl, trim( $arr[ $icon ] ) ); // Add extra attributes to SVG code.
		}

		return $svg;
	}
}
