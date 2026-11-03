<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PenBird
 */

get_header();
?>
	
	<?php
	$penbird_show_page_banner = get_theme_mod( 'penbird_page_bc', true ) && ! is_front_page();
	$penbird_show_page_title  = $penbird_show_page_banner && ! penbird_is_page_element_disabled( 'title' );
	$penbird_show_page_bc     = $penbird_show_page_banner && ! penbird_is_page_element_disabled( 'breadcrumb' );
	if ( $penbird_show_page_title || $penbird_show_page_bc ) :
		?>
    <div class="penbird-bc">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if ( $penbird_show_page_title ) : ?>
                    <h2 class="bc-title"><?php the_title(); ?></h2>
                    <?php endif; ?>
                    <?php if ( $penbird_show_page_bc ) : ?>
                    <div class="bc-list">
                        <?php if ( function_exists( 'bcn_display' ) ) bcn_display(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
	
	<section class="penbird-page site-page <?php echo esc_attr( penbird_active() ); ?>">
		<div class="container">
			<div class="row penbird-layout-row">
				<div class="<?php echo esc_attr( penbird_content_class() ); ?>">
					<div class="penbird-page__inners">
						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
					</div>
				</div>
				<?php penbird_render_sidebar(); ?>
			</div>
		</div>
	</section>
<?php
get_footer();
