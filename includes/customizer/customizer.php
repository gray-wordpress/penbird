<?php
/**
 * Theme Customizer
 *
 * @package PenBird
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function penbird_customize_register( $wp_customize ) {
	if ( $wp_customize->get_setting( 'blogname' ) ) {
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	}
	if ( $wp_customize->get_setting( 'blogdescription' ) ) {
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}
	if ( $wp_customize->get_setting( 'header_textcolor' ) ) {
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a, .penbird-logo .normal-text a',
				'render_callback' => 'penbird_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'penbird_customize_partial_blogdescription',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'penbird_footer_copyright',
			array(
				'selector'        => '.penbird-footer__site',
				'render_callback' => 'penbird_customize_partial_footer_copyright',
			)
		);
	}
}
add_action( 'customize_register', 'penbird_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function penbird_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function penbird_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render footer copyright for the selective refresh partial.
 *
 * @return void
 */
function penbird_customize_partial_footer_copyright() {
	echo wp_kses_post( penbird_get_footer_copyright_text() );
}

/**
 * Customizer preview script.
 */
function penbird_customize_preview_js() {
	wp_enqueue_script(
		'penbird-customizer',
		get_template_directory_uri() . '/resource/js/customizer.js',
		array( 'customize-preview', 'jquery' ),
		penbird_VERSION,
		true
	);

	wp_localize_script(
		'penbird-customizer',
		'penbirdCustomizePreview',
		array(
			'fonts' => penbird_get_font_stacks(),
		)
	);
}
add_action( 'customize_preview_init', 'penbird_customize_preview_js' );

/**
 * Customizer controls CSS/JS (scoped to the Customizer).
 */
function penbird_customize_controls_assets() {
	$controls_css = get_template_directory() . '/resource/css/customizer.css';
	wp_enqueue_style(
		'penbird-customizer',
		get_template_directory_uri() . '/resource/css/customizer.css',
		array(),
		file_exists( $controls_css ) ? filemtime( $controls_css ) : penbird_VERSION
	);

	$controls_js = get_template_directory() . '/resource/js/customizer-controls.js';
	wp_enqueue_script(
		'penbird-customizer-controls',
		get_template_directory_uri() . '/resource/js/customizer-controls.js',
		array( 'customize-controls', 'jquery' ),
		file_exists( $controls_js ) ? filemtime( $controls_js ) : penbird_VERSION,
		false
	);
}
add_action( 'customize_controls_enqueue_scripts', 'penbird_customize_controls_assets' );

require_once trailingslashit( get_template_directory() ) . 'includes/sanitize.php';

