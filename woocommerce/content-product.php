<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}



$average      = $product->get_average_rating();
$review_count = $product->get_review_count();




?>
<li <?php wc_product_class( 'penbird-product-layout__single', $product ); ?>>




	<div class="cs_grid_col">
		
		<div class="penbird-product-card cs_style_3 cs_radius_12">
			<?php if ( has_post_thumbnail() ) : ?>

			<div class="penbird-product-card__thumb cs_center">
				<img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
				<?php if ( $product->is_on_sale() ) : ?>
					<span class="penbird-product-card__sale-badge">
						<?php esc_html_e( 'Sale', 'penbird' ); ?>
					</span>
				<?php endif; ?>
			</div>
			<?php endif;?>
			<div class="penbird-product-card__content">
				<p class="penbird-product-card__price">
					<?php if ( $product->is_type( 'variable' ) ) : ?>
						<?php echo wp_kses_post( $product->get_price_html() ); ?>
					<?php else : ?>
						<?php if ( $product->is_on_sale() ) : ?>
							<?php echo wp_kses_post( wc_price( $product->get_sale_price() ) ); ?>
							<small><?php echo wp_kses_post( wc_price( $product->get_regular_price() ) ); ?></small>
						<?php else : ?>
							<?php echo wp_kses_post( wc_price( $product->get_regular_price() ) ); ?>
						<?php endif; ?>
					<?php endif; ?>
				</p>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><h2 class="penbird-product-card__title"><?php echo esc_html( get_the_title() ); ?></h2></a>
				<div class="penbird-product-card__bottom">
				<div class="penbird-product-card__cat">
					<?php 
						$terms = get_the_terms( get_the_ID(), 'product_cat' );
						if ( $terms && ! is_wp_error( $terms ) ) {
							foreach ( $terms as $term ) {
								$penbird_term_link = get_term_link( $term );
								if ( is_wp_error( $penbird_term_link ) ) {
									continue;
								}
								echo '<a href="' . esc_url( $penbird_term_link ) . '">' . esc_html( $term->name ) . '</a> ';
							}
						}
					?>
				
				</div>
				<span>-</span>
					<div class="cs_product_ratings">
						<div class="cs_rating" data-rating="<?php echo esc_attr($average); ?>">
							<div class="cs_rating_percentage" style="width: <?php echo esc_attr(($average / 5) * 100); ?>%;"></div>
						</div>
						<div class="cs_rating_number cs_ternary_color cs_fs_14 cs_light">
							<span>(<?php echo esc_html( number_format( $average, 1 ) ); ?>/5)</span>
							<span>| <?php echo esc_html($review_count); ?> <?php esc_html_e('Reviews','penbird');?></span>
						</div>
					</div>
				</div>
				
				<div class="penbird-product-card_btn">
					<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
				</div>
			</div>
		</div>

	</div>













	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	// do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	// do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	// do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
