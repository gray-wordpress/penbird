<?php
/**
 * PenBird Page Settings — REST meta + block editor sidebar.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register page layout meta for the REST API / block editor.
 */
function penbird_register_page_meta() {
	$bool_args = array(
		'type'              => 'boolean',
		'single'            => true,
		'default'           => false,
		'sanitize_callback' => 'penbird_sanitize_page_bool',
		'auth_callback'     => 'penbird_page_meta_auth',
		'show_in_rest'      => array(
			'schema' => array(
				'type'    => 'boolean',
				'default' => false,
			),
		),
	);

	register_post_meta(
		'page',
		'_penbird_container',
		array(
			'type'              => 'string',
			'single'            => true,
			'default'           => 'default',
			'sanitize_callback' => 'penbird_sanitize_page_container',
			'auth_callback'     => 'penbird_page_meta_auth',
			'show_in_rest'      => array(
				'schema' => array(
					'type' => 'string',
					'enum' => array( 'default', 'normal', 'full', 'narrow' ),
				),
			),
		)
	);

	register_post_meta(
		'page',
		'_penbird_sidebar',
		array(
			'type'              => 'string',
			'single'            => true,
			'default'           => 'default',
			'sanitize_callback' => 'penbird_sanitize_page_sidebar',
			'auth_callback'     => 'penbird_page_meta_auth',
			'show_in_rest'      => array(
				'schema' => array(
					'type' => 'string',
					'enum' => array( 'default', 'none', 'left', 'right' ),
				),
			),
		)
	);

	register_post_meta( 'page', '_penbird_disable_header', $bool_args );
	register_post_meta( 'page', '_penbird_disable_footer', $bool_args );
	register_post_meta( 'page', '_penbird_disable_title', $bool_args );
	register_post_meta( 'page', '_penbird_disable_breadcrumb', $bool_args );
}
add_action( 'init', 'penbird_register_page_meta' );

/**
 * REST auth for PenBird page meta.
 *
 * @param bool   $allowed  Whether allowed.
 * @param string $meta_key Meta key.
 * @param int    $post_id  Post ID.
 * @return bool
 */
function penbird_page_meta_auth( $allowed, $meta_key, $post_id ) {
	unset( $allowed, $meta_key );
	return current_user_can( 'edit_post', $post_id );
}

/**
 * Allowed container meta values.
 *
 * @return array
 */
function penbird_page_container_choices() {
	return array(
		'default' => __( 'Default', 'penbird' ),
		'normal'  => __( 'Normal', 'penbird' ),
		'full'    => __( 'Full Width', 'penbird' ),
		'narrow'  => __( 'Narrow', 'penbird' ),
	);
}

/**
 * Allowed sidebar meta values.
 *
 * @return array
 */
function penbird_page_sidebar_choices() {
	return array(
		'default' => __( 'Default', 'penbird' ),
		'none'    => __( 'No Sidebar', 'penbird' ),
		'left'    => __( 'Left Sidebar', 'penbird' ),
		'right'   => __( 'Right Sidebar', 'penbird' ),
	);
}

/**
 * Inline SVG used as the editor header icon.
 *
 * @return string
 */
function penbird_page_editor_logo_svg() {
	return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><rect width="24" height="24" rx="5" fill="#0A2540"/><path fill="#fff" d="M8 6.5h5.2c2.4 0 3.8 1.4 3.8 3.5 0 2.2-1.5 3.6-3.9 3.6H10.4V17.5H8V6.5zm2.4 5.2h2.6c1.1 0 1.7-.6 1.7-1.6s-.6-1.6-1.7-1.6h-2.6v3.2z"/><circle cx="18.2" cy="6.2" r="1.6" fill="#605BE5"/></svg>';
}

/**
 * Enqueue the block editor plugin sidebar.
 */
