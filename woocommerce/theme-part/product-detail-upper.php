<?php

defined( 'ABSPATH' ) || exit;

global $product;

$product_id = get_the_ID();

$regular_price = (float) $product->get_regular_price();
$sale_price    = (float) $product->get_sale_price();
$price_html    = $product->get_price_html();

$has_discount = $product->is_on_sale() && $regular_price > $sale_price;
$discount_percent = 0;
if ( $has_discount ) {
	$discount_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
}

// Get the first product category
$terms = get_the_terms( $product->get_id(), 'product_cat' );
$category_name = !empty($terms) ? $terms[0]->name : '';

// Get rating
$average_rating = $product->get_average_rating();
$review_count   = $product->get_review_count();

// Get total sales
$total_sales = $product->get_total_sales();
$total_sales_display = $total_sales >= 1000 ? round($total_sales / 1000, 1) . 'K' : $total_sales;

$short_description = $product->get_short_description();
?>	

<div class="row Penbird_gap_y_40">
    <div class="col-lg-5">
        <div class="penbird-woocommerce-gallery">
            <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="penbird-pdetail Penbird_style_1">
            <div class="penbird-pdetail__top">
                <?php if ( $category_name ) : ?>
                <p class="Penbird_product_category"><?php echo esc_html( $category_name ); ?></p>
                <?php endif; ?>
                    <?php
                    $brands = get_the_terms( get_the_ID(), 'product_brand' );

                    if ( ! empty( $brands ) && ! is_wp_error( $brands ) ) :
                        $brand = $brands[0];

                        // Get brand image (if saved as term meta)
                        $thumbnail_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );
                        $image_url    = wp_get_attachment_url( $thumbnail_id );

                        $brand_link = get_term_link( $brand );
                    ?>
                    <div class="penbird-pdetail__brand">
                        <a href="<?php echo esc_url( $brand_link ); ?>">
                            <?php if ( $image_url ) : ?>
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>">
                            <?php endif; ?>
                            <?php echo esc_html( $brand->name ); ?>
                        </a>
                        </div>
                    <?php endif; ?>
                
            </div>
           

            <h2 class="penbird-pdetail__title"><?php the_title(); ?></h2>

            
            <div class="penbird-pdetail__price">
                <div class="penbird-pdetail__price-main">
                    <?php
                    if ( $product->is_type( 'variable' ) ) {
                        // WooCommerce will output price range (or sale range)
                        echo wp_kses_post( $product->get_price_html() );
                    } else {
                        echo wp_kses_post( wc_price( $product->get_price() ) );
                    }
                    ?>
                </div>
                
                <?php if ( $product->is_type( 'simple' ) ) : ?>
                    <?php if ( $has_discount ) : ?>
                        <div class="penbird-pdetail__price-discount">
                            <span class="penbird-pdetail__price-discount-percent">
                                <?php echo esc_html( $discount_percent ); ?>%
                            </span>
                            <small class="penbird-pdetail__price-discount-main ">
                                <?php echo wp_kses_post( wc_price( $regular_price ) ); ?>
                            </small>
                        </div>
                    <?php endif; ?>
                <?php endif;?>
            </div>
            
            
            
            <ul class="penbird-pdetail__meta">
                <li>
                    <div class="Penbird_product_ratings">
                        <div class="Penbird_rating" data-rating="<?php echo esc_attr( $average_rating ); ?>">
                            <div class="Penbird_rating_percentage" style="width: <?php echo esc_attr( ( $average_rating / 5 ) * 100 ); ?>%;"></div>
                        </div>
                        <div class="Penbird_rating_number Penbird_ternary_color Penbird_fs_14 Penbird_light">
                            <span>(<?php echo esc_html( number_format( $average_rating, 1 ) ); ?>/5)</span>
                        </div>
                    </div>
                </li>
                <li><span><?php echo esc_html( $review_count ); ?></span> <?php esc_html_e('Reviews', 'penbird');?></li>
                <li><span><?php echo esc_html( $total_sales_display ); ?></span> <?php esc_html_e('Sold', 'penbird');?></li>
            </ul>

            
             <?php if ( $product->is_type( 'simple' ) ) : ?>
            <form class="cart penbird-woo-form" method="post" enctype="multipart/form-data">
                <div class="penbird-pdetail__qt">
                    <div class="Penbird_light"><?php esc_html_e('QUANTITY', 'penbird');?></div>
                    <div>
                        <div class="Penbird_quantity Penbird_style_1">
                            <button type="button" class="Penbird_quantity_button Penbird_decrement">
                                <svg width="12" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.580007 1.18555C0.425021 1.18215 0.277528 1.11823 0.169117 1.00742C0.0607065 0.896604 0 0.74771 0 0.592687C0 0.437664 0.0607065 0.288839 0.169117 0.178028C0.277528 0.0672157 0.425021 0.00322354 0.580007 -0.000172257H11.249C11.404 0.00322354 11.5515 0.0672157 11.6599 0.178028C11.7683 0.288839 11.829 0.437664 11.829 0.592687C11.829 0.74771 11.7683 0.896604 11.6599 1.00742C11.5515 1.11823 11.404 1.18215 11.249 1.18555H0.580007Z" fill="currentColor"></path>
                                </svg>
                            </button>

                            <input type="number" name="quantity" class="Penbird_quantity_input Penbird_primary_color Penbird_medium" value="1" min="1" />

                            <button type="button" class="Penbird_quantity_button Penbird_increment">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.4141 6.91406H8.08594V0.585938C8.08594 0.262324 7.82361 0 7.5 0C7.17639 0 6.91406 0.262324 6.91406 0.585938V6.91406H0.585938C0.262324 6.91406 0 7.17639 0 7.5C0 7.82361 0.262324 8.08594 0.585938 8.08594H6.91406V14.4141C6.91406 14.7377 7.17639 15 7.5 15C7.82361 15 8.08594 14.7377 8.08594 14.4141V8.08594H14.4141C14.7377 8.08594 15 7.82361 15 7.5C15 7.17639 14.7377 6.91406 14.4141 6.91406Z" fill="currentColor"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="Penbird_height_50 Penbird_height_lg_40"></div>

                <div class="penbird-pdetail__buttons">
                    <input type="hidden" name="add-to-cart" value="<?php echo absint( get_the_ID() ); ?>" />

                    <button type="submit" class="penbird-btn-default penbird-btn-default__primary">
                        <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.4994 10.15C6.62507 10.151 5.77741 9.86171 5.10077 9.33137C4.42412 8.80103 3.96034 8.06245 3.78838 7.24139C3.77468 7.15491 3.78077 7.0666 3.80623 6.98259C3.8317 6.89858 3.87593 6.82088 3.93586 6.75487C3.99579 6.68886 4.06999 6.63611 4.15332 6.60029C4.23665 6.56448 4.32711 6.54644 4.41844 6.54743C4.56854 6.54534 4.71448 6.59464 4.82999 6.68647C4.9455 6.77829 5.02299 6.9066 5.04849 7.04829C5.16715 7.59074 5.4771 8.07756 5.92627 8.42698C6.37545 8.77639 6.93649 8.96712 7.51515 8.96712C8.09381 8.96712 8.65485 8.77639 9.10403 8.42698C9.5532 8.07756 9.86315 7.59074 9.98181 7.04829C10.0073 6.9066 10.0848 6.77829 10.2003 6.68647C10.3158 6.59464 10.4618 6.54534 10.6119 6.54743C10.7032 6.54644 10.7937 6.56448 10.877 6.60029C10.9603 6.63611 11.0345 6.68886 11.0944 6.75487C11.1544 6.82088 11.1986 6.89858 11.2241 6.98259C11.2495 7.0666 11.2556 7.15491 11.2419 7.24139C11.0689 8.06756 10.6005 8.81007 9.91737 9.341C9.23422 9.87193 8.37912 10.158 7.4994 10.15Z"></path>
                            <path d="M13.1075 18.1033H1.89252C1.63615 18.1037 1.38239 18.054 1.14668 17.9574C0.910966 17.8608 0.698235 17.7193 0.521424 17.5415C0.344612 17.3637 0.207417 17.1533 0.118184 16.9231C0.0289511 16.6929 -0.0104547 16.4477 0.00236435 16.2025L0.512708 5.79904C0.533829 5.33263 0.742257 4.89207 1.09447 4.56935C1.44668 4.24663 1.91544 4.0667 2.40287 4.06714H12.5971C13.0846 4.0667 13.5533 4.24663 13.9055 4.56935C14.2577 4.89207 14.4662 5.33263 14.4873 5.79904L14.9976 16.2025C15.0105 16.4477 14.9711 16.6929 14.8818 16.9231C14.7926 17.1533 14.6554 17.3637 14.4786 17.5415C14.3018 17.7193 14.089 17.8608 13.8533 17.9574C13.6176 18.054 13.3639 18.1037 13.1075 18.1033ZM2.40287 5.28007C2.23577 5.28007 2.07551 5.34365 1.95735 5.45682C1.8392 5.56999 1.77281 5.72347 1.77281 5.88352L1.26247 16.2628C1.2582 16.3446 1.27133 16.4263 1.30108 16.503C1.33082 16.5798 1.37655 16.6499 1.43549 16.7092C1.49443 16.7684 1.56534 16.8156 1.64391 16.8478C1.72248 16.88 1.80707 16.8966 1.89252 16.8964H13.1075C13.1929 16.8966 13.2775 16.88 13.3561 16.8478C13.4347 16.8156 13.5056 16.7684 13.5645 16.7092C13.6234 16.6499 13.6692 16.5798 13.6989 16.503C13.7287 16.4263 13.7418 16.3446 13.7375 16.2628L13.2272 5.85938C13.2272 5.69934 13.1608 5.54585 13.0426 5.43268C12.9245 5.31951 12.7642 5.25593 12.5971 5.25593L2.40287 5.28007Z" ></path>
                            <path d="M11.2794 4.67672H10.0193V3.62069C10.0193 2.98051 9.75376 2.36655 9.28113 1.91388C8.8085 1.46121 8.16747 1.2069 7.49907 1.2069C6.83067 1.2069 6.18964 1.46121 5.71701 1.91388C5.24438 2.36655 4.97886 2.98051 4.97886 3.62069V4.67672H3.71875V3.62069C3.71875 2.66042 4.11703 1.73949 4.82598 1.06048C5.53493 0.381464 6.49647 0 7.49907 0C8.50167 0 9.46321 0.381464 10.1722 1.06048C10.8811 1.73949 11.2794 2.66042 11.2794 3.62069V4.67672Z" ></path>
                        </svg>
                        <?php esc_html_e('ADD TO BAG', 'penbird'); ?>
                    </button>

                    <button type="submit" name="buy_now" value="1" class="penbird-btn-default">
                        <svg width="80" height="80" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path d="M1.56641 4.48242C1.56641 4.06821 1.90219 3.73242 2.31641 3.73242H3.49696C4.61854 3.73242 5.56885 4.55844 5.72504 5.6691L5.7862 6.10403H19.7507C21.3714 6.10403 22.4605 7.76586 21.8137 9.25196L19.1464 15.3803C18.789 16.2014 17.9788 16.7324 17.0833 16.7324L7.72179 16.7324C6.60021 16.7324 5.6499 15.9064 5.49371 14.7957L4.23965 5.87798C4.18759 5.50776 3.87082 5.23242 3.49696 5.23242H2.31641C1.90219 5.23242 1.56641 4.89664 1.56641 4.48242Z"/>
                            <g opacity="0.4">
                            <path d="M7.7832 18.2324C6.8167 18.2324 6.0332 19.0159 6.0332 19.9824C6.0332 20.9489 6.8167 21.7324 7.7832 21.7324H7.7932C8.7597 21.7324 9.5432 20.9489 9.5432 19.9824C9.5432 19.0159 8.7597 18.2324 7.7932 18.2324H7.7832Z"/>
                            <path d="M16.3203 18.2324C15.3538 18.2324 14.5703 19.0159 14.5703 19.9824C14.5703 20.9489 15.3538 21.7324 16.3203 21.7324H16.3303C17.2968 21.7324 18.0803 20.9489 18.0803 19.9824C18.0803 19.0159 17.2968 18.2324 16.3303 18.2324H16.3203Z" />
                            </g>
                        </svg>

                        <?php esc_html_e('BUY NOW', 'penbird'); ?>
                    </button>

                    <?php if ( defined( 'YITH_WCWL' ) ) : ?>
                        <button type="button" class="penbird-btn-default">
                            <?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
                        </button>
                    <?php endif; ?>

                </div>
            </form>
            <?php else : ?>
                <?php
                // Use WooCommerce default form for variable, grouped, or external
                do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' );
                ?>

            <?php endif;?>            

            <div class="penbird-pdetail__list">
               <?php
                if ( ! empty( trim( $short_description ) ) ) :
                ?>
                    <div class="penbird-pdetail__content">
                        <b><?php esc_html_e( 'Brief Description', 'penbird' ); ?></b>
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_short_description', $short_description ) ); ?>
                    </div>
                <?php endif; ?>
                <?php
                    if ( $product && $product->get_attributes() ) {
                        foreach ( $product->get_attributes() as $attribute ) {

                            // Skip if it's not visible (e.g. used only for variations)
                            if ( ! $attribute->get_visible() ) {
                                continue;
                            }

                            $name = wc_attribute_label( $attribute->get_name() ); // Pretty name
                            $value = '';

                            if ( $attribute->is_taxonomy() ) {
                                $terms = wp_get_post_terms( $product->get_id(), $attribute->get_name(), ['fields' => 'names'] );
                                $value = implode( ', ', $terms );
                            } else {
                                $value = $attribute->get_options() ? implode( ', ', $attribute->get_options() ) : '';
                            }

                            echo '<li><b class="Penbird_semibold Penbird_primary_color">'. esc_html( $name ) .'</b> '. esc_html( $value ) .'</li>';
                        }
                    }
                ?>
                <div>
               <b class="Penbird_semibold Penbird_primary_color">
                    <?php esc_html_e('Stock', 'penbird'); ?>
                </b>

                <?php if ( $product->is_in_stock() ) : ?>

                    <?php
                    $qty = $product->get_stock_quantity();
                    echo $qty !== null
                        ? esc_html( $qty )
                        : esc_html__( 'In Stock', 'penbird' );
                    ?>
                <?php else : ?>
                    <?php esc_html_e( 'Out of Stock', 'penbird' ); ?>
                <?php endif; ?>
                </div>
            </div>



            
           

        </div>
    </div>
</div>