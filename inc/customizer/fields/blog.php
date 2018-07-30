<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add Blog Panel
 */
$shapla->customizer->add_panel( 'blog_panel', array(
	'title'    => __( 'Blog', 'shapla' ),
	'priority' => 50,
) );

/**
 * Add Blog Sections
 */
$shapla->customizer->add_section( 'general_blog_section', array(
	'title'       => __( 'General Blog', 'shapla' ),
	'description' => __( 'Customise your site blog layouts and styles.', 'shapla' ),
	'panel'       => 'blog_panel',
	'priority'    => 10,
) );
$shapla->customizer->add_section( 'single_blog_section', array(
	'title'       => __( 'Blog Single Post', 'shapla' ),
	'description' => __( 'Customise your site single blog layouts and styles.', 'shapla' ),
	'panel'       => 'blog_panel',
	'priority'    => 20,
) );
$shapla->customizer->add_section( 'blog_meta_section', array(
	'title'       => __( 'Blog Meta', 'shapla' ),
	'description' => __( 'Customise your site blog meta data and its styles.', 'shapla' ),
	'panel'       => 'blog_panel',
	'priority'    => 30,
) );

/**
 * General Blog Section
 */
$shapla->customizer->add_field( array(
	'settings'          => 'show_blog_page_title',
	'type'              => 'toggle',
	'section'           => 'general_blog_section',
	'label'             => __( 'Blog Page Title Bar', 'shapla' ),
	'description'       => __( 'Controls how the page title bar displays on the assigned blog page in "settings > reading".', 'shapla' ),
	'default'           => shapla_default_options( 'show_blog_page_title' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 10,
) );
$shapla->customizer->add_field( array(
	'settings'          => 'blog_page_title',
	'type'              => 'text',
	'section'           => 'general_blog_section',
	'label'             => __( 'Blog Page Title', 'shapla' ),
	'description'       => __( 'Controls the title text that displays in the page title bar only if your front page displays your latest post in "settings > reading".', 'shapla' ),
	'default'           => shapla_default_options( 'blog_page_title' ),
	'priority'          => 20,
	'sanitize_callback' => array( 'Shapla_Sanitize', 'text' ),
) );

$shapla->customizer->add_field( array(
	'settings'          => 'blog_layout',
	'type'              => 'select',
	'section'           => 'general_blog_section',
	'label'             => __( 'Blog layout', 'shapla' ),
	'description'       => __( 'Controls the layout for the assigned blog page in "settings > reading".', 'shapla' ),
	'default'           => shapla_default_options( 'blog_layout' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'customize_choices' ),
	'priority'          => 30,
	'choices'           => array(
		'default' => esc_html__( 'Default', 'shapla' ),
		'grid'    => esc_html__( 'Grid', 'shapla' ),
	),
) );
$shapla->customizer->add_field( array(
	'settings'          => 'blog_excerpt_length',
	'type'              => 'range-slider',
	'section'           => 'general_blog_section',
	'label'             => __( 'Excerpt length', 'shapla' ),
	'description'       => __( 'Controls the number of words in the post excerpts for the assigned blog page in "settings > reading" or blog archive pages.', 'shapla' ),
	'default'           => shapla_default_options( 'blog_excerpt_length' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'number' ),
	'priority'          => 40,
	'input_attrs'       => array(
		'min'  => 5,
		'max'  => 200,
		'step' => 1,
	),
) );

$shapla->customizer->add_field( array(
	'settings'          => 'blog_date_format',
	'type'              => 'radio-button',
	'section'           => 'general_blog_section',
	'label'             => __( 'Blog date format', 'shapla' ),
	'description'       => __( 'Default date format is format you set from Settings --> General --> Date Format', 'shapla' ),
	'default'           => shapla_default_options( 'blog_date_format' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'customize_choices' ),
	'priority'          => 50,
	'choices'           => array(
		'default' => esc_html__( 'Default', 'shapla' ),
		'human'   => esc_html__( 'Human readable', 'shapla' ),
	)
) );

/**
 * Blog Meta Section
 */
$shapla->customizer->add_field( array(
	'settings'          => 'show_blog_author_avatar',
	'type'              => 'toggle',
	'section'           => 'blog_meta_section',
	'label'             => __( 'Post Meta Author Avatar', 'shapla' ),
	'description'       => __( 'Turn on to display the post meta author avatar.', 'shapla' ),
	'default'           => shapla_default_options( 'show_blog_author_avatar' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 10,
) );
$shapla->customizer->add_field( array(
	'settings'          => 'show_blog_author_name',
	'type'              => 'toggle',
	'section'           => 'blog_meta_section',
	'label'             => __( 'Post Meta Author Name', 'shapla' ),
	'description'       => __( 'Turn on to display the post meta author name.', 'shapla' ),
	'default'           => shapla_default_options( 'show_blog_author_name' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 20,
) );
$shapla->customizer->add_field( array(
	'settings'          => 'show_blog_date',
	'type'              => 'toggle',
	'section'           => 'blog_meta_section',
	'label'             => __( 'Post Meta Date', 'shapla' ),
	'description'       => __( 'Turn on to display the post meta date.', 'shapla' ),
	'default'           => shapla_default_options( 'show_blog_date' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 30,
) );
$shapla->customizer->add_field( array(
	'settings'          => 'show_blog_category_list',
	'type'              => 'toggle',
	'section'           => 'blog_meta_section',
	'label'             => __( 'Post Meta Categories', 'shapla' ),
	'description'       => __( 'Turn on to display the post meta categories.', 'shapla' ),
	'default'           => shapla_default_options( 'show_blog_category_list' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 40,
) );
$shapla->customizer->add_field( array(
	'settings'          => 'show_blog_tag_list',
	'type'              => 'toggle',
	'section'           => 'blog_meta_section',
	'label'             => __( 'Post Meta Tags', 'shapla' ),
	'description'       => __( 'Turn on to display the post meta tags.', 'shapla' ),
	'default'           => shapla_default_options( 'show_blog_tag_list' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 50,
) );
$shapla->customizer->add_field( array(
	'settings'          => 'show_blog_comments_link',
	'type'              => 'toggle',
	'section'           => 'blog_meta_section',
	'label'             => __( 'Post Meta Comments', 'shapla' ),
	'description'       => __( 'Turn on to display the post meta comments.', 'shapla' ),
	'default'           => shapla_default_options( 'show_blog_comments_link' ),
	'sanitize_callback' => array( 'Shapla_Sanitize', 'checked' ),
	'priority'          => 60,
) );
