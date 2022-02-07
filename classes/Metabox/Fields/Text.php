<?php

namespace Shapla\Metabox\Fields;

defined( 'ABSPATH' ) || exit;

class Text extends Base {

	/**
	 * @inheritDoc
	 */
	public function render() {
		return '<input ' . $this->build_attributes() . ' />';
	}
}
