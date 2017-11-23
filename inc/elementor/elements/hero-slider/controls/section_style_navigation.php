<?php

use Elementor\Controls_Manager;

$this->start_controls_section(
	'section_style_navigation',
	[
		'label'     => __( 'Navigation', 'text_domain' ),
		'tab'       => Controls_Manager::TAB_STYLE,
		'condition' => [
			'navigation' => [ 'arrows', 'dots', 'both' ],
		],
	]
);

$this->add_control(
	'heading_style_arrows',
	[
		'label'     => __( 'Arrows', 'text_domain' ),
		'type'      => Controls_Manager::HEADING,
		'separator' => 'before',
		'condition' => [
			'navigation' => [ 'arrows', 'both' ],
		],
	]
);

$this->add_control(
	'arrows_position',
	[
		'label'     => __( 'Arrows Position', 'text_domain' ),
		'type'      => Controls_Manager::SELECT,
		'default'   => 'inside',
		'options'   => [
			'inside'  => __( 'Inside', 'text_domain' ),
			'outside' => __( 'Outside', 'text_domain' ),
		],
		'condition' => [
			'navigation' => [ 'arrows', 'both' ],
		],
	]
);

$this->add_control(
	'arrows_size',
	[
		'label'     => __( 'Arrows Size', 'text_domain' ),
		'type'      => Controls_Manager::SLIDER,
		'range'     => [
			'px' => [
				'min' => 20,
				'max' => 60,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .hero-carousel-wrapper .flickity-prev-next-button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
		],
		'condition' => [
			'navigation' => [ 'arrows', 'both' ],
		],
	]
);

$this->add_control(
	'arrows_background_color',
	[
		'label'     => __( 'Arrows Background Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .hero-carousel-wrapper .flickity-prev-next-button' => 'background: {{VALUE}};',
		],
		'condition' => [
			'navigation' => [ 'arrows', 'both' ],
		],
	]
);

$this->add_control(
	'arrows_color',
	[
		'label'     => __( 'Arrows Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .hero-carousel-wrapper .flickity-prev-next-button .arrow' => 'fill: {{VALUE}};',
		],
		'condition' => [
			'navigation' => [ 'arrows', 'both' ],
		],
	]
);

$this->add_control(
	'heading_style_dots',
	[
		'label'     => __( 'Dots', 'text_domain' ),
		'type'      => Controls_Manager::HEADING,
		'separator' => 'before',
		'condition' => [
			'navigation' => [ 'dots', 'both' ],
		],
	]
);

$this->add_control(
	'dots_position',
	[
		'label'     => __( 'Dots Position', 'text_domain' ),
		'type'      => Controls_Manager::SELECT,
		'default'   => 'inside',
		'options'   => [
			'outside' => __( 'Outside', 'text_domain' ),
			'inside'  => __( 'Inside', 'text_domain' ),
		],
		'condition' => [
			'navigation' => [ 'dots', 'both' ],
		],
	]
);

$this->add_control(
	'dots_size',
	[
		'label'     => __( 'Dots Size', 'text_domain' ),
		'type'      => Controls_Manager::SLIDER,
		'range'     => [
			'px' => [
				'min' => 5,
				'max' => 15,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .hero-carousel-wrapper .flickity-page-dots .dot' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
		],
		'condition' => [
			'navigation' => [ 'dots', 'both' ],
		],
	]
);

$this->add_control(
	'dots_color',
	[
		'label'     => __( 'Dots Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .hero-carousel-wrapper .flickity-page-dots .dot' => 'background: {{VALUE}};',
		],
		'condition' => [
			'navigation' => [ 'dots', 'both' ],
		],
	]
);

$this->end_controls_section();