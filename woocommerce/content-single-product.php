<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

?>

<div class="penbird-bc penbird-shop">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<ol class="penbird-bc__list">
					<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e('Home','penbird');?></a></li>
					<li class="breadcrumb-item">
						<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e('Shop','penbird');?></a>
					</li>
					<li class="breadcrumb-item active"><?php the_title(); ?></li>
				</ol>
			</div>
		</div>
	</div>
</div>



<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php get_template_part( 'woocommerce/theme-part/product-detail-layout' ); ?>

</div>

