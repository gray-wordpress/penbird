<?php
/**
 * PenBird breadcrumb Customizer section.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

penbird_add_customize_section(
	$wp_customize,
	'penbird_breadcrumb',
	array(
		'capability'  => 'edit_theme_options',
		'priority'    => 20,
		'title'       => __( 'Page Breadcrumb', 'penbird' ),
		'description' => __( 'Page Breadcrumb Settings.', 'penbird' ),
		'panel'       => 'penbird_front_option',
		'section'     => 'penbird_panel_global',
	)
);

$wp_customize->add_setting(
	'penbird_page_bc',
	array(
		'default'           => true,
		'sanitize_callback' => 'penbird_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'penbird_page_bc',
	array(
		'label'    => esc_html__( 'Show page breadcrumb', 'penbird' ),
		'section'  => 'penbird_breadcrumb',
		'priority' => 10,
		'type'     => 'checkbox',
	)
);

$wp_customize->add_setting(
	'penbird_archive_bc',
	array(
		'default'           => true,
		'sanitize_callback' => 'penbird_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'penbird_archive_bc',
	array(
		'label'    => esc_html__( 'Show archive breadcrumb', 'penbird' ),
		'section'  => 'penbird_breadcrumb',
		'priority' => 20,
		'type'     => 'checkbox',
	)
);

$wp_customize->add_setting(
	'penbird_bc_archive_title',
	array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'penbird_bc_archive_title',
	array(
		'label'    => __( 'Type Archive Title', 'penbird' ),
		'section'  => 'penbird_breadcrumb',
		'priority' => 30,
		'type'     => 'text',
		'settings' => 'penbird_bc_archive_title',
	)
);

$wp_customize->add_setting(
	'penbird_search_bc',
	array(
		'default'           => true,
		'sanitize_callback' => 'penbird_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	'penbird_search_bc',
	array(
		'label'    => esc_html__( 'Show search breadcrumb', 'penbird' ),
		'section'  => 'penbird_breadcrumb',
		'priority' => 40,
		'type'     => 'checkbox',
	)
);
