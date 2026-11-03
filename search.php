<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package PenBird
 */

get_header();

?>
	
	<?php if(get_theme_mod('penbird_search_bc', true)) : ?>
		<div class="penbird-bc">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h2 class="bc-title"><?php
						printf(
							/* translators: %s: search query. */
							esc_html__( 'Search Results: %s', 'penbird' ),
							esc_html( get_search_query() )
						);
						?></h2>
						<div class="bc-list">
							<?php if (function_exists('bcn_display')) bcn_display(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<section class="penbird-search-page search-page">
		<div class="container">
			<div class="row">
				<?php if ( have_posts() ) : ?>

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					the_posts_navigation();

					else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
		</div>
	</section>

<?php
get_footer();
