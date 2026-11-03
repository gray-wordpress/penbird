<?php
/**
 * PenBird Logo Customizer section.
 *
 * Integrates with WordPress core custom-logo.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

penbird_add_customize_section(
	$wp_customize,
	'penbird_logo',
	array(
		'capability'  => 'edit_theme_options',
		'priority'    => 10,
		'title'       => __( 'Logo', 'penbird' ),
		'description' => __( 'Upload the site logo in Site Identity. PenBird uses WordPress custom logo in the header.', 'penbird' ),
		'panel'       => 'penbird_front_option',
		'section'     => 'penbird_panel_other',
	)
);

$wp_customize->add_setting(
	'penbird_logo_width',
	array(
		'default'           => 170,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_number_range',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_logo_width',
	array(
		'label'       => __( 'Logo Width (px)', 'penbird' ),
		'description' => __( 'Maximum width of the header logo.', 'penbird' ),
		'section'     => 'penbird_logo',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 40,
			'max'  => 400,
			'step' => 1,
		),
	)
);
