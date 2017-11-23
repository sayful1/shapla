<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

$this->start_controls_section(
	'section_style_description',
	[
		'label' => __( 'Description', 'text_domain' ),
		'tab'   => Controls_Manager::TAB_STYLE,
	]
);

$this->add_control(
	'description_spacing',
	[
		'label'     => __( 'Spacing', 'text_domain' ),
		'type'      => Controls_Manager::SLIDER,
		'range'     => [
			'px' => [
				'min' => 0,
				'max' => 100,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .hero-carousel__cell__inner .hero-carousel__cell__description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
		],
	]
);

$this->add_control(
	'description_color',
	[
		'label'     => __( 'Text Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .hero-carousel__cell__description' => 'color: {{VALUE}}',

		],
	]
);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	[
		'name'     => 'description_typography',
		'label'    => __( 'Typography', 'text_domain' ),
		'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
		'selector' => '{{WRAPPER}} .hero-carousel__cell__description',
	]
);

$this->end_controls_section();