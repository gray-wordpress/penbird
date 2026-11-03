<?php
/**
 * WooCommerce presentation adjustments.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Keep PenBird markup while leaving WooCommerce hooks available.
 */
function penbird_woocommerce_hooks() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
add_action( 'after_setup_theme', 'penbird_woocommerce_hooks', 20 );

/**
 * Send shoppers to checkout when they use the product Buy Now button.
 *
 * @param string $url Redirect URL.
 * @return string
 */
function penbird_buy_now_redirect( $url ) {
	if ( isset( $_REQUEST['buy_now'] ) && '1' === sanitize_text_field( wp_unslash( $_REQUEST['buy_now'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return wc_get_checkout_url();
	}

	return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'penbird_buy_now_redirect' );

/**
 * Terms for a shop filter, or an empty list when the taxonomy is missing.
 *
 * @param string $taxonomy Taxonomy name.
 * @return WP_Term[]
 */
function penbird_get_filter_terms( $taxonomy ) {
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
		)
	);

	if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
		return array();
	}

	return $terms;
}
