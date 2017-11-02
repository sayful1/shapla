<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add new section
$shapla->customizer->add_section( 'blog_section', array(
	'title'       => __( 'Blog', 'shapla' ),
	'description' => __( 'Customise your site blog layouts and styles.', 'shapla' ),
	'priority'    => 50,
) );

$shapla->customizer->add_field( array(
	'settings' => 'blog_layout',
	'type'     => 'select',
	'section'  => 'blog_section',
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
	'section'     => 'blog_section',
	'label'       => __( 'Blog date format', 'shapla' ),
	'description' => __( 'Default date format is format you set from Settings --> General --> Date Format', 'shapla' ),
	'default'     => shapla_default_options()->blog->date_format,
	'priority'    => 20,
	'choices'     => array(
		'default' => esc_html__( 'Default', 'shapla' ),
		'human'   => esc_html__( 'Human readable', 'shapla' ),
	)
) );
$shapla->customizer->add_field( array(
	'settings' => 'blog_excerpt_length',
	'type'     => 'number',
	'section'  => 'blog_section',
	'label'    => __( 'Excerpt length', 'shapla' ),
	'default'  => shapla_default_options()->blog->excerpt_length,
	'priority' => 30,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_page_title',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show page title on Blog page', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_page_title,
	'priority' => 40,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_author_avatar',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show author avatar', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_avatar,
	'priority' => 50,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_author_name',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show author name', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_author_name,
	'priority' => 60,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_date',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show date', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_date,
	'priority' => 70,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_category_list',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show category list', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_category,
	'priority' => 80,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_tag_list',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show tag list', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_tag,
	'priority' => 90,
) );
$shapla->customizer->add_field( array(
	'settings' => 'show_blog_comments_link',
	'type'     => 'checkbox',
	'section'  => 'blog_section',
	'label'    => __( 'Show comments link', 'shapla' ),
	'default'  => shapla_default_options()->blog->show_comments_link,
	'priority' => 100,
) );
