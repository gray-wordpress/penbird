<?php
/**
 * PenBird Customizer option defaults and getters.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default theme_mod values.
 *
 * @return array
 */
function penbird_get_defaults() {
	return array(
		'penbird_logo_width'           => 170,
		'penbird_search_enable'        => true,
		'penbird_header_layout'        => 'logo-menu',
		'penbird_header_width'         => 'boxed',
		'penbird_header_logo_position' => 'left',
		'penbird_header_menu_align'    => 'right',
		'penbird_header_sticky'        => false,
		'penbird_header_cart'          => true,
		'penbird_header_bg'            => '#ffffff',
		'penbird_header_color'         => '#0A2540',
		'penbird_header_padding'       => 15,
		'penbird_footer_layout'        => 'three',
		'penbird_footer_alignment'     => 'center',
		'penbird_footer_widgets'       => true,
		'penbird_footer_credit'        => true,
		'penbird_footer_copyright'     => '',
		'penbird_footer_bg'            => '#F6F9FC',
		'penbird_body_font'            => 'inter',
		'penbird_body_font_size'       => 16,
		'penbird_body_font_weight'     => '400',
		'penbird_heading_font'         => 'inter',
		'penbird_heading_font_weight'  => '500',
		'penbird_container_layout'     => 'boxed',
		'penbird_container_width'      => 1280,
		'penbird_content_width'        => 800,
		'penbird_sidebar_position'     => 'right',
		'penbird_post_sidebar'         => 'right',
		'penbird_post_excerpt'         => 22,
		'penbird_page_bc'              => true,
		'penbird_archive_bc'           => true,
		'penbird_search_bc'            => true,
		'penbird_primary_color'        => '#605BE5',
		'penbird_secondary_color'      => '#0A2540',
		'penbird_text_color'           => '#696969',
	);
}

/**
 * Get a theme_mod with PenBird defaults.
 *
 * @param string $key     Setting ID.
 * @param mixed  $default Optional default override.
 * @return mixed
 */
function penbird_get_option( $key, $default = null ) {
	$defaults = penbird_get_defaults();

	if ( null === $default && array_key_exists( $key, $defaults ) ) {
		$default = $defaults[ $key ];
	}

	return get_theme_mod( $key, $default );
}

/**
 * Font stacks for Free typography.
 *
 * @return array
 */
function penbird_get_font_stacks() {
	return array(
		'inter'   => "'Inter', sans-serif",
		'system'  => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, sans-serif",
		'georgia' => "Georgia, 'Times New Roman', serif",
		'times'   => "'Times New Roman', Times, serif",
	);
}

/**
 * Resolve a font stack.
 *
 * @param string $key Font key.
 * @return string
 */
function penbird_get_font_stack( $key ) {
	$stacks = penbird_get_font_stacks();
	return isset( $stacks[ $key ] ) ? $stacks[ $key ] : $stacks['inter'];
}

/**
 * Whether the given (or current) page was built with Elementor.
 *
 * @param int $post_id Optional post ID.
 * @return bool
 */
function penbird_is_elementor_page( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}

	if ( ! $post_id ) {
		return false;
	}

	if ( defined( 'ELEMENTOR_PATH' ) && class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->db ) ) {
		return (bool) \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id );
	}

	return false;
}

/**
 * Resolved container layout (boxed, narrow, full).
 *
 * Pages: Customizer → page meta override.
 *
 * @return string
 */
function penbird_get_container_layout() {
	$layout  = penbird_get_option( 'penbird_container_layout', 'boxed' );
	$allowed = array( 'boxed', 'narrow', 'full' );

	if ( is_page() && ! penbird_is_elementor_page() ) {
		$meta = get_post_meta( get_queried_object_id(), '_penbird_container', true );
		if ( $meta && 'default' !== $meta ) {
			if ( 'normal' === $meta ) {
				$layout = 'boxed';
			} elseif ( in_array( $meta, $allowed, true ) ) {
				$layout = $meta;
			}
		}
	}

	if ( ! in_array( $layout, $allowed, true ) ) {
		$layout = 'boxed';
	}

	return $layout;
}

/**
 * Resolved sidebar position (none, left, right).
 *
 * Pages: Customizer global → page meta override.
 * Single posts: Post Sidebar Customizer setting.
 *
 * @return string
 */
function penbird_get_sidebar_position() {
	$allowed = array( 'none', 'left', 'right' );

	if ( is_page() && ! penbird_is_elementor_page() ) {
		$meta = get_post_meta( get_queried_object_id(), '_penbird_sidebar', true );
		if ( $meta && 'default' !== $meta && in_array( $meta, $allowed, true ) ) {
			return $meta;
		}
		$position = penbird_get_option( 'penbird_sidebar_position', 'right' );
	} elseif ( is_singular( 'post' ) ) {
		$position = penbird_get_option( 'penbird_post_sidebar', 'right' );
	} else {
		$position = penbird_get_option( 'penbird_sidebar_position', 'right' );
	}

	if ( ! in_array( $position, $allowed, true ) ) {
		$position = 'right';
	}

	return $position;
}

/**
 * Widget area ID for the current view.
 *
 * @return string
 */
