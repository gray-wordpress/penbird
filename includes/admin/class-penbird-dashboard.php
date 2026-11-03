<?php
/**
 * PenBird Welcome / Theme Settings dashboard.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the dashboard under Appearance.
 */
function penbird_dashboard_menu() {
	add_theme_page(
		__( 'PenBird', 'penbird' ),
		__( 'PenBird', 'penbird' ),
		'edit_theme_options',
		'penbird-dashboard',
		'penbird_dashboard_page'
	);
}
add_action( 'admin_menu', 'penbird_dashboard_menu' );

/**
 * Enqueue dashboard assets on this screen only.
 *
 * @param string $hook Current admin page hook.
 */
function penbird_dashboard_assets( $hook ) {
	if ( 'appearance_page_penbird-dashboard' !== $hook ) {
		return;
	}

	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	require_once $theme_dir . '/includes/wptt-webfont-loader.php';

	wp_enqueue_style(
		'penbird-admin-font',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap' ),
		array(),
		penbird_VERSION
	);

	wp_enqueue_style(
		'penbird-admin',
		$theme_uri . '/resource/css/admin.css',
		array( 'penbird-admin-font' ),
		penbird_VERSION
	);

	wp_enqueue_script(
		'penbird-admin',
		$theme_uri . '/resource/js/admin.js',
		array(),
		penbird_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'penbird_dashboard_assets' );

/**
 * Theme product / docs URLs from theme headers (not hardcoded).
 *
 * @return array
 */
function penbird_get_dashboard_urls() {
	$theme      = wp_get_theme();
	$theme_uri  = $theme->get( 'ThemeURI' );
	$author_uri = $theme->get( 'AuthorURI' );
	$product    = $theme_uri ? $theme_uri : $author_uri;

	$urls = array(
		'product'     => $product,
		'docs'        => $author_uri ? $author_uri : $product,
		'author'      => $author_uri,
		'customizer'  => admin_url( 'customize.php' ),
		'identity'    => add_query_arg( 'autofocus[section]', 'title_tagline', admin_url( 'customize.php' ) ),
		'settings'    => add_query_arg( 'autofocus[panel]', 'penbird_front_option', admin_url( 'customize.php' ) ),
		'logo'        => add_query_arg( 'autofocus[section]', 'penbird_logo', admin_url( 'customize.php' ) ),
		'header'      => add_query_arg( 'autofocus[section]', 'penbird_header', admin_url( 'customize.php' ) ),
		'footer'      => add_query_arg( 'autofocus[section]', 'penbird_footer', admin_url( 'customize.php' ) ),
		'typography'  => add_query_arg( 'autofocus[section]', 'penbird_typography', admin_url( 'customize.php' ) ),
		'container'    => add_query_arg( 'autofocus[section]', 'penbird_container', admin_url( 'customize.php' ) ),
		'post_sidebar' => add_query_arg( 'autofocus[section]', 'penbird_post_sidebar', admin_url( 'customize.php' ) ),
		'menus'       => admin_url( 'nav-menus.php' ),
		'widgets'     => admin_url( 'widgets.php' ),
		'plugins'     => admin_url( 'themes.php?page=tgmpa-install-plugins' ),
		'video'       => apply_filters( 'penbird_welcome_video_url', '' ),
	);

	/**
	 * Filter PenBird dashboard URLs.
	 *
	 * @param array $urls Dashboard URLs.
	 */
	return apply_filters( 'penbird_dashboard_urls', $urls );
}

/**
 * Build a privacy-enhanced embed from a YouTube or Vimeo URL. No remote request.
 *
 * @param string $url Video URL.
 * @return string
 */
function penbird_get_welcome_video_embed( $url ) {
	$url = esc_url_raw( $url );

	if ( ! $url ) {
		return '';
	}

	$video_id = '';
	$src      = '';

	if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) {
		$video_id = $match[1];
		$src      = 'https://www.youtube-nocookie.com/embed/' . rawurlencode( $video_id ) . '?rel=0';
	} elseif ( preg_match( '/vimeo\.com\/(?:video\/)?([0-9]+)/', $url, $match ) ) {
		$video_id = $match[1];
		$src      = 'https://player.vimeo.com/video/' . rawurlencode( $video_id );
	}

	if ( ! $src ) {
		return '';
	}

	return sprintf(
		'<iframe src="%1$s" title="%2$s" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
		esc_url( $src ),
		esc_attr__( 'PenBird welcome video', 'penbird' )
	);
}

