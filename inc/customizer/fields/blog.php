<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new panel
$shapla->customizer->add_panel( 'blog_panel', array(
	'title'    => __( 'Blog', 'shapla' ),
	'priority' => 50,
) );
// Add new section
$shapla->customizer->add_section( 'blog_section', array(
	'title'       => __( 'Blog Post Meta', 'shapla' ),
	'description' => __( 'Customise meta information for the categories, tags and comments.', 'shapla' ),
	'panel'       => 'blog_panel',
	'priority'    => 20,
) );

// Add new section
$shapla->customizer->add_section( 'blog_layout_section', array(
	'title'       => __( 'Blog Layouts & Styles', 'shapla' ),
	'description' => __( 'Customise your site blog layouts and styles.', 'shapla' ),
	'panel'       => 'blog_panel',
	'priority'    => 10,
) );

// Site
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_author_avatar',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show author avatar', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_avatar,
	'priority' => 10,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_author_name',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show author name', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_author_name,
	'priority' => 20,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_date',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show date', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_date,
	'priority' => 30,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_category_list',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show category list', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_category,
	'priority' => 40,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_tag_list',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show tag list', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_tag,
	'priority' => 50,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_comments_link',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show comments link', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_comments_link,
	'priority' => 60,
) );
$shapla->customizer->add_field( array(
	'settings' => 'blog_layout',
	'type'     => 'select',
	'section'  => 'blog_layout_section',
	'label'    => __( 'Blog layout', 'shapla' ),
	'default'  => shapla_default_options()->blog->layout,
	'priority' => 10,
	'choices'  => array(
		'default' => esc_html__( 'Default', 'shapla' ),
		'grid'    => esc_html__( 'Grid', 'shapla' ),
	)
) );
$shapla->customizer->add_field( array(
	'settings'    => 'blog_date_format',
	'type'        => 'select',
	'section'     => 'blog_layout_section',
	'label'       => __( 'Blog date format', 'shapla' ),
	'description' => __( 'Default date format is format you set from Settings --> General --> Date Format', 'shapla' ),
	'default'     => shapla_default_options()->blog->date_format,
	'priority'    => 10,
	'choices'     => array(
		'default' => esc_html__( 'Default', 'shapla' ),
		'human'   => esc_html__( 'Human readable', 'shapla' ),
	)
) );
$shapla->customizer->add_field( array(
	'settings' => 'blog_excerpt_length',
	'type'     => 'number',
	'section'  => 'blog_layout_section',
	'label'    => __( 'Excerpt length', 'shapla' ),
	'default'  => shapla_default_options()->blog->excerpt_length,
	'priority' => 20,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_page_title',
	'type'     => 'checkbox',
	'section'  => 'blog_layout_section',
	'label'    => __( 'Show page title on Blog page', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_page_title,
	'priority' => 30,
) );