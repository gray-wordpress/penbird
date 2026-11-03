<?php
/**
 * PenBird Footer Customizer section.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

penbird_add_customize_section(
	$wp_customize,
	'penbird_footer',
	array(
		'capability'  => 'edit_theme_options',
		'priority'    => 20,
		'title'       => __( 'Manage Footer', 'penbird' ),
		'description' => __( 'Free footer options. Changes apply to the live PenBird footer in the preview.', 'penbird' ),
		'panel'       => 'penbird_front_option',
		'section'     => 'penbird_panel_header_footer',
	)
);

$wp_customize->add_setting(
	'penbird_footer_layout',
	array(
		'default'           => 'three',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Visual_Radio_Control(
		$wp_customize,
		'penbird_footer_layout',
		array(
			'label'    => __( 'Footer Widgets Layout', 'penbird' ),
			'section'  => 'penbird_footer',
			'priority' => 110,
			'choices'  => array(
				'one'   => __( 'One column', 'penbird' ),
				'two'   => __( 'Two columns', 'penbird' ),
				'three' => __( 'Three columns', 'penbird' ),
			),
			'icons'   => array(
				'one'   => penbird_customizer_icon( 'footer-one' ),
				'two'   => penbird_customizer_icon( 'footer-two' ),
				'three' => penbird_customizer_icon( 'footer-three' ),
			),
		)
	)
);

$wp_customize->add_setting(
	'penbird_footer_alignment',
	array(
		'default'           => 'center',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Visual_Radio_Control(
		$wp_customize,
		'penbird_footer_alignment',
		array(
			'label'    => __( 'Bottom Bar Alignment', 'penbird' ),
			'section'  => 'penbird_footer',
			'priority' => 120,
			'choices'  => array(
				'left'   => __( 'Left', 'penbird' ),
				'center' => __( 'Center', 'penbird' ),
				'right'  => __( 'Right', 'penbird' ),
			),
			'icons'   => array(
				'left'   => penbird_customizer_icon( 'align-left' ),
				'center' => penbird_customizer_icon( 'align-center' ),
				'right'  => penbird_customizer_icon( 'align-right' ),
			),
		)
	)
);

$wp_customize->add_setting(
	'penbird_footer_widgets',
	array(
		'default'           => true,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_checkbox',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Toggle_Control(
		$wp_customize,
		'penbird_footer_widgets',
		array(
			'label'    => __( 'Show Footer Widgets', 'penbird' ),
			'section'  => 'penbird_footer',
			'priority' => 130,
		)
	)
);

$wp_customize->add_setting(
	'penbird_footer_copyright',
	array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_footer_copyright',
	array(
		'label'       => __( 'Copyright Text', 'penbird' ),
		'description' => __( 'Leave empty for the default “All Right Reserved” text. Site name and year are appended automatically.', 'penbird' ),
		'section'     => 'penbird_footer',
		'priority'    => 140,
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'penbird_footer_credit',
	array(
		'default'           => true,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_checkbox',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Toggle_Control(
		$wp_customize,
		'penbird_footer_credit',
		array(
			'label'    => __( 'Show Developer Credit', 'penbird' ),
			'section'  => 'penbird_footer',
			'priority' => 150,
		)
	)
);

$wp_customize->add_setting(
	'penbird_footer_bg',
	array(
		'default'           => '#F6F9FC',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_hex_color',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'penbird_footer_bg',
		array(
			'label'    => __( 'Footer Widgets Background', 'penbird' ),
			'section'  => 'penbird_footer',
			'priority' => 160,
		)
	)
);
