<?php
/**
 * PenBird Typography Customizer section.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

penbird_add_customize_section(
	$wp_customize,
	'penbird_typography',
	array(
		'capability'  => 'edit_theme_options',
		'priority'    => 30,
		'title'       => __( 'Typography', 'penbird' ),
		'description' => __( 'Free typography using the PenBird design system. Inter is the default font.', 'penbird' ),
		'panel'       => 'penbird_front_option',
		'section'     => 'penbird_panel_global',
	)
);

$font_choices = array(
	'inter'   => __( 'Inter (Default)', 'penbird' ),
	'system'  => __( 'System UI', 'penbird' ),
	'georgia' => __( 'Georgia', 'penbird' ),
	'times'   => __( 'Times New Roman', 'penbird' ),
);

$weight_choices = array(
	'300' => __( 'Light (300)', 'penbird' ),
	'400' => __( 'Regular (400)', 'penbird' ),
	'500' => __( 'Medium (500)', 'penbird' ),
	'600' => __( 'Semi Bold (600)', 'penbird' ),
	'700' => __( 'Bold (700)', 'penbird' ),
);

$wp_customize->add_setting(
	'penbird_body_font',
	array(
		'default'           => 'inter',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_body_font',
	array(
		'label'    => __( 'Body Font Family', 'penbird' ),
		'section'  => 'penbird_typography',
		'priority' => 40,
		'type'     => 'select',
		'choices' => $font_choices,
	)
);

$wp_customize->add_setting(
	'penbird_body_font_size',
	array(
		'default'           => 16,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_number_range',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_body_font_size',
	array(
		'label'       => __( 'Body Font Size (px)', 'penbird' ),
		'section'     => 'penbird_typography',
		'priority'    => 41,
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 22,
			'step' => 1,
		),
	)
);

$wp_customize->add_setting(
	'penbird_body_font_weight',
	array(
		'default'           => '400',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_body_font_weight',
	array(
		'label'    => __( 'Body Font Weight', 'penbird' ),
		'section'  => 'penbird_typography',
		'priority' => 42,
		'type'     => 'select',
		'choices' => $weight_choices,
	)
);

$wp_customize->add_setting(
	'penbird_heading_font',
	array(
		'default'           => 'inter',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_heading_font',
	array(
		'label'    => __( 'Heading Font Family', 'penbird' ),
		'section'  => 'penbird_typography',
		'priority' => 43,
		'type'     => 'select',
		'choices' => $font_choices,
	)
);

$wp_customize->add_setting(
	'penbird_heading_font_weight',
	array(
		'default'           => '500',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_heading_font_weight',
	array(
		'label'    => __( 'Heading Font Weight', 'penbird' ),
		'section'  => 'penbird_typography',
		'priority' => 44,
		'type'     => 'select',
		'choices' => $weight_choices,
	)
);
