<?php

namespace Shapla\Customize\Controls;

use WP_Customize_Control;

defined( 'ABSPATH' ) || exit;

/**
 * Shapla Customize Control class.
 */
class BaseControl extends WP_Customize_Control {
	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = array();

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * Option name (if using options).
	 *
	 * @access public
	 * @var string
	 */
	public $option_name = false;

	/**
	 * The shapla_config we're using for this control
	 *
	 * @access public
	 * @var string
	 */
	public $shapla_config = 'global';

	/**
	 * Whitelisting the "required" argument.
	 *
	 * @access public
	 * @var array
	 */
	public $required = array();

	/**
	 * Enqueue scripts and styles for the custom control.
	 *
	 * Scripts are hooked at {@see 'customize_controls_enqueue_scripts'}.
	 *
	 * Note, you can also enqueue stylesheets here as well. Stylesheets are hooked
	 * at 'customize_controls_print_styles'.
	 */
	public function enqueue() {
		$asset_url = SHAPLA_THEME_URI . '/assets';

		// Enqueue selectWoo.
		wp_enqueue_script( 'select2', $asset_url . '/js/select2.js', array( 'jquery' ), '4.0.3', true );
		wp_enqueue_style( 'select2', $asset_url . '/css/select2.css', array(), '4.0.3' );

		wp_enqueue_style( 'shapla-customize', $asset_url . '/css/customizer.css', array(), SHAPLA_THEME_VERSION );

		wp_enqueue_script(
			'shapla-customize',
			$asset_url . '/js/customizer.js',
			array( 'jquery', 'customize-base', 'jquery-ui-button', 'select2' ),
			SHAPLA_THEME_VERSION,
			true
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {
		parent::to_json();

		// Default.
		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		// Required.
		$this->json['required'] = $this->required;
		// Output.
		$this->json['output'] = $this->output;
		// Value.
		$this->json['value'] = $this->value();
		// Choices.
		$this->json['choices'] = $this->choices;
		// The link.
		$this->json['link'] = $this->get_link();
		// The ID.
		$this->json['id'] = $this->id;
		// Translation strings.
		$this->json['l10n'] = $this->l10n();
		// The ajaxurl in case we need it.
		$this->json['ajaxurl'] = admin_url( 'admin-ajax.php' );
		// Input attributes.
		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}
		// The shapla-config.
		$this->json['shaplaConfig'] = $this->shapla_config;
		// The option-type.
		$this->json['shaplaOptionType'] = $this->option_type;
		// The option-name.
		$this->json['shaplaOptionName'] = $this->option_name;
	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
	 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 */
	protected function render_content() {
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Control::to_json().
	 *
	 * @see WP_Customize_Control::print_template()
	 */
	protected function content_template() {
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @return array
	 * @since 3.0.0
	 */
	protected function l10n() {
		return array();
	}
}
