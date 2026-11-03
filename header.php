<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PenBird
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Start Page -->
<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'penbird' ); ?></a>

		<!-- Header -->
		<?php if ( ! penbird_is_page_element_disabled( 'header' ) ) : ?>
		<header id="masthead" class="<?php echo esc_attr( penbird_header_class() ); ?>">
			<?php if ( get_header_image() ) : ?>
			<div class="header-image">
				<img src="<?php header_image(); ?>" width="<?php echo absint( get_custom_header()->width ); ?>" height="<?php echo absint( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			</div>
			<?php endif; ?>
			<div class="<?php echo esc_attr( penbird_header_inner_class() ); ?>">
				<div class="row">
					<div class="col-12">
						<div class="penbird-header__middle">
							<!-- Logo -->
							<div class="penbird-logo">
								<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
									the_custom_logo();
								} else { ?>
									<div class="normal-text">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
										<?php $penbird_title_description = get_bloginfo( 'description', 'display' ); ?>
										<?php if ( $penbird_title_description || is_customize_preview() ) : ?>
											<p class="site-description"><?php echo esc_html( $penbird_title_description ); ?></p>
										<?php endif; ?>
									</div>
								<?php } ?>
							</div>
							<div class="penbird-header__menu">
								<!-- Main Nav -->
								<nav id="site-navigation" class="penbird-header__nav navbar navbar-expand-lg" aria-label="<?php esc_attr_e( 'Primary', 'penbird' ); ?>">
									<div class="navbar-collapse">
										<?php
										wp_nav_menu(
											array(
												'theme_location' => 'menu-1',
												'menu_id'        => 'primary-menu',
												'menu_class'     => 'nav penbird-menu navbar-nav',
											)
										);
										?>
									</div>
								</nav>
								<!--/ End Main Nav -->
								<div class="penbird-header__right">
									<div class="penbird-header__button">
										<div class="penbird-header__search">
											<button type="button" class="penbird-header__button--icon penbird-search-icon" aria-expanded="false" aria-controls="penbird-header-search">
												<span class="screen-reader-text"><?php esc_html_e( 'Search', 'penbird' ); ?></span>
												<i class="fa fa-search" aria-hidden="true"></i>
											</button>
											<div id="penbird-header-search" class="search-form-main" aria-hidden="true">
												<?php get_search_form(); ?>
												<button type="button" class="penbird-search-close">
													<span class="screen-reader-text"><?php esc_html_e( 'Close search', 'penbird' ); ?></span>
													<i class="fa fa-close" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										<?php if ( class_exists( 'WooCommerce' ) ) : ?>
										<div class="woo-cart-click">
											<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="penbird-header__button--icon">
												<span class="screen-reader-text"><?php esc_html_e( 'View cart', 'penbird' ); ?></span>
												<i class="fa fa-shopping-cart" aria-hidden="true"></i>
												<?php if ( WC()->cart ) : ?>
													<span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
												<?php endif; ?>
											</a>
										</div>
										<?php endif; ?>
										<div class="menu-click">
											<button type="button" class="penbird-header__button--icon penbird-menu-toggle" aria-expanded="false" aria-controls="penbird-mobile-menu">
												<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'penbird' ); ?></span>
												<i class="fa fa-bars" aria-hidden="true"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<!-- Sidebar Menu -->
			<div id="penbird-mobile-menu" class="penbird-mobile-menu">
				<div class="menu-inner">
					<h4 class="oe-menu-title"><?php esc_html_e( 'Navigation', 'penbird' ); ?></h4>
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'side-menu',
								'menu_class'     => 'side-nav',
							)
						);
					?>
					<div class="close-menu">
						<button type="button" class="penbird-mobile-close">
							<i class="fa fa-remove" aria-hidden="true"></i>
							<?php esc_html_e( 'Close Menu', 'penbird' ); ?>
						</button>
					</div>
				</div>
			</div>
			<!-- End Sidebar Menu -->

		</header>
		<!-- End Header -->
		<?php endif; ?>

	<div id="primary" class="penbird-section-main">
