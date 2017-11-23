<?php

use Elementor\Controls_Manager;
use Elementor\Repeater;

$this->start_controls_section(
	'section_slides',
	[
		'label' => __( 'Slides', 'text_domain' ),
	]
);

$repeater = new Repeater();

$repeater->start_controls_tabs( 'slides_repeater' );

$repeater->start_controls_tab( 'background', [ 'label' => __( 'Background', 'text_domain' ) ] );

$repeater->add_control(
	'background_color',
	[
		'label'     => __( 'Color', 'text_domain' ),
		'type'      => Controls_Manager::COLOR,
		'default'   => '#bbbbbb',
		'selectors' => [
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__background' => 'background-color: {{VALUE}}',
		],
	]
);

$repeater->add_control(
	'background_image',
	[
		'label'     => _x( 'Image', 'Background Control', 'text_domain' ),
		'type'      => Controls_Manager::MEDIA,
		'selectors' => [
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__background' => 'background-image: url({{URL}})',
		],
	]
);

$repeater->add_control(
	'background_size',
	[
		'label'      => _x( 'Size', 'Background Control', 'text_domain' ),
		'type'       => Controls_Manager::SELECT,
		'default'    => 'cover',
		'options'    => [
			'cover'   => _x( 'Cover', 'Background Control', 'text_domain' ),
			'contain' => _x( 'Contain', 'Background Control', 'text_domain' ),
			'auto'    => _x( 'Auto', 'Background Control', 'text_domain' ),
		],
		'selectors'  => [
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__background' => 'background-size: {{VALUE}}',
		],
		'conditions' => [
			'terms' => [
				[
					'name'     => 'background_image[url]',
					'operator' => '!=',
					'value'    => '',
				],
			],
		],
	]
);

$repeater->add_control(
	'background_ken_burns',
	[
		'label'        => __( 'Ken Burns Effect', 'text_domain' ),
		'type'         => Controls_Manager::SWITCHER,
		'return_value' => 'yes',
		'default'      => '',
		'separator'    => 'before',
		'conditions'   => [
			'terms' => [
				[
					'name'     => 'background_image[url]',
					'operator' => '!=',
					'value'    => '',
				],
			],
		],
	]
);

$repeater->add_control(
	'zoom_direction',
	[
		'label'      => __( 'Zoom Direction', 'text_domain' ),
		'type'       => Controls_Manager::SELECT,
		'default'    => 'in',
		'options'    => [
			'in'  => __( 'In', 'text_domain' ),
			'out' => __( 'Out', 'text_domain' ),
		],
		'conditions' => [
			'terms' => [
				[
					'name'     => 'background_ken_burns',
					'operator' => '!=',
					'value'    => '',
				],
			],
		],
	]
);

$repeater->add_control(
	'background_overlay',
	[
		'label'        => __( 'Background Overlay', 'text_domain' ),
		'type'         => Controls_Manager::SWITCHER,
		'return_value' => 'yes',
		'default'      => '',
		'separator'    => 'before',
		'conditions'   => [
			'terms' => [
				[
					'name'     => 'background_image[url]',
					'operator' => '!=',
					'value'    => '',
				],
			],
		],
	]
);

$repeater->add_control(
	'background_overlay_color',
	[
		'label'      => __( 'Color', 'text_domain' ),
		'type'       => Controls_Manager::COLOR,
		'default'    => 'rgba(0,0,0,0.5)',
		'conditions' => [
			'terms' => [
				[
					'name'     => 'background_overlay',
					'operator' => '==',
					'value'    => 'yes',
				],
			],
		],
		'selectors'  => [
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__inner .hero-carousel__cell__background_overlay' => 'background-color: {{VALUE}}',
		],
	]
);

$repeater->end_controls_tab();

$repeater->start_controls_tab( 'content', [ 'label' => __( 'Content', 'text_domain' ) ] );

$repeater->add_control(
	'heading',
	[
		'label'       => __( 'Title & Description', 'text_domain' ),
		'type'        => Controls_Manager::TEXT,
		'default'     => __( 'Slide Heading', 'text_domain' ),
		'label_block' => true,
	]
);

