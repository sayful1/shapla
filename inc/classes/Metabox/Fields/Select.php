<?php

namespace Shapla\Metabox\Fields;

class Select extends Base {

	/**
	 * @inheritDoc
	 */
	public function render() {
		$value   = $this->get_value();
		$choices = (array) $this->get_setting( 'choices', [] );

		$html = '<select ' . $this->build_attributes() . ' >';
		foreach ( $choices as $option_value => $label ) {
			$selected = ( $value == $option_value ) ? ' selected="selected"' : '';
			$html     .= '<option value="' . esc_attr( $option_value ) . '" ' . $selected . '>' . esc_html( $label ) . '</option>';
		}
		$html .= '</select>';

		return $html;
	}
}
