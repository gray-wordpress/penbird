<?php 

defined( 'ABSPATH' ) || exit;

global $product, $post;


$average_rating = (float) $product->get_average_rating();
$review_count   = (int) $product->get_review_count();

$has_attributes = ! empty( $product->get_attributes() );

$reviews = get_comments([
    'post_id' => $product->get_id(),
    'status'  => 'approve',
    'type'    => 'review',
]);

$ratings = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

foreach ( $reviews as $review ) {
    $rating = (int) get_comment_meta( $review->comment_ID, 'rating', true );

    if ( $rating >= 1 && $rating <= 5 ) {
        $ratings[$rating]++;
    }
}

$total_reviews = array_sum( $ratings );

$percentages = array_map(
    static function ( $count ) use ( $total_reviews ) {
        return $total_reviews ? round( ( $count / $total_reviews ) * 100 ) : 0;
    },
    $ratings
);

?>
    <div class="penbird-ptabs cs_type_1 cs_gray_bg">

        <ul class="penbird-ptabs__nav cs_style_1">
            <li class="active"><a href="#tab_1"><?php esc_html_e('Description', 'penbird');?></a></li>
            <?php if ( $has_attributes ) : ?>
            <li><a href="#tab_2"><?php esc_html_e('Additonal Information', 'penbird');?></a></li>
            <?php endif;?>
            <li><a href="#tab_3"><?php esc_html_e('Reviews', 'penbird');?></a></li>
        </ul>
    
        <div class="penbird-ptabs__body">
            
            <div class="penbird-ptabs__single active" id="tab_1">
                <div class="penbird-ptabs__single-content penbird-pdetail__content">
                    <?php the_content();?>
                </div>
            </div>
            
            <?php if ( $has_attributes ) : ?>
            <div class="penbird-ptabs__single" id="tab_2">
                <div class="penbird-ptabs__single-content penbird-pdetail__content">

                    <table class="shop_attributes additional-information-table">

                        <?php foreach ( $product->get_attributes() as $attribute ) : ?>

                            <?php
                            if ( $attribute->is_taxonomy() ) {
                                $values = wc_get_product_terms(
                                    $product->get_id(),
                                    $attribute->get_name(),
                                    [ 'fields' => 'names' ]
                                );
                            } else {
                                $values = $attribute->get_options();
                            }

                            if ( empty( $values ) ) {
                                continue;
                            }
                            ?>

                            <tr>
                                <th>
                                    <?php echo esc_html(
                                        wc_attribute_label(
                                            $attribute->get_name()
                                        )
                                    ); ?>
                                </th>
                                <td>
                                    <?php echo esc_html(
                                        implode( ', ', $values )
                                    ); ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </table>

                </div>
                
            </div>
            <?php endif; ?>
            
            <div class="penbird-ptabs__single" id="tab_3">
                
                <div class="penbird-ptabs__single-content penbird-pdetail__content">
                    <div class="penbird-ptabs__reviews">
                        <?php
                        // Get all reviews grouped by rating
                        $ratings = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
                        $comments = get_comments(['post_id' => $product->get_id(), 'status' => 'approve']);
                        foreach ($comments as $comment) {
                            $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
                            if ($rating >= 1 && $rating <= 5) {
                                $ratings[$rating]++;
                            }
                        }

                        // Calculate percentage for each rating
                        $total = array_sum($ratings);
                        $percentages = array_map(function($count) use ($total) {
                            return $total > 0 ? round(($count / $total) * 100) : 0;
                        }, $ratings);
                    ?>

                    <div class="cs_review_card_wrap_1">
                        <div class="cs_review_card_1">
                            <div class="cs_review_card_left">
                                <h3 class="cs_secondary_font cs_medium cs_fs_24 mb-0"><?php esc_html_e('Reviews', 'penbird');?></h3>
                                <div class="cs_height_10 cs_height_lg_10"></div>
                                <p class="cs_fs_70 cs_medium cs_primary_color mb-0"><?php echo esc_html( number_format( $average_rating, 1 ) ); ?>/5</p>
                                <div class="cs_height_24 cs_height_lg_24"></div>
                                <div class="cs_averate_rating_wrap_1">
                                    <div class="cs_rating" data-rating="<?php echo esc_attr($average_rating); ?>">
                                        <div class="cs_rating_percentage" style="width: <?php echo esc_attr( ( $average_rating / 5 ) * 100 ); ?>%;"></div>
                                    </div>
                                    <div class="cs_rating_number cs_ternary_color cs_fs_18">
                                        <span class="cs_fs_18 cs_primary_color"><?php echo esc_html( $review_count ); ?></span>
                                        <span class="cs_fs_14 cs_ternary_color cs_light"><?php esc_html_e('Reviews', 'penbird');?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="cs_review_card_right">
                                <ul class="cs_review_list cs_light cs_primary_color cs_mp_0">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <li>
                                        <span><?php echo esc_html( $i ); ?></span>
                                        <i class="fa-solid fa-star cs_accent_color" aria-hidden="true"></i>
                                        <div class="cs_progress" data-progress="<?php echo esc_attr( $percentages[ $i ] ); ?>">
                                            <div class="cs_progress_in" style="width: <?php echo esc_attr( $percentages[ $i ] ); ?>%;"></div>
                                        </div>
                                        <span><?php echo esc_html( $ratings[ $i ] ); ?></span>
                                    </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?php
                    $comments = get_comments([
                        'post_id' => $product->get_id(),
                        'status'  => 'approve',
                        'type'    => 'review',
                        'number'  => 5, // You can paginate or change this
                    ]);

                    if ( $comments ): ?>
                    <div class="col-12  cs_product_review_2">
                        <div class="cs_sort_by_wrap p-0">
                            <div class="cs_sort_by_title">
                                <?php esc_html_e('All Comments', 'penbird');?>
                            </div>
                        </div>
                        <div class="cs_height_30 cs_height_lg_30"></div>

                        <ul class="cs_product_review_list cs_mp_0">
                            <?php foreach ( $comments as $comment ) :
                                $rating = intval(get_comment_meta( $comment->comment_ID, 'rating', true ));
                                $author = $comment->comment_author;
                                $date = date_i18n( 'F j, Y', strtotime( $comment->comment_date ) );
                                $content = esc_html( $comment->comment_content );
                                ?>
                                <li>
                                    <div class="cs_product_review cs_light">
                                        <div class="cs_product_review_info">
                                            <div class="cs_product_review_media">
                                                <img src="<?php echo esc_url( get_avatar_url( $comment->user_id, array( 'size' => 64 ) ) ); ?>" alt="<?php echo esc_attr( $author ); ?>">
                                                <div class="cs_product_review_media_right">
                                                    <h3 class="cs_secondary_font cs_fs_16 cs_medium"><?php echo esc_html( $author ); ?></h3>
                                                    <div class="cs_product_ratings">
                                                        <div class="cs_rating" data-rating="<?php echo esc_attr($rating); ?>">
                                                            <div class="cs_rating_percentage" style="width: <?php echo esc_attr( ( $rating / 5 ) * 100 ); ?>%;"></div>
                                                        </div>
                                                        <div class="cs_rating_number cs_ternary_color cs_fs_14">
                                                            <span>(<?php echo esc_html( $rating ); ?>/5)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cs_product_review_date cs_fs_14"><?php echo esc_html( $date ); ?></div>
                                        </div>
                                        <div class="cs_product_review_text"><?php echo $content; ?></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="cs_review_form">
                                    <?php
                                        if ( comments_open() && wc_review_ratings_enabled() ) {
                                            comments_template();
                                        }
                                    ?>
                            </div>
                        </div>	
                    </div>
                    
                </div>
            </div>

        </div>

    </div>