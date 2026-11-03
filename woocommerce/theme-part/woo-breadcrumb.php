<?php





if ( ! isset( $post ) || ! is_a( $post, 'WP_Post' ) ) {
    $post = get_queried_object();
}

?>
    <div class="cs_breadcamp_wrap cs_style_2 cs_accent_strong_bg cs_bg_filed">
        <div class="cs_breadcamp_in">

            <h1 class="cs_breadcamp_title cs_fs_36 cs_semibold cs_white_color">
                <?php 
                if (is_search()) {
                    echo esc_html__('Search Results for: ', 'penbird') . esc_html(get_search_query());
                } elseif (is_product_category() || is_tax()) {
                    single_term_title();
                } elseif (is_product()) {
                    echo esc_html( get_the_title() );
                } elseif (is_shop()) {
                    echo esc_html__('Shop', 'penbird');
                } else {
                    echo esc_html__('Shop', 'penbird');
                }
                ?>
            </h1>

            <div class="cs_breadcrumb_desc">
                <p>
                    <?php
                    if (is_product_category()) {

                        // Get category description
                        $term_description = term_description();

                        if (!empty(trim($term_description))) {
                            echo wp_kses_post($term_description);
                        } else {
                            echo esc_html__('Browse our product category collection and discover the best items curated for you.', 'penbird');
                        }

                    } elseif (is_shop()) {

                        echo esc_html__('Explore our shop and find the best products available for you.', 'penbird');

                    } elseif (is_tax() || is_archive()) {

                        echo esc_html__('Browse our latest archives and explore all available content.', 'penbird');
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
        <!-- Breadcrumbs -->



    
  


