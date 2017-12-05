<?php

class Shapla_Elementor {

	private static $instance;

	/**
	 * @return Shapla_Elementor
	 */
	public static function init() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );

		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_frontend_scripts' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_frontend_styles' ) );
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_frontend_styles' ) );
	}

	public function init_widgets() {
		\Elementor\Plugin::instance()->elements_manager->add_category(
			'shapla-elements',
			array(
				'title' => 'Shapla Elements',
				'icon'  => 'fa fa-plug'
			),
			1
		);

		require_once 'elements/hero-slider/hero-slider.php';
	}

	public function register_frontend_scripts() {
		$suffix     = ( defined( "SCRIPT_DEBUG" ) && SCRIPT_DEBUG ) ? '' : '.min';
		$assets_dir = get_template_directory_uri() . '/assets';

		wp_register_script(
			'flickity',
			$assets_dir . '/libs/flickity/flickity' . $suffix . '.js',
			array(),
			'2.0.10',
			true
		);

		wp_enqueue_script(
			'shapla-elementor',
			$assets_dir . '/js/elementor.js',
			array( 'jquery' ),
			SHAPLA_VERSION,
			true
		);
	}

	public function register_frontend_styles() {
		$assets_dir = get_template_directory_uri() . '/assets';
		wp_register_style(
			'shapla-flickity-slider',
			$assets_dir . '/css/flickity.css',
			array(),
			SHAPLA_VERSION,
			'all'
		);
	}

	public function enqueue_frontend_styles() {
		wp_enqueue_style( 'shapla-flickity-slider' );
	}
}

return Shapla_Elementor::init();
