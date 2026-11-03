<?php
/**
 * PenBird Post Sidebar Customizer section.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

penbird_add_customize_section(
	$wp_customize,
	'penbird_post_sidebar',
	array(
		'capability'  => 'edit_theme_options',
		'priority'    => 10,
		'title'       => __( 'Post Sidebar', 'penbird' ),
		'description' => __( 'Single post sidebar. Add widgets to the Post Sidebar area. If that area is empty, the Default Sidebar is used.', 'penbird' ),
		'panel'       => 'penbird_front_option',
		'section'     => 'penbird_panel_post_page',
	)
);

$wp_customize->add_setting(
	'penbird_post_sidebar',
	array(
		'default'           => 'right',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Visual_Radio_Control(
		$wp_customize,
		'penbird_post_sidebar',
		array(
			'label'       => __( 'Post Sidebar', 'penbird' ),
			'description' => __( 'Layout for single posts. Default is Right Sidebar.', 'penbird' ),
			'section'     => 'penbird_post_sidebar',
			'choices'     => array(
				'none'  => __( 'No Sidebar', 'penbird' ),
				'left'  => __( 'Left Sidebar', 'penbird' ),
				'right' => __( 'Right Sidebar', 'penbird' ),
			),
			'icons'       => array(
				'none'  => penbird_customizer_icon( 'sidebar-none' ),
				'left'  => penbird_customizer_icon( 'sidebar-left' ),
				'right' => penbird_customizer_icon( 'sidebar-right' ),
			),
		)
	)
);
