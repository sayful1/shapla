<?php
/**
 * Customizer Control: slider
 *
 * This class incorporates code from the Kirki Customizer Framework
 *
 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
 * is licensed under the terms of the GNU GPL, Version 2 (or later).
 *
 * @link https://wordpress.org/plugins/kirki/
 */

namespace Shapla\Customize\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Slider extends BaseControl {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'shapla-slider';

	/**
	 * @inheritDoc
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct(
			$manager,
			$id,
			array(
				'settings'    => $id,
				'label'       => isset( $args['label'] ) ? $args['label'] : '',
				'description' => isset( $args['description'] ) ? $args['description'] : '',
				'section'     => isset( $args['section'] ) ? $args['section'] : '',
				'priority'    => isset( $args['priority'] ) ? $args['priority'] : 10,
				'input_attrs' => isset( $args['input_attrs'] ) ? $args['input_attrs'] : array(),
			) 
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();
		$this->json['choices']['min']  = ( isset( $this->choices['min'] ) ) ? $this->choices['min'] : '0';
		$this->json['choices']['max']  = ( isset( $this->choices['max'] ) ) ? $this->choices['max'] : '100';
		$this->json['choices']['step'] = ( isset( $this->choices['step'] ) ) ? $this->choices['step'] : '1';
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="wrapper">
				<input {{{ data.inputAttrs }}}
					   type="range"
					   min="{{ data.choices['min'] }}"
					   max="{{ data.choices['max'] }}"
					   step="{{ data.choices['step'] }}"
					   value="{{ data.value }}" {{{ data.link }}}
					   data-reset_value="{{ data.default }}"/>
				<div class="shapla_range_value">
					<span class="value">{{ data.value }}</span>
					<# if ( data.choices['suffix'] ) { #>
					{{ data.choices['suffix'] }}
					<# } #>
				</div>
				<div class="shapla-slider-reset">
					<span class="dashicons dashicons-image-rotate"></span>
				</div>
			</div>
		</label>
		<?php
	}
}
