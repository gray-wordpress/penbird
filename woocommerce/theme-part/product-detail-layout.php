<?php

defined( 'ABSPATH' ) || exit;

global $product;

$product_id = get_the_ID();


?>	
<div class="penbird-product-single">
	
	<div class="container">
		<?php get_template_part( 'woocommerce/theme-part/product-detail-upper' ); ?>
		<?php get_template_part( 'woocommerce/theme-part/product-detail-body' ); ?>

		<?php woocommerce_output_related_products();?>
	</div>
							
	

</div>

