<?php

use Elementor\Controls_Manager;

$this->start_controls_section(
	'section_slider_options',
	[
		'label' => __( 'Slider Options', 'text_domain' ),
		'type'  => Controls_Manager::SECTION,
	]
);

$this->add_control(
	'navigation',
	[
		'label'   => __( 'Navigation', 'text_domain' ),
		'type'    => Controls_Manager::SELECT,
		'default' => 'both',
		'options' => [
			'both'   => __( 'Arrows and Dots', 'text_domain' ),
			'arrows' => __( 'Arrows', 'text_domain' ),
			'dots'   => __( 'Dots', 'text_domain' ),
			'none'   => __( 'None', 'text_domain' ),
		],
	]
);

$this->add_control(
	'pause_on_hover',
	[
		'label'        => __( 'Pause on Hover', 'text_domain' ),
		'type'         => Controls_Manager::SWITCHER,
		'return_value' => 'yes',
		'default'      => 'yes',
	]
);

$this->add_control(
	'autoplay',
	[
		'label'        => __( 'Autoplay', 'text_domain' ),
		'type'         => Controls_Manager::SWITCHER,
		'return_value' => 'yes',
		'default'      => 'yes',
	]
);

$this->add_control(
	'autoplay_speed',
	[
		'label'     => __( 'Autoplay Speed', 'text_domain' ),
		'type'      => Controls_Manager::NUMBER,
		'default'   => 5000,
		'condition' => [
			'autoplay' => 'yes',
		],
		'selectors' => [
			'{{WRAPPER}} .hero-carousel__cell__background' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
		],
	]
);

$this->add_control(
	'infinite',
	[
		'label'        => __( 'Infinite Loop', 'text_domain' ),
		'type'         => Controls_Manager::SWITCHER,
		'return_value' => 'yes',
		'default'      => 'yes',
	]
);

$this->add_control(
	'transition',
	[
		'label'   => __( 'Transition', 'text_domain' ),
		'type'    => Controls_Manager::SELECT,
		'default' => 'slide',
		'options' => [
			'slide' => __( 'Slide', 'text_domain' ),
			'fade'  => __( 'Fade', 'text_domain' ),
		],
	]
);

$this->add_control(
	'transition_speed',
	[
		'label'   => __( 'Transition Speed (ms)', 'text_domain' ),
		'type'    => Controls_Manager::NUMBER,
		'default' => 500,
	]
);

$this->add_control(
	'content_animation',
	[
		'label'   => __( 'Content Animation', 'text_domain' ),
		'type'    => Controls_Manager::SELECT,
		'default' => 'fadeInUp',
		'options' => [
			''            => __( 'None', 'text_domain' ),
			'fadeInDown'  => __( 'Down', 'text_domain' ),
			'fadeInUp'    => __( 'Up', 'text_domain' ),
			'fadeInRight' => __( 'Right', 'text_domain' ),
			'fadeInLeft'  => __( 'Left', 'text_domain' ),
			'zoomIn'      => __( 'Zoom', 'text_domain' ),
		],
	]
);

$this->end_controls_section();