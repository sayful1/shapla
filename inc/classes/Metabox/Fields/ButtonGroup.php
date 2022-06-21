<?php

namespace Shapla\Metabox\Fields;

defined( 'ABSPATH' ) || exit;

class ButtonGroup extends Base {

	/**
	 * @inheritDoc
	 */
	public function render() {
		$value = $this->get_value();
		$name  = $this->get_name();

		$html = '<div id="' . esc_attr( $this->get_setting( 'id' ) ) . '" class="buttonset">';
		foreach ( $this->get_setting( 'choices' ) as $key => $title ) {
			$id          = sprintf( '%s-%s', $this->get_setting( 'id' ), $key );
			$label_class = sprintf( 'switch-label switch-label-%s', ( $key == $value ) ? 'on' : 'off' );
			$radio_attr  = array(
				'type'    => 'radio',
				'name'    => $name,
				'id'      => $id,
				'class'   => 'switch-input screen-reader-text',
				'value'   => $key,
				'checked' => $key == $value,
			);
			$html       .= '<input ' . $this->array_to_attributes( $radio_attr ) . ' />';
			$html       .= '<label class="' . esc_attr( $label_class ) . '" for="' . esc_attr( $id ) . '">' . esc_html( $title ) . '</label>';
		}

		$html .= '</div>';

		return $html;
	}
}