/**
 * Register PenBird Customizer panel and sections.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function penbird_register_customizer_front( $wp_customize ) {
	require_once __DIR__ . '/class-penbird-customize-section.php';
	require_once __DIR__ . '/class-penbird-customize-control.php';

	$wp_customize->register_section_type( 'PenBird_Customize_Section' );

	$wp_customize->add_panel(
		'penbird_front_option',
		array(
			'priority'    => 1,
			'capability'  => 'edit_theme_options',
			'title'       => __( 'PenBird: Theme Settings', 'penbird' ),
			'description' => __( 'PenBird Theme Settings grouped into Global, Header & Footer, Post & Page, and Other.', 'penbird' ),
		)
	);

	penbird_add_customize_section(
		$wp_customize,
		'penbird_panel_global',
		array(
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'title'       => __( 'Global Settings', 'penbird' ),
			'description' => __( 'Theme defaults, page breadcrumb, and typography.', 'penbird' ),
			'panel'       => 'penbird_front_option',
		)
	);

	penbird_add_customize_section(
		$wp_customize,
		'penbird_theme_default',
		array(
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'title'       => __( 'Theme Default', 'penbird' ),
			'description' => __( 'Global defaults used across the PenBird frontend.', 'penbird' ),
			'panel'       => 'penbird_front_option',
			'section'     => 'penbird_panel_global',
		)
	);

	penbird_add_customize_section(
		$wp_customize,
		'penbird_global_colors',
		array(
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'title'       => __( 'Color Settings', 'penbird' ),
			'description' => __( 'Global defaults used across the PenBird frontend.', 'penbird' ),
			'panel'       => 'penbird_front_option',
			'section'     => 'penbird_panel_global',
		)
	);

	penbird_add_customize_section(
		$wp_customize,
		'penbird_panel_layout',
		array(
			'priority'    => 15,
			'capability'  => 'edit_theme_options',
			'title'       => __( 'Layout / Container & Sidebar', 'penbird' ),
			'description' => __( 'Global container and default sidebar. Pages can override these from PenBird Page Settings.', 'penbird' ),
			'panel'       => 'penbird_front_option',
		)
	);

	penbird_add_customize_section(
		$wp_customize,
		'penbird_panel_header_footer',
		array(
			'priority'    => 20,
			'capability'  => 'edit_theme_options',
			'title'       => __( 'Header & Footer', 'penbird' ),
			'description' => __( 'Header and footer options for the live PenBird frontend.', 'penbird' ),
			'panel'       => 'penbird_front_option',
		)
	);

	penbird_add_customize_section(
		$wp_customize,
		'penbird_panel_post_page',
		array(
			'priority'    => 30,
			'capability'  => 'edit_theme_options',
			'title'       => __( 'Post & Page Settings', 'penbird' ),
			'description' => __( 'Post sidebar and related content layout. Pages can override these from the page editor.', 'penbird' ),
			'panel'       => 'penbird_front_option',
		)
	);

	penbird_add_customize_section(
		$wp_customize,
		'penbird_panel_other',
		array(
			'priority'    => 40,
			'capability'  => 'edit_theme_options',
			'title'       => __( 'Other Settings', 'penbird' ),
			'description' => __( 'Additional PenBird settings that do not belong in the groups above.', 'penbird' ),
			'panel'       => 'penbird_front_option',
		)
	);

	require __DIR__ . '/customize-logo.php';
	require __DIR__ . '/customize-header.php';
	require __DIR__ . '/customize-footer.php';
	require __DIR__ . '/customize-typography.php';
	require __DIR__ . '/customize-container.php';
	require __DIR__ . '/customize-breadcrumb.php';
	require __DIR__ . '/customize-post-sidebar.php';

	$wp_customize->add_setting(
		'penbird_post_excerpt',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 22,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'penbird_post_excerpt',
		array(
			'label'       => __( 'Post Excerpt Limit', 'penbird' ),
			'description' => __( 'Customize post excerpt limit, global limit is : 22', 'penbird' ),
			'section'     => 'penbird_theme_default',
			'settings'    => 'penbird_post_excerpt',
			'type'        => 'number',
			'priority'    => 10,
		)
	);


	$wp_customize->add_setting(
		'penbird_primary_color',
		array(
			'default'           => '#1a55f9',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'penbird_sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'penbird_primary_color',
			array(
				'label'       => __( 'Primary Color', 'penbird' ),
				'description' => __( 'Select global Primary Color. Uses the PenBird global Color by default.', 'penbird' ),
				'section'     => 'penbird_global_colors',
				'priority'    => 90,
			)
		)
	);

	$wp_customize->add_setting(
		'penbird_secondary_color',
		array(
			'default'           => '#000000',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'penbird_sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'penbird_secondary_color',
			array(
				'label'       => __( 'Heading Color', 'penbird' ),
				'description' => __( 'Select global Primary Color. Uses the PenBird global Color by default.', 'penbird' ),
				'section'     => 'penbird_global_colors',
				'priority'    => 90,
			)
		)
	);

	$wp_customize->add_setting(
		'penbird_text_color',
		array(
			'default'           => '#54595f',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'penbird_sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'penbird_text_color',
			array(
				'label'       => __( 'Text Color', 'penbird' ),
				'description' => __( 'Select global Text Color. Uses the PenBird global Color by default.', 'penbird' ),
				'section'     => 'penbird_global_colors',
				'priority'    => 100,
			)
		)
	);

	/**
	 * Allow later extensions to add Customizer controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	do_action( 'penbird_customize_register', $wp_customize );
}
add_action( 'customize_register', 'penbird_register_customizer_front' );

/**
 * Keep WordPress Site Identity outside PenBird: Theme Settings.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function penbird_keep_site_identity_outside_theme_settings( $wp_customize ) {
	$section = $wp_customize->get_section( 'title_tagline' );
	if ( $section && 0 === strpos( (string) $section->panel, 'penbird_' ) ) {
		$section->panel = '';
	}
}
add_action( 'customize_register', 'penbird_keep_site_identity_outside_theme_settings', 20 );
