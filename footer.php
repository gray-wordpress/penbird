<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-partials
 *
 * @package PenBird
 */

$penbird_footer_col = penbird_footer_column_class();
?>
</div>
	<?php if ( ! penbird_is_page_element_disabled( 'footer' ) ) : ?>
	<footer id="colophon" class="penbird-footer">
		<?php if ( penbird_get_option( 'penbird_footer_widgets' ) && is_active_sidebar( 'penbird_footer_1' ) ) : ?>
		<div class="penbird-footer__top">
			<div class="container">
				<div class="row">
					<?php if ( is_active_sidebar( 'penbird_footer_1' ) ) : ?>
						<div class="<?php echo esc_attr( $penbird_footer_col ); ?>">
							<?php dynamic_sidebar( 'penbird_footer_1' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'penbird_footer_2' ) ) : ?>
						<div class="<?php echo esc_attr( $penbird_footer_col ); ?>">
							<?php dynamic_sidebar( 'penbird_footer_2' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'penbird_footer_3' ) ) : ?>
						<div class="<?php echo esc_attr( $penbird_footer_col ); ?>">
							<?php dynamic_sidebar( 'penbird_footer_3' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="penbird-footer__bottom">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="penbird-footer__branding text-center">
							<p class="penbird-footer__site"><?php echo wp_kses_post( penbird_get_footer_copyright_text() ); ?></p>
							<?php if ( penbird_get_option( 'penbird_footer_credit' ) ) : ?>
							<span class="penbird-middle-dot"></span>
							<p class="penbird-footer__devs"><?php
							$penbird_theme = wp_get_theme();
							$author_uri    = $penbird_theme->get( 'AuthorURI' );
							$author_name   = $penbird_theme->get( 'Author' );
							printf(
								/* translators: %s: theme author name linked to the author site. */
								esc_html__( 'Developed by %s', 'penbird' ),
								'<a href="' . esc_url( $author_uri ? $author_uri : home_url( '/' ) ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $author_name ? $author_name : 'PencilWP' ) . '</a>'
							);
							?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<?php endif; ?>
	
</div>

<?php wp_footer(); ?>

</body>
</html>
