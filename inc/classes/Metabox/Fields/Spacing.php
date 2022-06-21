<?php

namespace Shapla\Metabox\Fields;

defined( 'ABSPATH' ) || exit;

class Spacing extends Base {

	/**
	 * @inheritDoc
	 */
	public function render() {
		$default = (array) $this->get_setting( 'default', array() );
		$value   = (array) $this->get_value();
		$name    = $this->get_name();

		$html       = '';
		$dimensions = array( 'top', 'right', 'bottom', 'left' );
		foreach ( $dimensions as $dimension ) {
			if ( ! array_key_exists( $dimension, $default ) ) {
				continue;
			}

			$attr_name  = $name . '[' . $dimension . ']';
			$attr_value = isset( $value[ $dimension ] ) ? $value[ $dimension ] : $default[ $dimension ];
			if ( 'top' == $dimension ) {
				$icon_class = 'dashicons dashicons-arrow-up-alt';
			} elseif ( 'bottom' == $dimension ) {
				$icon_class = 'dashicons dashicons-arrow-down-alt';
			} else {
				$icon_class = 'dashicons dashicons-arrow-' . $dimension . '-alt';
			}

			$html .= '<div class="shapla-dimension">';
			$html .= '<span class="add-on"><i class="' . esc_attr( $icon_class ) . '"></i></span>';
			$html .= '<input type="text" name="' . esc_attr( $attr_name ) . '" value="' . esc_attr( $attr_value ) . '">';
			$html .= '</div>';
		}

		return $html;
	}
}
