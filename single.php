<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Penbird
 */

get_header();
?>

	<div class="penbird-bc">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2 class="bc-title"><?php the_title() ?></h2>
					<div class="bc-list">
						<?php if (function_exists('bcn_display')) bcn_display(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Blog Sinlge -->
	<section class="penbird-blog-single">
		<div class="container">
			<div class="row penbird-layout-row">
				<div class="<?php echo esc_attr( penbird_content_class() ); ?>">
					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'single' );

						the_post_navigation(
							array(
								'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'penbird' ) . '</span> <span class="nav-title">%title</span>',
								'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'penbird' ) . '</span> <span class="nav-title">%title</span>',
							)
						);

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
				</div>
				<?php penbird_render_sidebar(); ?>
			</div>
		</div>
	</section>
	<!--/ End Single -->
<?php
get_footer();
