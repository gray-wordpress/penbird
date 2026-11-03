<?php
/**
 * PenBird Container Customizer section.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

penbird_add_customize_section(
	$wp_customize,
	'penbird_container',
	array(
		'capability'  => 'edit_theme_options',
		'priority'    => 10,
		'title'       => __( 'Container', 'penbird' ),
		'description' => __( 'Global container and default sidebar. Pages can override these from PenBird Page Settings.', 'penbird' ),
		'panel'       => 'penbird_front_option',
		'section'     => 'penbird_panel_layout',
	)
);

$wp_customize->add_setting(
	'penbird_container_layout',
	array(
		'default'           => 'boxed',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Visual_Radio_Control(
		$wp_customize,
		'penbird_container_layout',
		array(
			'label'   => __( 'Container Layout', 'penbird' ),
			'section' => 'penbird_container',
			'choices' => array(
				'boxed'  => __( 'Boxed', 'penbird' ),
				'narrow' => __( 'Narrow', 'penbird' ),
				'full'   => __( 'Full Width', 'penbird' ),
			),
			'icons'   => array(
				'boxed'  => penbird_customizer_icon( 'container-boxed' ),
				'narrow' => penbird_customizer_icon( 'container-narrow' ),
				'full'   => penbird_customizer_icon( 'container-full' ),
			),
		)
	)
);

$wp_customize->add_setting(
	'penbird_container_width',
	array(
		'default'           => 1280,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_number_range',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_container_width',
	array(
		'label'       => __( 'Container Width (px)', 'penbird' ),
		'description' => __( 'Max-width for the Boxed layout (.container).', 'penbird' ),
		'section'     => 'penbird_container',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 960,
			'max'  => 1920,
			'step' => 10,
		),
	)
);

$wp_customize->add_setting(
	'penbird_content_width',
	array(
		'default'           => 800,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_number_range',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_content_width',
	array(
		'label'       => __( 'Narrow Width (px)', 'penbird' ),
		'section'     => 'penbird_container',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 480,
			'max'  => 1200,
			'step' => 10,
		),
	)
);

$wp_customize->add_setting(
	'penbird_sidebar_position',
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
		'penbird_sidebar_position',
		array(
			'label'       => __( 'Sidebar', 'penbird' ),
			'description' => __( 'Default for the blog, archives, and pages set to Default. Requires the Default Sidebar to have widgets.', 'penbird' ),
			'section'     => 'penbird_container',
			'choices'     => array(
				'none'  => __( 'None', 'penbird' ),
				'left'  => __( 'Left', 'penbird' ),
				'right' => __( 'Right', 'penbird' ),
			),
			'icons'       => array(
				'none'  => penbird_customizer_icon( 'sidebar-none' ),
				'left'  => penbird_customizer_icon( 'sidebar-left' ),
				'right' => penbird_customizer_icon( 'sidebar-right' ),
			),
		)
	)
);
