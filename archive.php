<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PenBird
 */

get_header();
?>

	<?php if(get_theme_mod('penbird_archive_bc', true)) : ?>
		<div class="penbird-bc">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php $penbird_bc_archive_title = get_theme_mod('penbird_bc_archive_title'); ?>
						<?php if(!empty ($penbird_bc_archive_title)) :?>
						<h2 class="bc-title"><?php echo esc_html($penbird_bc_archive_title)?></h2>
						<?php else :?>
						<h2 class="bc-title"><?php the_archive_title(); ?></h2>
						<?php endif ;?>
						<div class="bc-list">
							<?php if (function_exists('bcn_display')) bcn_display(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<section class="penbird-blog-section site-archive">
		<div class="container">
			<div class="row penbird-layout-row">
				<div class="<?php echo esc_attr( penbird_content_class() ); ?>">
					<div class="row">
						<?php if ( have_posts() ) : ?>
							<?php
								/* Start the Loop */
								while ( have_posts() ) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'archive' );

							endwhile;

							else :
							get_template_part( 'template-parts/content', 'none' );

							endif;
						?>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="pagination-main">
								<?php if (function_exists("penbird_pagination")) :?>
									<?php penbird_pagination(); ?>
								<?php endif;?>
							</div>
						</div>
					</div>	
				</div>
				<?php penbird_render_sidebar(); ?>
			</div>
		</div>
	</section>

<?php
get_footer();