function penbird_get_sidebar_id() {
	if ( is_singular( 'post' ) && is_active_sidebar( 'penbird_post_sidebar' ) ) {
		return 'penbird_post_sidebar';
	}

	return 'sidebar';
}

/**
 * Whether the current view should show the sidebar.
 *
 * @return bool
 */
function penbird_has_sidebar() {
	if ( 'none' === penbird_get_sidebar_position() ) {
		return false;
	}

	if ( is_page() && penbird_is_elementor_page() ) {
		return false;
	}

	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
		return false;
	}

	return is_active_sidebar( penbird_get_sidebar_id() );
}

/**
 * Whether a page-level element is disabled for the current page.
 *
 * @param string $element header|footer|title|breadcrumb.
 * @return bool
 */
function penbird_is_page_element_disabled( $element ) {
	if ( ! is_page() ) {
		return false;
	}

	$map = array(
		'header'     => '_penbird_disable_header',
		'footer'     => '_penbird_disable_footer',
		'title'      => '_penbird_disable_title',
		'breadcrumb' => '_penbird_disable_breadcrumb',
	);

	if ( ! isset( $map[ $element ] ) ) {
		return false;
	}

	return (bool) get_post_meta( get_queried_object_id(), $map[ $element ], true );
}

/**
 * Content column class.
 *
 * @return string
 */
function penbird_content_class() {
	if ( penbird_has_sidebar() ) {
		return 'col-lg-9 col-12 penbird-main-area__with-side';
	}

	return 'col-12';
}

/**
 * Sidebar column class.
 *
 * @return string
 */
function penbird_sidebar_class() {
	return 'col-lg-3 col-12 penbird-main-area__sidebar';
}

/**
 * Header class list.
 *
 * @return string
 */
function penbird_header_class() {
	$classes = array( 'penbird-header', 'site-header' );

	$layout = penbird_get_option( 'penbird_header_layout', 'logo-menu' );
	if ( ! in_array( $layout, array( 'logo-menu', 'centered', 'split' ), true ) ) {
		$layout = 'logo-menu';
	}
	$classes[] = 'penbird-header--' . $layout;

	$width = penbird_get_option( 'penbird_header_width', 'boxed' );
	if ( ! in_array( $width, array( 'boxed', 'full' ), true ) ) {
		$width = 'boxed';
	}
	$classes[] = 'penbird-header--width-' . $width;

	$logo = penbird_get_option( 'penbird_header_logo_position', 'left' );
	if ( ! in_array( $logo, array( 'left', 'center', 'right' ), true ) ) {
		$logo = 'left';
	}
	$classes[] = 'penbird-header--logo-' . $logo;

	$menu = penbird_get_option( 'penbird_header_menu_align', 'right' );
	if ( ! in_array( $menu, array( 'left', 'center', 'right' ), true ) ) {
		$menu = 'right';
	}
	$classes[] = 'penbird-header--menu-' . $menu;

	if ( penbird_get_option( 'penbird_header_sticky' ) ) {
		$classes[] = 'penbird-header--sticky';
	}

	if ( ! penbird_get_option( 'penbird_search_enable' ) ) {
		$classes[] = 'penbird-header--no-search';
	}

	if ( ! penbird_get_option( 'penbird_header_cart' ) ) {
		$classes[] = 'penbird-header--no-cart';
	}

	return implode( ' ', $classes );
}

/**
 * Inner header container class (.container or .container-fluid).
 *
 * @return string
 */
function penbird_header_inner_class() {
	$classes = array( 'penbird-header__container' );
	$width   = penbird_get_option( 'penbird_header_width', 'boxed' );

	$classes[] = ( 'full' === $width ) ? 'container-fluid' : 'container';

	return implode( ' ', $classes );
}

/**
 * Footer widget column class.
 *
 * @return string
 */
function penbird_footer_column_class() {
	$layout = penbird_get_option( 'penbird_footer_layout', 'three' );
	$map    = array(
		'one'   => 'col-12',
		'two'   => 'col-lg-6 col-12',
		'three' => 'col-lg-4 col-12',
	);

	return isset( $map[ $layout ] ) ? $map[ $layout ] : $map['three'];
}

/**
 * Footer copyright HTML.
 *
 * @return string
 */
function penbird_get_footer_copyright_text() {
	$custom = penbird_get_option( 'penbird_footer_copyright', '' );
	$text   = ( '' !== trim( (string) $custom ) ) ? $custom : __( 'All Right Reserved', 'penbird' );

	return sprintf(
		/* translators: 1: copyright label, 2: home URL, 3: site name, 4: year */
		'&copy; %1$s <a class="penbird-footer__url" href="%2$s">%3$s</a> %4$s',
		esc_html( $text ),
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) ),
		esc_html( date_i18n( 'Y' ) )
	);
}

/**
 * Print the sidebar when the layout allows it.
 */
function penbird_render_sidebar() {
	if ( ! penbird_has_sidebar() ) {
		return;
	}
	?>
	<div class="<?php echo esc_attr( penbird_sidebar_class() ); ?>">
		<div class="penbird-sidebar penbird-sidebar__<?php echo esc_attr( penbird_get_sidebar_position() ); ?>">
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php
}
