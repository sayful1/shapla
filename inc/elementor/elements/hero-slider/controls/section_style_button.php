<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

$this->start_controls_section(
	'section_style_button',
	[
		'label' => __( 'Button', 'text_domain' ),
		'tab'   => Controls_Manager::TAB_STYLE,
	]
);

$this->add_control(
	'button_size',
	[
		'label'   => __( 'Size', 'text_domain' ),
		'type'    => Controls_Manager::SELECT,
		'default' => 'sm',
		'options' => [
			'xs' => __( 'Extra Small', 'text_domain' ),
			'sm' => __( 'Small', 'text_domain' ),
			'md' => __( 'Medium', 'text_domain' ),
			'lg' => __( 'Large', 'text_domain' ),
			'xl' => __( 'Extra Large', 'text_domain' ),
		],
	]
);

$this->add_control( 'button_color',
	[
		'label'     => __( 'Text Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',

		],
	]
);

$this->add_group_control(
	Group_Control_Typography::get_type(),
	[
		'name'     => 'button_typography',
		'label'    => __( 'Typography', 'text_domain' ),
		'selector' => '{{WRAPPER}} .elementor-slide-button',
		'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
	]
);

$this->add_control(
	'button_border_width',
	[
		'label'     => __( 'Border Width', 'text_domain' ),
		'type'      => Controls_Manager::SLIDER,
		'range'     => [
			'px' => [
				'min' => 0,
				'max' => 20,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button' => 'border-width: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_control(
	'button_border_radius',
	[
		'label'     => __( 'Border Radius', 'text_domain' ),
		'type'      => Controls_Manager::SLIDER,
		'range'     => [
			'px' => [
				'min' => 0,
				'max' => 100,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button' => 'border-radius: {{SIZE}}{{UNIT}};',
		],
		'separator' => 'after',
	]
);

$this->start_controls_tabs( 'button_tabs' );

$this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'text_domain' ) ] );

$this->add_control(
	'button_text_color',
	[
		'label'     => __( 'Text Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button' => 'color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'button_background_color',
	[
		'label'     => __( 'Background Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'button_border_color',
	[
		'label'     => __( 'Border Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button' => 'border-color: {{VALUE}};',
		],
	]
);

$this->end_controls_tab();

$this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'text_domain' ) ] );

$this->add_control(
	'button_hover_text_color',
	[
		'label'     => __( 'Text Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button:hover' => 'color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'button_hover_background_color',
	[
		'label'     => __( 'Background Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button:hover' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'button_hover_border_color',
	[
		'label'     => __( 'Border Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .elementor-slide-button:hover' => 'border-color: {{VALUE}};',
		],
	]
);

$this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();