function penbird_page_editor_assets() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	require_once get_template_directory() . '/includes/customizer/class-penbird-customize-control.php';

	$global_container = penbird_get_option( 'penbird_container_layout', 'boxed' );
	$global_sidebar   = penbird_get_option( 'penbird_sidebar_position', 'right' );

	$container_labels = array(
		'boxed'  => __( 'Normal', 'penbird' ),
		'narrow' => __( 'Narrow', 'penbird' ),
		'full'   => __( 'Full Width', 'penbird' ),
	);
	$sidebar_labels   = array(
		'none'  => __( 'No Sidebar', 'penbird' ),
		'left'  => __( 'Left Sidebar', 'penbird' ),
		'right' => __( 'Right Sidebar', 'penbird' ),
	);

	wp_enqueue_style(
		'penbird-admin',
		get_template_directory_uri() . '/resource/css/admin.css',
		array(),
		penbird_VERSION
	);

	$page_editor_js = get_template_directory() . '/resource/js/page-editor.js';
	wp_enqueue_script(
		'penbird-page-editor',
		get_template_directory_uri() . '/resource/js/page-editor.js',
		array( 'wp-plugins', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n', 'wp-editor', 'wp-edit-post' ),
		file_exists( $page_editor_js ) ? filemtime( $page_editor_js ) : penbird_VERSION,
		true
	);

	wp_localize_script(
		'penbird-page-editor',
		'penbirdPageEditor',
		array(
			'containerChoices' => penbird_page_container_choices(),
			'sidebarChoices'   => penbird_page_sidebar_choices(),
			'containerHelp'    => sprintf(
				/* translators: %s: current Customizer container layout label */
				__( 'Default follows Customizer Container (%s).', 'penbird' ),
				isset( $container_labels[ $global_container ] ) ? $container_labels[ $global_container ] : $container_labels['boxed']
			),
			'sidebarHelp'      => sprintf(
				/* translators: %s: current Customizer sidebar label */
				__( 'Default follows Customizer Sidebar (%s).', 'penbird' ),
				isset( $sidebar_labels[ $global_sidebar ] ) ? $sidebar_labels[ $global_sidebar ] : $sidebar_labels['right']
			),
			'containerIcons'   => array(
				'default' => penbird_customizer_icon( 'layout-default' ),
				'normal'  => penbird_customizer_icon( 'container-boxed' ),
				'full'    => penbird_customizer_icon( 'container-full' ),
				'narrow'  => penbird_customizer_icon( 'container-narrow' ),
			),
			'sidebarIcons'     => array(
				'default' => penbird_customizer_icon( 'layout-default' ),
				'none'    => penbird_customizer_icon( 'sidebar-none' ),
				'left'    => penbird_customizer_icon( 'sidebar-left' ),
				'right'   => penbird_customizer_icon( 'sidebar-right' ),
			),
			'logoSvg'          => penbird_page_editor_logo_svg(),
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'penbird_page_editor_assets' );

/**
 * Classic editor metabox. Hidden in Gutenberg via back-compat flag.
 */
function penbird_register_page_settings_metabox() {
	add_meta_box(
		'penbird_page_settings',
		__( 'PenBird Page Settings', 'penbird' ),
		'penbird_render_page_settings_metabox',
		'page',
		'side',
		'high',
		array(
			'__back_compat_meta_box' => true,
		)
	);
}
add_action( 'add_meta_boxes', 'penbird_register_page_settings_metabox' );

/**
 * Enqueue metabox styles on the classic page editor.
 *
 * @param string $hook Current admin page hook.
 */
function penbird_page_settings_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	if ( ! empty( $screen->is_block_editor ) ) {
		return;
	}

	wp_enqueue_style(
		'penbird-admin',
		get_template_directory_uri() . '/resource/css/admin.css',
		array(),
		penbird_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'penbird_page_settings_assets' );

/**
 * Render a visual radio group for page meta.
 *
 * @param string $name    Input name.
 * @param string $current Current value.
 * @param array  $choices Value => label.
 * @param array  $icons   Value => SVG.
 */
function penbird_render_page_visual_radios( $name, $current, $choices, $icons ) {
	?>
	<div class="penbird-visual-radio penbird-visual-radio--cols-2" role="radiogroup">
		<?php foreach ( $choices as $value => $label ) : ?>
			<?php
			$input_id = $name . '-' . $value;
			$icon     = isset( $icons[ $value ] ) ? $icons[ $value ] : '';
			?>
			<label class="penbird-visual-radio__option" for="<?php echo esc_attr( $input_id ); ?>">
				<input
					id="<?php echo esc_attr( $input_id ); ?>"
					class="penbird-visual-radio__input"
					type="radio"
					name="<?php echo esc_attr( $name ); ?>"
					value="<?php echo esc_attr( $value ); ?>"
					<?php checked( $current, $value ); ?>
				/>
				<span class="penbird-visual-radio__card">
					<?php if ( $icon ) : ?>
						<span class="penbird-visual-radio__icon" aria-hidden="true"><?php echo wp_kses( $icon, penbird_customizer_svg_kses() ); ?></span>
					<?php endif; ?>
					<span class="penbird-visual-radio__text"><?php echo esc_html( $label ); ?></span>
				</span>
			</label>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Render the classic metabox.
 *
 * @param WP_Post $post Current page.
 */
function penbird_render_page_settings_metabox( $post ) {
	wp_nonce_field( 'penbird_save_page_settings', 'penbird_page_settings_nonce' );

	require_once get_template_directory() . '/includes/customizer/class-penbird-customize-control.php';

	$container = get_post_meta( $post->ID, '_penbird_container', true );
	$sidebar   = get_post_meta( $post->ID, '_penbird_sidebar', true );
	$container = $container ? $container : 'default';
	$sidebar   = $sidebar ? $sidebar : 'default';

	$global_container = penbird_get_option( 'penbird_container_layout', 'boxed' );
	$global_sidebar   = penbird_get_option( 'penbird_sidebar_position', 'right' );

	$container_labels = array(
		'boxed'  => __( 'Normal', 'penbird' ),
		'narrow' => __( 'Narrow', 'penbird' ),
		'full'   => __( 'Full Width', 'penbird' ),
	);
	$sidebar_labels   = array(
		'none'  => __( 'No Sidebar', 'penbird' ),
		'left'  => __( 'Left Sidebar', 'penbird' ),
		'right' => __( 'Right Sidebar', 'penbird' ),
	);

	$container_default_label = isset( $container_labels[ $global_container ] ) ? $container_labels[ $global_container ] : $container_labels['boxed'];
	$sidebar_default_label   = isset( $sidebar_labels[ $global_sidebar ] ) ? $sidebar_labels[ $global_sidebar ] : $sidebar_labels['right'];
	?>
	<div class="penbird-metabox">
		<p class="penbird-metabox__intro">
			<?php esc_html_e( 'Default uses the matching Customizer Theme Setting. Any other value applies only to this page.', 'penbird' ); ?>
		</p>

		<div class="penbird-metabox__field">
			<span class="penbird-metabox__label"><?php esc_html_e( 'Container', 'penbird' ); ?></span>
			<p class="penbird-metabox__help">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %s: current Customizer container layout label */
						__( 'Default follows Customizer Container (%s).', 'penbird' ),
						$container_default_label
					)
				);
				?>
			</p>
			<?php
			penbird_render_page_visual_radios(
				'penbird_page_container',
				$container,
				penbird_page_container_choices(),
				array(
					'default' => penbird_customizer_icon( 'layout-default' ),
					'normal'  => penbird_customizer_icon( 'container-boxed' ),
					'full'    => penbird_customizer_icon( 'container-full' ),
					'narrow'  => penbird_customizer_icon( 'container-narrow' ),
				)
			);
			?>
		</div>

		<div class="penbird-metabox__field">
			<span class="penbird-metabox__label"><?php esc_html_e( 'Sidebar', 'penbird' ); ?></span>
			<p class="penbird-metabox__help">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %s: current Customizer sidebar label */
						__( 'Default follows Customizer Sidebar (%s).', 'penbird' ),
						$sidebar_default_label
					)
				);
				?>
			</p>
			<?php
			penbird_render_page_visual_radios(
				'penbird_page_sidebar',
				$sidebar,
				penbird_page_sidebar_choices(),
				array(
					'default' => penbird_customizer_icon( 'layout-default' ),
					'none'    => penbird_customizer_icon( 'sidebar-none' ),
					'left'    => penbird_customizer_icon( 'sidebar-left' ),
					'right'   => penbird_customizer_icon( 'sidebar-right' ),
				)
			);
			?>
		</div>

		<div class="penbird-metabox__field">
			<span class="penbird-metabox__label"><?php esc_html_e( 'Disable Elements', 'penbird' ); ?></span>
			<label class="penbird-metabox__check">
				<input type="checkbox" name="penbird_disable_header" value="1" <?php checked( get_post_meta( $post->ID, '_penbird_disable_header', true ) ); ?> />
				<?php esc_html_e( 'Disable Header', 'penbird' ); ?>
			</label>
			<label class="penbird-metabox__check">
				<input type="checkbox" name="penbird_disable_footer" value="1" <?php checked( get_post_meta( $post->ID, '_penbird_disable_footer', true ) ); ?> />
				<?php esc_html_e( 'Disable Footer', 'penbird' ); ?>
			</label>
			<label class="penbird-metabox__check">
				<input type="checkbox" name="penbird_disable_title" value="1" <?php checked( get_post_meta( $post->ID, '_penbird_disable_title', true ) ); ?> />
				<?php esc_html_e( 'Disable Page Title', 'penbird' ); ?>
			</label>
			<label class="penbird-metabox__check">
				<input type="checkbox" name="penbird_disable_breadcrumb" value="1" <?php checked( get_post_meta( $post->ID, '_penbird_disable_breadcrumb', true ) ); ?> />
				<?php esc_html_e( 'Disable Breadcrumbs', 'penbird' ); ?>
			</label>
		</div>
	</div>
	<?php
}

