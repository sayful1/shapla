<?php

namespace Shapla\Metabox\Fields;

class Text extends Base {

	/**
	 * @inheritDoc
	 */
	public function render() {
		return '<input ' . $this->build_attributes() . ' />';
	}
}
