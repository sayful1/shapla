<?php

namespace Shapla\Metabox\Fields;

defined( 'ABSPATH' ) || exit;

class Sidebar extends Base {

	/**
	 * @inheritDoc
	 */
	public function render() {
		global $wp_registered_sidebars;
		$value = $this->get_value();
		$name  = $this->get_name();

		$html = '<select name="' . $name . '">';
		$html .= '<option value="">' . esc_attr__( 'Default', 'shapla' ) . '</option>';
		foreach ( $wp_registered_sidebars as $key => $option ) {
			$selected = ( $value == $key ) ? ' selected="selected"' : '';
			$html     .= '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_attr( $option['name'] ) . '</option>';
		}
		$html .= '</select>';

		return $html;
	}
}