/**
 * Save classic-editor page layout meta.
 *
 * @param int $post_id Post ID.
 */
function penbird_save_page_settings( $post_id ) {
	if ( ! isset( $_POST['penbird_page_settings_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['penbird_page_settings_nonce'] ) ), 'penbird_save_page_settings' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( 'page' !== get_post_type( $post_id ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['penbird_page_container'] ) ) {
		update_post_meta( $post_id, '_penbird_container', penbird_sanitize_page_container( sanitize_text_field( wp_unslash( $_POST['penbird_page_container'] ) ) ) );
	}

	if ( isset( $_POST['penbird_page_sidebar'] ) ) {
		update_post_meta( $post_id, '_penbird_sidebar', penbird_sanitize_page_sidebar( sanitize_text_field( wp_unslash( $_POST['penbird_page_sidebar'] ) ) ) );
	}

	update_post_meta( $post_id, '_penbird_disable_header', isset( $_POST['penbird_disable_header'] ) ? 1 : 0 );
	update_post_meta( $post_id, '_penbird_disable_footer', isset( $_POST['penbird_disable_footer'] ) ? 1 : 0 );
	update_post_meta( $post_id, '_penbird_disable_title', isset( $_POST['penbird_disable_title'] ) ? 1 : 0 );
	update_post_meta( $post_id, '_penbird_disable_breadcrumb', isset( $_POST['penbird_disable_breadcrumb'] ) ? 1 : 0 );
}
add_action( 'save_post_page', 'penbird_save_page_settings' );
