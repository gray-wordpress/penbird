<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package PenBird
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function penbird_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$layout    = penbird_get_container_layout();
	$classes[] = 'penbird-layout-' . sanitize_html_class( $layout );

	if ( penbird_has_sidebar() ) {
		$classes[] = 'penbird-sidebar-' . sanitize_html_class( penbird_get_sidebar_position() );
	} else {
		$classes[] = 'no-sidebar';
		$classes[] = 'penbird-sidebar-none';
	}

	if ( is_page() ) {
		if ( penbird_is_page_element_disabled( 'header' ) ) {
			$classes[] = 'penbird-no-header';
		}
		if ( penbird_is_page_element_disabled( 'footer' ) ) {
			$classes[] = 'penbird-no-footer';
		}
		if ( penbird_is_page_element_disabled( 'title' ) ) {
			$classes[] = 'penbird-no-title';
		}
		if ( penbird_is_page_element_disabled( 'breadcrumb' ) ) {
			$classes[] = 'penbird-no-breadcrumb';
		}
	}

	$align = penbird_get_option( 'penbird_footer_alignment', 'center' );
	if ( in_array( $align, array( 'left', 'center', 'right' ), true ) ) {
		$classes[] = 'penbird-footer-align-' . sanitize_html_class( $align );
	}

	return $classes;
}
add_filter( 'body_class', 'penbird_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function penbird_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'penbird_pingback_header' );

/**
 * Check Elementor activation and usage.
 *
 * @return string
 */
function penbird_active() {
	if ( penbird_is_elementor_page() ) {
		return 'container-elementor';
	}

	return '';
}
add_action( 'init', 'penbird_active' );

/**
 * Build Customizer-driven CSS using PenBird root variables.
 *
 * @return string
 */
function penbird_get_dynamic_css() {
	$container_width = absint( penbird_get_option( 'penbird_container_width', 1280 ) );
	$content_width   = absint( penbird_get_option( 'penbird_content_width', 800 ) );
	$logo_width      = absint( penbird_get_option( 'penbird_logo_width', 170 ) );
	$header_padding  = absint( penbird_get_option( 'penbird_header_padding', 15 ) );
	$font_size       = absint( penbird_get_option( 'penbird_body_font_size', 16 ) );
	$body_weight     = absint( penbird_get_option( 'penbird_body_font_weight', '400' ) );
	$heading_weight  = absint( penbird_get_option( 'penbird_heading_font_weight', '500' ) );
	$header_bg       = penbird_get_option( 'penbird_header_bg', '#ffffff' );
	$header_color    = penbird_get_option( 'penbird_header_color', '#0A2540' );
	$footer_bg       = penbird_get_option( 'penbird_footer_bg', '#F6F9FC' );
	$primary_color   = penbird_get_option( 'penbird_primary_color', '#605BE5' );
	$heading_color   = penbird_get_option( 'penbird_secondary_color', '#0A2540' );
	$text_color      = penbird_get_option( 'penbird_text_color', '#696969' );
	$body_font       = penbird_get_font_stack( penbird_get_option( 'penbird_body_font', 'inter' ) );
	$heading_font    = penbird_get_font_stack( penbird_get_option( 'penbird_heading_font', 'inter' ) );

	$header_bg      = $header_bg ? $header_bg : '#ffffff';
	$header_color   = $header_color ? $header_color : '#0A2540';
	$footer_bg      = $footer_bg ? $footer_bg : '#F6F9FC';
	$primary_color  = $primary_color ? $primary_color : '#605BE5';
	$heading_color  = $heading_color ? $heading_color : '#0A2540';
	$text_color     = $text_color ? $text_color : '#696969';

	$css  = ':root{';
	$css .= '--penbird-primary:' . sanitize_hex_color( $primary_color ) . ';';
	$css .= '--penbird-heading:' . sanitize_hex_color( $heading_color ) . ';';
	$css .= '--penbird-text:' . sanitize_hex_color( $text_color ) . ';';
	$css .= '--penbird-container-width:' . $container_width . 'px;';
	$css .= '--penbird-content-width:' . $content_width . 'px;';
	$css .= '--penbird-logo-width:' . $logo_width . 'px;';
	$css .= '--penbird-header-padding:' . $header_padding . 'px;';
	$css .= '--penbird-header-bg:' . sanitize_hex_color( $header_bg ) . ';';
	$css .= '--penbird-header-color:' . sanitize_hex_color( $header_color ) . ';';
	$css .= '--penbird-footer-top-bg:' . sanitize_hex_color( $footer_bg ) . ';';
	$css .= '--penbird-font-body:' . $body_font . ';';
	$css .= '--penbird-font-heading:' . $heading_font . ';';
	$css .= '--penbird-font-size:' . $font_size . 'px;';
	$css .= '--penbird-font-weight:' . $body_weight . ';';
	$css .= '--penbird-heading-weight:' . $heading_weight . ';';
	$css .= '}';

	return $css;
}

/**
 * Attach dynamic CSS to the theme stylesheet.
 */
function penbird_dynamic_css() {
	wp_add_inline_style( 'penbird-style', penbird_get_dynamic_css() );
}
add_action( 'wp_enqueue_scripts', 'penbird_dynamic_css', 20 );