/**
 * Render the dashboard.
 */
function penbird_dashboard_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$theme = wp_get_theme();
	$urls  = penbird_get_dashboard_urls();
	$embed = ! empty( $urls['video'] ) ? penbird_get_welcome_video_embed( $urls['video'] ) : '';
	?>
	<div class="wrap penbird-dashboard">
		<div class="penbird-dashboard__banner">
			<div class="penbird-dashboard__banner-copy">
				<span class="penbird-dashboard__eyebrow"><?php esc_html_e( 'Welcome', 'penbird' ); ?></span>
				<h1>
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s: theme name */
							__( 'Welcome to %s', 'penbird' ),
							$theme->get( 'Name' )
						)
					);
					?>
				</h1>
				<p><?php esc_html_e( 'A lightweight WordPress theme with a clean Customizer foundation. Use this dashboard to get started and open documentation.', 'penbird' ); ?></p>
				<div class="penbird-dashboard__banner-meta">
					<span><?php echo esc_html( sprintf( /* translators: %s: version */ __( 'Version %s', 'penbird' ), $theme->get( 'Version' ) ) ); ?></span>
					<span><?php echo esc_html( $theme->get( 'Author' ) ); ?></span>
				</div>
				<div class="penbird-dashboard__actions">
					<a class="penbird-btn-default penbird-btn-default__primary" href="<?php echo esc_url( $urls['customizer'] ); ?>"><?php esc_html_e( 'Open Customizer', 'penbird' ); ?></a>
					<?php if ( ! empty( $urls['product'] ) ) : ?>
						<a class="penbird-btn-default penbird-btn-default__secondary" href="<?php echo esc_url( $urls['product'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Theme page', 'penbird' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
			<div class="penbird-dashboard__banner-mark" aria-hidden="true"><span>P</span></div>
		</div>

		<div class="penbird-dashboard__tabs" role="tablist" aria-label="<?php esc_attr_e( 'PenBird dashboard sections', 'penbird' ); ?>">
			<button type="button" class="penbird-dashboard__tab is-active" role="tab" id="penbird-tab-welcome" aria-selected="true" aria-controls="penbird-panel-welcome" data-tab="welcome"><?php esc_html_e( 'Welcome', 'penbird' ); ?></button>
			<button type="button" class="penbird-dashboard__tab" role="tab" id="penbird-tab-start" aria-selected="false" aria-controls="penbird-panel-start" data-tab="start"><?php esc_html_e( 'Getting Started', 'penbird' ); ?></button>
			<button type="button" class="penbird-dashboard__tab" role="tab" id="penbird-tab-pro" aria-selected="false" aria-controls="penbird-panel-pro" data-tab="pro"><?php esc_html_e( 'Free vs Pro', 'penbird' ); ?></button>
			<button type="button" class="penbird-dashboard__tab" role="tab" id="penbird-tab-docs" aria-selected="false" aria-controls="penbird-panel-docs" data-tab="docs"><?php esc_html_e( 'Documentation', 'penbird' ); ?></button>
		</div>

		<div class="penbird-dashboard__panels">
			<section class="penbird-dashboard__panel is-active" role="tabpanel" id="penbird-panel-welcome" aria-labelledby="penbird-tab-welcome">
				<div class="penbird-dashboard__grid">
					<div class="penbird-dashboard__card">
						<h2><?php esc_html_e( 'Meet PenBird', 'penbird' ); ?></h2>
						<p><?php esc_html_e( 'PenBird is built for blogs, magazines, and WooCommerce storefronts. Global style lives in the WordPress Customizer. This page is your product home — not a second settings framework.', 'penbird' ); ?></p>
						<ul class="penbird-dashboard__checklist">
							<li><?php esc_html_e( 'Native Customizer theme settings', 'penbird' ); ?></li>
							<li><?php esc_html_e( 'Lightweight frontend architecture', 'penbird' ); ?></li>
							<li><?php esc_html_e( 'WordPress.org-friendly Free theme', 'penbird' ); ?></li>
						</ul>
					</div>
					<div class="penbird-dashboard__card penbird-dashboard__card--video">
						<h2><?php esc_html_e( 'Welcome video', 'penbird' ); ?></h2>
						<p><?php esc_html_e( 'A short overview of PenBird and how to start customizing.', 'penbird' ); ?></p>
						<div class="penbird-dashboard__video">
							<?php if ( $embed ) : ?>
								<div class="penbird-dashboard__video-frame">
									<?php
									echo wp_kses(
										$embed,
										array(
											'iframe' => array(
												'src'             => true,
												'title'           => true,
												'loading'         => true,
												'allow'           => true,
												'allowfullscreen' => true,
											),
										)
									);
									?>
								</div>
							<?php elseif ( ! empty( $urls['product'] ) ) : ?>
								<a class="penbird-dashboard__video-fallback" href="<?php echo esc_url( $urls['product'] ); ?>" target="_blank" rel="noopener noreferrer">
									<span class="penbird-dashboard__play" aria-hidden="true"></span>
									<span class="penbird-dashboard__video-label"><?php esc_html_e( 'Watch the PenBird overview', 'penbird' ); ?></span>
								</a>
							<?php else : ?>
								<div class="penbird-dashboard__video-fallback" role="note">
									<span class="penbird-dashboard__play" aria-hidden="true"></span>
									<span class="penbird-dashboard__video-label"><?php esc_html_e( 'Welcome video coming soon', 'penbird' ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>

			<section class="penbird-dashboard__panel" role="tabpanel" id="penbird-panel-start" aria-labelledby="penbird-tab-start" hidden>
				<div class="penbird-dashboard__card penbird-dashboard__card--wide">
					<h2><?php esc_html_e( 'Getting Started', 'penbird' ); ?></h2>
					<p><?php esc_html_e( 'Follow these steps to launch a complete PenBird site.', 'penbird' ); ?></p>
					<ol class="penbird-dashboard__steps">
						<li>
							<a href="<?php echo esc_url( $urls['identity'] ); ?>">
								<strong><?php esc_html_e( 'Site identity', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Upload a logo and set the site title in the Customizer.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['menus'] ); ?>">
								<strong><?php esc_html_e( 'Primary menu', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Create a menu and assign it to the Primary location.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['widgets'] ); ?>">
								<strong><?php esc_html_e( 'Sidebar and footer', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Add widgets to the Default Sidebar, Post Sidebar, and Footer Widget areas.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['settings'] ); ?>">
								<strong><?php esc_html_e( 'Theme Settings', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Open the PenBird Customizer panel for theme defaults.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['logo'] ); ?>">
								<strong><?php esc_html_e( 'Logo', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Set logo width used by the PenBird header.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['header'] ); ?>">
								<strong><?php esc_html_e( 'Header', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Choose header layout, width, logo position, and styles.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['footer'] ); ?>">
								<strong><?php esc_html_e( 'Footer', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Set footer columns, alignment, and copyright.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['typography'] ); ?>">
								<strong><?php esc_html_e( 'Typography', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Adjust body and heading type from the PenBird system.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['container'] ); ?>">
								<strong><?php esc_html_e( 'Container', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Set boxed, narrow, or full width and the default sidebar.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['post_sidebar'] ); ?>">
								<strong><?php esc_html_e( 'Post Sidebar', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Choose the single post sidebar layout and add Post Sidebar widgets.', 'penbird' ); ?></span>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $urls['plugins'] ); ?>">
								<strong><?php esc_html_e( 'Recommended plugins', 'penbird' ); ?></strong>
								<span><?php esc_html_e( 'Install optional plugins suggested by PenBird when you need them.', 'penbird' ); ?></span>
							</a>
						</li>
					</ol>
				</div>
			</section>

			<section class="penbird-dashboard__panel" role="tabpanel" id="penbird-panel-pro" aria-labelledby="penbird-tab-pro" hidden>
				<div class="penbird-dashboard__pro">
					<div class="penbird-dashboard__card penbird-dashboard__card--cta">
						<span class="penbird-dashboard__eyebrow"><?php esc_html_e( 'PenBird Pro', 'penbird' ); ?></span>
						<h2><?php esc_html_e( 'Go further when you need it', 'penbird' ); ?></h2>
						<p><?php esc_html_e( 'The free theme covers the essentials. Header and footer builders, a site builder, and advanced WooCommerce layouts are not part of this theme. Nothing is locked behind a control in the Customizer.', 'penbird' ); ?></p>
						<?php if ( ! empty( $urls['product'] ) ) : ?>
							<a class="penbird-btn-default penbird-btn-default__primary" href="<?php echo esc_url( $urls['product'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Theme page', 'penbird' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
				<div class="penbird-dashboard__card penbird-dashboard__card--wide">
					<h2><?php esc_html_e( 'Free vs Pro Features', 'penbird' ); ?></h2>
					<table class="penbird-dashboard__table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Feature', 'penbird' ); ?></th>
								<th><?php esc_html_e( 'Free', 'penbird' ); ?></th>
								<th><?php esc_html_e( 'Pro', 'penbird' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e( 'Customizer theme settings', 'penbird' ); ?></td>
								<td><span class="penbird-dashboard__yes"><?php esc_html_e( 'Yes', 'penbird' ); ?></span></td>
								<td><?php esc_html_e( 'Included', 'penbird' ); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e( 'Blog, pages, WooCommerce styling', 'penbird' ); ?></td>
								<td><span class="penbird-dashboard__yes"><?php esc_html_e( 'Yes', 'penbird' ); ?></span></td>
								<td><?php esc_html_e( 'Advanced layouts', 'penbird' ); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e( 'Header / Footer builder', 'penbird' ); ?></td>
								<td><?php esc_html_e( '—', 'penbird' ); ?></td>
								<td><?php esc_html_e( 'Planned', 'penbird' ); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e( 'Site Builder', 'penbird' ); ?></td>
								<td><?php esc_html_e( '—', 'penbird' ); ?></td>
								<td><?php esc_html_e( 'Planned', 'penbird' ); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e( 'Dedicated Theme Settings panel', 'penbird' ); ?></td>
								<td><?php esc_html_e( '—', 'penbird' ); ?></td>
								<td><?php esc_html_e( 'Planned', 'penbird' ); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e( 'Advanced WooCommerce (product, cart, checkout)', 'penbird' ); ?></td>
								<td><?php esc_html_e( '—', 'penbird' ); ?></td>
								<td><?php esc_html_e( 'Planned', 'penbird' ); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</section>

			<section class="penbird-dashboard__panel" role="tabpanel" id="penbird-panel-docs" aria-labelledby="penbird-tab-docs" hidden>
				<div class="penbird-dashboard__grid">
					<div class="penbird-dashboard__card">
						<h2><?php esc_html_e( 'Documentation', 'penbird' ); ?></h2>
						<p><?php esc_html_e( 'Use WordPress core screens together with the PenBird Customizer. Documentation and product details live on the theme site.', 'penbird' ); ?></p>
						<ul class="penbird-dashboard__list">
							<?php if ( ! empty( $urls['docs'] ) ) : ?>
								<li><a href="<?php echo esc_url( $urls['docs'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Theme documentation', 'penbird' ); ?></a></li>
							<?php endif; ?>
							<?php if ( ! empty( $urls['product'] ) ) : ?>
								<li><a href="<?php echo esc_url( $urls['product'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Product page', 'penbird' ); ?></a></li>
							<?php endif; ?>
							<li><a href="<?php echo esc_url( $urls['customizer'] ); ?>"><?php esc_html_e( 'WordPress Customizer', 'penbird' ); ?></a></li>
							<li><a href="<?php echo esc_url( $urls['settings'] ); ?>"><?php esc_html_e( 'PenBird Theme Settings', 'penbird' ); ?></a></li>
						</ul>
					</div>
					<div class="penbird-dashboard__card">
						<h2><?php esc_html_e( 'Useful links', 'penbird' ); ?></h2>
						<div class="penbird-dashboard__links">
							<a href="<?php echo esc_url( $urls['identity'] ); ?>"><?php esc_html_e( 'Logo & title', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['logo'] ); ?>"><?php esc_html_e( 'Logo width', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['header'] ); ?>"><?php esc_html_e( 'Header', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['footer'] ); ?>"><?php esc_html_e( 'Footer', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['typography'] ); ?>"><?php esc_html_e( 'Typography', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['container'] ); ?>"><?php esc_html_e( 'Container', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['post_sidebar'] ); ?>"><?php esc_html_e( 'Post Sidebar', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['menus'] ); ?>"><?php esc_html_e( 'Menus', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['widgets'] ); ?>"><?php esc_html_e( 'Widgets', 'penbird' ); ?></a>
							<a href="<?php echo esc_url( $urls['plugins'] ); ?>"><?php esc_html_e( 'Plugins', 'penbird' ); ?></a>
							<?php if ( ! empty( $urls['author'] ) ) : ?>
								<a href="<?php echo esc_url( $urls['author'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'PencilWP', 'penbird' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php
		/**
		 * Fires at the end of the PenBird dashboard.
		 */
		do_action( 'penbird_dashboard_after' );
		?>
	</div>
	<?php
}
