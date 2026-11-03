<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PenBird
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-content-main' ); ?>>
		<div class="blog-head">
			<?php the_post_thumbnail( 'penbird-blog-single-thumb' ); ?>
		</div>
		<div class="blog-body">
			<h1 class="blog-heading"><?php the_title(); ?></h1>
			<div class="blog-meta">
				<ul class="list">
					<li><i class="fa fa-pencil" aria-hidden="true"></i><?php penbird_posted_on(); ?></li>
					<li><i class="fa fa-user" aria-hidden="true"></i><?php penbird_posted_by(); ?></li>
					<li><i class="fa-regular fa-calendar" aria-hidden="true"></i><?php echo esc_html( get_the_date() ); ?> </li>
					<li><i class="fa fa-comments" aria-hidden="true"></i><?php echo esc_html( get_comments_number() ); ?> <?php esc_html_e( 'comments', 'penbird' ); ?></li>
				</ul>
			</div>
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'penbird' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</article>
