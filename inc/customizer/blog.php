<?php
// Add new panel
$shapla->customizer->add_panel('blog_panel', array(
	'title' 		=> __('Blog', 'shapla'),
	'priority' 		=> 50,
));
// Add new section
$shapla->customizer->add_section('blog_section', array(
	'title' 		=> __('Blog Post Meta', 'shapla'),
	'description' 	=> __('Customise meta information for the categories, tags and comments.', 'shapla'),
	'panel' 		=> 'blog_panel',
	'priority' 		=> 10,
));

// Site
$shapla->customizer->add_field([
	'settings'    => 'show_blog_author_avatar',
	'type'        => 'checkbox',
	'section'     => 'blog_section',
	'label'       => __( 'Show author avatar', 'shapla' ),
	'default'     => true,
	'priority'    => 10,
]);
$shapla->customizer->add_field([
	'settings'    => 'show_blog_author_name',
	'type'        => 'checkbox',
	'section'     => 'blog_section',
	'label'       => __( 'Show author name', 'shapla' ),
	'default'     => true,
	'priority'    => 20,
]);
$shapla->customizer->add_field([
	'settings'    => 'show_blog_date',
	'type'        => 'checkbox',
	'section'     => 'blog_section',
	'label'       => __( 'Show date', 'shapla' ),
	'default'     => true,
	'priority'    => 30,
]);
$shapla->customizer->add_field([
	'settings'    => 'show_blog_category_list',
	'type'        => 'checkbox',
	'section'     => 'blog_section',
	'label'       => __( 'Show category list', 'shapla' ),
	'default'     => true,
	'priority'    => 40,
]);
$shapla->customizer->add_field([
	'settings'    => 'show_blog_tag_list',
	'type'        => 'checkbox',
	'section'     => 'blog_section',
	'label'       => __( 'Show tag list', 'shapla' ),
	'default'     => true,
	'priority'    => 50,
]);
$shapla->customizer->add_field([
	'settings'    => 'show_blog_comments_link',
	'type'        => 'checkbox',
	'section'     => 'blog_section',
	'label'       => __( 'Show comments link', 'shapla' ),
	'default'     => true,
	'priority'    => 60,
]);