<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PenBird
 */
$penbird_categories = get_the_category();
?>
<div class="<?php if(is_active_sidebar('sidebar')):?> col-lg-6 col-md-6 col-12 <?php else :?> col-lg-4 col-md-6 col-12 <?php endif;?>   penbird-masonry-item">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="penbird-single-post margin-top-45">
			<?php if(has_post_thumbnail()) : ?>	
			<div class="penbird-single-post__head">
				<div class="penbird-single-post__comments"><i class="fa fa-comments"></i><?php echo esc_html(get_comments_number());?></div>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('penbird-blog-thumb'); ?></a>
			</div>
			<?php endif; ?>
			<div class="penbird-single-post__body">
				
				<?php if (!empty($penbird_categories)) :?>
				<div class="penbird-single-post__cat">
					<?php foreach ($penbird_categories as $penbird_category) :?>
						<a href="<?php echo esc_url(get_category_link($penbird_category->term_id));?>"><?php echo esc_html($penbird_category->name); ?></a>
					<?php endforeach;?>	
				</div>
				<?php endif;?>

				<h2 class="penbird-single-post__title">
				<?php if( is_sticky()) :?><span class="penbird-sticky"><i class="fa-regular fa-note-sticky"></i></span><?php endif;?>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				
				<div class="penbird-single-post__content"><?php the_excerpt();?></div>
				<!-- Post Meta -->
				<ul class="penbird-post-meta">
					<li><i class="fa fa-pencil"></i><?php penbird_posted_on(); ?></li>
					<li><i class="fa fa-user" aria-hidden="true"></i><?php penbird_posted_by(); ?></li>
				</ul>
				<div class="penbird-single-post__button">
					<a href="<?php the_permalink(); ?>" class="penbird-btn"><?php esc_html_e('View Article','penbird');?></a>
				</div>
			</div>
		</div>
	</article> <!-- #post-<?php the_ID(); ?> -->
</div>