$repeater->add_control(
	'description',
	[
		'label'      => __( 'Description', 'text_domain' ),
		'type'       => Controls_Manager::TEXTAREA,
		'default'    => __( 'I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'text_domain' ),
		'show_label' => false,
	]
);

$repeater->add_control(
	'button_text',
	[
		'label'   => __( 'Button Text', 'text_domain' ),
		'type'    => Controls_Manager::TEXT,
		'default' => __( 'Click Here', 'text_domain' ),
	]
);

$repeater->add_control(
	'link',
	[
		'label'       => __( 'Link', 'text_domain' ),
		'type'        => Controls_Manager::URL,
		'placeholder' => __( 'http://your-link.com', 'text_domain' ),
	]
);

$repeater->add_control(
	'link_click',
	[
		'label'      => __( 'Apply Link On', 'text_domain' ),
		'type'       => Controls_Manager::SELECT,
		'options'    => [
			'slide'  => __( 'Whole Slide', 'text_domain' ),
			'button' => __( 'Button Only', 'text_domain' ),
		],
		'default'    => 'slide',
		'conditions' => [
			'terms' => [
				[
					'name'     => 'link[url]',
					'operator' => '!=',
					'value'    => '',
				],
			],
		],
	]
);

$repeater->end_controls_tab();

$repeater->start_controls_tab( 'style', [ 'label' => __( 'Style', 'text_domain' ) ] );

$repeater->add_control(
	'custom_style',
	[
		'label'        => __( 'Custom', 'text_domain' ),
		'type'         => Controls_Manager::SWITCHER,
		'return_value' => 'yes',
		'description'  => __( 'Set custom style that will only affect this specific slide.', 'text_domain' ),
	]
);

$repeater->add_control(
	'horizontal_position',
	[
		'label'                => __( 'Horizontal Position', 'text_domain' ),
		'type'                 => Controls_Manager::CHOOSE,
		'label_block'          => false,
		'options'              => [
			'left'   => [
				'title' => __( 'Left', 'text_domain' ),
				'icon'  => 'eicon-h-align-left',
			],
			'center' => [
				'title' => __( 'Center', 'text_domain' ),
				'icon'  => 'eicon-h-align-center',
			],
			'right'  => [
				'title' => __( 'Right', 'text_domain' ),
				'icon'  => 'eicon-h-align-right',
			],
		],
		'selectors'            => [
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__inner .hero-carousel__cell__content' => '{{VALUE}}',
		],
		'selectors_dictionary' => [
			'left'   => 'margin-right: auto',
			'center' => 'margin: 0 auto',
			'right'  => 'margin-left: auto',
		],
		'conditions'           => [
			'terms' => [
				[
					'name'     => 'custom_style',
					'operator' => '==',
					'value'    => 'yes',
				],
			],
		],
	]
);

$repeater->add_control(
	'vertical_position',
	[
		'label'                => __( 'Vertical Position', 'text_domain' ),
		'type'                 => Controls_Manager::CHOOSE,
		'label_block'          => false,
		'options'              => [
			'top'    => [
				'title' => __( 'Top', 'text_domain' ),
				'icon'  => 'eicon-v-align-top',
			],
			'middle' => [
				'title' => __( 'Middle', 'text_domain' ),
				'icon'  => 'eicon-v-align-middle',
			],
			'bottom' => [
				'title' => __( 'Bottom', 'text_domain' ),
				'icon'  => 'eicon-v-align-bottom',
			],
		],
		'selectors'            => [
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__inner' => 'align-items: {{VALUE}}',
		],
		'selectors_dictionary' => [
			'top'    => 'flex-start',
			'middle' => 'center',
			'bottom' => 'flex-end',
		],
		'conditions'           => [
			'terms' => [
				[
					'name'     => 'custom_style',
					'operator' => '==',
					'value'    => 'yes',
				],
			],
		],
	]
);

$repeater->add_control(
	'text_align',
	[
		'label'       => __( 'Text Align', 'text_domain' ),
		'type'        => Controls_Manager::CHOOSE,
		'label_block' => false,
		'options'     => [
			'left'   => [
				'title' => __( 'Left', 'text_domain' ),
				'icon'  => 'fa fa-align-left',
			],
			'center' => [
				'title' => __( 'Center', 'text_domain' ),
				'icon'  => 'fa fa-align-center',
			],
			'right'  => [
				'title' => __( 'Right', 'text_domain' ),
				'icon'  => 'fa fa-align-right',
			],
		],
		'selectors'   => [
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__inner' => 'text-align: {{VALUE}}',
		],
		'conditions'  => [
			'terms' => [
				[
					'name'     => 'custom_style',
					'operator' => '==',
					'value'    => 'yes',
				],
			],
		],
	]
);

$repeater->add_control(
	'content_color',
	[
		'label'      => __( 'Content Color', 'text_domain' ),
		'type'       => Controls_Manager::COLOR,
		'selectors'  => [
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__inner .hero-carousel__cell__heading'     => 'color: {{VALUE}}',
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__inner .hero-carousel__cell__description' => 'color: {{VALUE}}',
			'{{WRAPPER}} {{CURRENT_ITEM}} .hero-carousel__cell__inner .elementor-slide-button'      => 'color: {{VALUE}}; border-color: {{VALUE}}',
		],
		'conditions' => [
			'terms' => [
				[
					'name'     => 'custom_style',
					'operator' => '==',
					'value'    => 'yes',
				],
			],
		],
	]
);

$repeater->end_controls_tab();

$repeater->end_controls_tabs();

$this->add_control(
	'slides',
	[
		'label'       => __( 'Slides', 'text_domain' ),
		'type'        => Controls_Manager::REPEATER,
		'show_label'  => true,
		'default'     => [
			[
				'heading'          => __( 'Slide 1 Heading', 'text_domain' ),
				'description'      => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'text_domain' ),
				'button_text'      => __( 'Click Here', 'text_domain' ),
				'background_color' => '#833ca3',
			],
			[
				'heading'          => __( 'Slide 2 Heading', 'text_domain' ),
				'description'      => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'text_domain' ),
				'button_text'      => __( 'Click Here', 'text_domain' ),
				'background_color' => '#4054b2',
			],
			[
				'heading'          => __( 'Slide 3 Heading', 'text_domain' ),
				'description'      => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'text_domain' ),
				'button_text'      => __( 'Click Here', 'text_domain' ),
				'background_color' => '#1abc9c',
			],
		],
		'fields'      => array_values( $repeater->get_controls() ),
		'title_field' => '{{{ heading }}}',
	]
);

$this->add_responsive_control(
	'slides_height',
	[
		'label'      => __( 'Height', 'text_domain' ),
		'type'       => Controls_Manager::SLIDER,
		'range'      => [
			'px' => [
				'min' => 100,
				'max' => 1000,
			],
			'vh' => [
				'min' => 10,
				'max' => 100,
			],
		],
		'default'    => [
			'size' => 400,
		],
		'size_units' => [ 'px', 'vh', 'em' ],
		'selectors'  => [
			'{{WRAPPER}} .hero-carousel__cell' => 'height: {{SIZE}}{{UNIT}};',
		],
		'separator'  => 'before',
	]
);

$this->end_controls_section();