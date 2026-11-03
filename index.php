<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PenBird
 */

get_header();
?>
	<section class="penbird-main-content">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="penbird-main-area">
						<div class="row penbird-layout-row">
							<?php if ( penbird_has_sidebar() ) : ?>
							<div class="<?php echo esc_attr( penbird_content_class() ); ?>">
							<?php else : ?>
							<div class="col-12">
							<?php endif;?>
								<div class="penbird-post-content">
									<div class="row">
										<div class="col-12">
											<div class="penbird-home-layout">
												<div class="row penbird-masonry">
													<?php
													if ( have_posts() ) :
														if ( is_home() && ! is_front_page() ) :
															?>
															<header>
																<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
															</header>
															<?php
														endif;
														/* Start the Loop */
														while ( have_posts() ) :
															the_post();

															/*
															* Include the Post-Type-specific template for the content.
															* If you want to override this in a child theme, then include a file
															* called content-___.php (where ___ is the Post Type name) and that will be used instead.
															*/
															get_template_part( 'template-parts/content', get_post_type() );
														endwhile;
													else :
														get_template_part( 'template-parts/content', 'none' );
													endif;
													?>
												</div>	
											</div>	
										</div>	
									</div>
									<div class="row">
										<div class="col-12">
											<!-- Start Pagination -->
											<div class="pagination-main">
												<?php if (function_exists("penbird_pagination"))
													{
														penbird_pagination();
													}  
												?>
											</div>
											<!-- End Pagination -->
										</div>
									</div>	
								</div>
							</div>
							<?php penbird_render_sidebar(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Blog Layout -->
<?php get_footer();