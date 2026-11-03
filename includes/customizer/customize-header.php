<?php
/**
 * PenBird Header Customizer section.
 *
 * Controls the real frontend header in header.php.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

penbird_add_customize_section(
	$wp_customize,
	'penbird_header',
	array(
		'capability'  => 'edit_theme_options',
		'priority'    => 10,
		'title'       => __( 'Manage Header', 'penbird' ),
		'description' => __( 'Free header options. Changes apply to the live PenBird header in the preview.', 'penbird' ),
		'panel'       => 'penbird_front_option',
		'section'     => 'penbird_panel_header_footer',
	)
);

$wp_customize->add_setting(
	'penbird_header_layout',
	array(
		'default'           => 'logo-menu',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Visual_Radio_Control(
		$wp_customize,
		'penbird_header_layout',
		array(
			'label'    => __( 'Header Layout', 'penbird' ),
			'section'  => 'penbird_header',
			'priority' => 10,
			'choices'  => array(
				'logo-menu' => __( 'Logo + Menu', 'penbird' ),
				'centered'  => __( 'Centered', 'penbird' ),
				'split'     => __( 'Logo | Menu | Icons', 'penbird' ),
			),
			'icons'    => array(
				'logo-menu' => penbird_customizer_icon( 'header-logo-menu' ),
				'centered'  => penbird_customizer_icon( 'header-centered' ),
				'split'     => penbird_customizer_icon( 'header-split' ),
			),
		)
	)
);

$wp_customize->add_setting(
	'penbird_header_width',
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
		'penbird_header_width',
		array(
			'label'       => __( 'Header Width', 'penbird' ),
			'description' => __( 'Boxed uses the PenBird .container. Full uses the full viewport width.', 'penbird' ),
			'section'     => 'penbird_header',
			'priority'    => 20,
			'columns'     => 2,
			'choices'     => array(
				'boxed' => __( 'Boxed', 'penbird' ),
				'full'  => __( 'Full Width', 'penbird' ),
			),
			'icons'       => array(
				'boxed' => penbird_customizer_icon( 'header-width-boxed' ),
				'full'  => penbird_customizer_icon( 'header-width-full' ),
			),
		)
	)
);

$wp_customize->add_setting(
	'penbird_header_logo_position',
	array(
		'default'           => 'left',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Visual_Radio_Control(
		$wp_customize,
		'penbird_header_logo_position',
		array(
			'label'       => __( 'Logo Position', 'penbird' ),
			'description' => __( 'Places the logo in the existing header bar. Split layout keeps the logo on the left.', 'penbird' ),
			'section'     => 'penbird_header',
			'priority'    => 30,
			'choices'     => array(
				'left'   => __( 'Left', 'penbird' ),
				'center' => __( 'Center', 'penbird' ),
				'right'  => __( 'Right', 'penbird' ),
			),
			'icons'       => array(
				'left'   => penbird_customizer_icon( 'logo-left' ),
				'center' => penbird_customizer_icon( 'logo-center' ),
				'right'  => penbird_customizer_icon( 'logo-right' ),
			),
		)
	)
);

$wp_customize->add_setting(
	'penbird_header_menu_align',
	array(
		'default'           => 'right',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_select',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Visual_Radio_Control(
		$wp_customize,
		'penbird_header_menu_align',
		array(
			'label'    => __( 'Menu Alignment', 'penbird' ),
			'section'  => 'penbird_header',
			'priority' => 40,
			'choices'  => array(
				'left'   => __( 'Left', 'penbird' ),
				'center' => __( 'Center', 'penbird' ),
				'right'  => __( 'Right', 'penbird' ),
			),
			'icons'    => array(
				'left'   => penbird_customizer_icon( 'align-left' ),
				'center' => penbird_customizer_icon( 'align-center' ),
				'right'  => penbird_customizer_icon( 'align-right' ),
			),
		)
	)
);

$wp_customize->add_setting(
	'penbird_search_enable',
	array(
		'default'           => true,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_checkbox',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Toggle_Control(
		$wp_customize,
		'penbird_search_enable',
		array(
			'label'    => __( 'Enable Search', 'penbird' ),
			'section'  => 'penbird_header',
			'priority' => 50,
		)
	)
);

$wp_customize->add_setting(
	'penbird_header_cart',
	array(
		'default'           => true,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_checkbox',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Toggle_Control(
		$wp_customize,
		'penbird_header_cart',
		array(
			'label'       => __( 'Show WooCommerce Cart', 'penbird' ),
			'description' => __( 'Displayed when WooCommerce is active.', 'penbird' ),
			'section'     => 'penbird_header',
			'priority'    => 60,
		)
	)
);

$wp_customize->add_setting(
	'penbird_header_sticky',
	array(
		'default'           => false,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_checkbox',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new PenBird_Customize_Toggle_Control(
		$wp_customize,
		'penbird_header_sticky',
		array(
			'label'    => __( 'Sticky Header', 'penbird' ),
			'section'  => 'penbird_header',
			'priority' => 70,
		)
	)
);

$wp_customize->add_setting(
	'penbird_header_bg',
	array(
		'default'           => '#ffffff',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_hex_color',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'penbird_header_bg',
		array(
			'label'    => __( 'Header Background', 'penbird' ),
			'section'  => 'penbird_header',
			'priority' => 80,
		)
	)
);

$wp_customize->add_setting(
	'penbird_header_color',
	array(
		'default'           => '#0A2540',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_hex_color',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'penbird_header_color',
		array(
			'label'       => __( 'Header Text Color', 'penbird' ),
			'description' => __( 'Site title, menu, and header icons. Uses the PenBird heading color by default.', 'penbird' ),
			'section'     => 'penbird_header',
			'priority'    => 90,
		)
	)
);

$wp_customize->add_setting(
	'penbird_header_padding',
	array(
		'default'           => 15,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'penbird_sanitize_number_range',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'penbird_header_padding',
	array(
		'label'       => __( 'Header Vertical Padding (px)', 'penbird' ),
		'section'     => 'penbird_header',
		'priority'    => 100,
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 80,
			'step' => 1,
		),
	)
);
