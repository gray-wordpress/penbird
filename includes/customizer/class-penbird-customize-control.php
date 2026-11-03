<?php
/**
 * PenBird Customizer visual controls.
 *
 * Native WP_Customize_Control subclasses. Original PenBird UI.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'penbird_customizer_svg_kses' ) ) {
/**
 * Allowed SVG tags for Customizer icons.
 *
 * @return array
 */
function penbird_customizer_svg_kses() {
	$svg_attrs = array(
		'xmlns'        => true,
		'viewbox'      => true,
		'viewBox'      => true,
		'fill'         => true,
		'aria-hidden'  => true,
		'focusable'    => true,
		'width'        => true,
		'height'       => true,
		'role'         => true,
	);

	return array(
		'svg'    => $svg_attrs,
		'rect'   => array(
			'x'      => true,
			'y'      => true,
			'width'  => true,
			'height' => true,
			'rx'     => true,
			'fill'   => true,
		),
		'path'   => array(
			'd'            => true,
			'fill'         => true,
			'stroke'       => true,
			'stroke-width' => true,
		),
		'line'   => array(
			'x1'             => true,
			'y1'             => true,
			'x2'             => true,
			'y2'             => true,
			'stroke'         => true,
			'stroke-width'   => true,
			'stroke-linecap' => true,
		),
		'circle' => array(
			'cx'   => true,
			'cy'   => true,
			'r'    => true,
			'fill' => true,
		),
	);
}
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'PenBird_Customize_Visual_Radio_Control' ) ) {
	/**
	 * Visual radio / layout selector.
	 */
	class PenBird_Customize_Visual_Radio_Control extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'penbird_visual_radio';

		/**
		 * Value => inline SVG markup.
		 *
		 * @var array
		 */
		public $icons = array();

		/**
		 * Grid column count (2 or 3).
		 *
		 * @var int
		 */
		public $columns = 3;

		/**
		 * Render the control.
		 */
		public function render_content() {
			if ( empty( $this->choices ) ) {
				return;
			}

			$input_id = '_customize-input-' . $this->id;
			$desc_id  = '_customize-description-' . $this->id;
			$name     = '_customize-radio-' . $this->id;
			$columns  = ( 2 === (int) $this->columns ) ? 2 : 3;
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span id="<?php echo esc_attr( $input_id ); ?>-label" class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $desc_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
			<div class="penbird-visual-radio penbird-visual-radio--cols-<?php echo esc_attr( (string) $columns ); ?>" role="radiogroup" aria-labelledby="<?php echo esc_attr( $input_id ); ?>-label">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<?php
					$option_id = $input_id . '-' . $value;
					$icon      = isset( $this->icons[ $value ] ) ? $this->icons[ $value ] : '';
					?>
					<label class="penbird-visual-radio__option" for="<?php echo esc_attr( $option_id ); ?>">
						<input
							id="<?php echo esc_attr( $option_id ); ?>"
							class="penbird-visual-radio__input"
							type="radio"
							value="<?php echo esc_attr( $value ); ?>"
							name="<?php echo esc_attr( $name ); ?>"
							<?php $this->link(); ?>
							<?php checked( $this->value(), $value ); ?>
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
	}
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'PenBird_Customize_Toggle_Control' ) ) {
	/**
	 * Toggle switch for checkbox settings.
	 */
	class PenBird_Customize_Toggle_Control extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'penbird_toggle';

		/**
		 * Render the control.
		 */
		public function render_content() {
			$input_id = '_customize-input-' . $this->id;
			?>
			<div class="penbird-toggle">
				<label class="penbird-toggle__label" for="<?php echo esc_attr( $input_id ); ?>">
					<span class="penbird-toggle__copy">
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
						<?php endif; ?>
					</span>
					<input
						id="<?php echo esc_attr( $input_id ); ?>"
						class="penbird-toggle__input"
						type="checkbox"
						value="1"
						<?php $this->link(); ?>
						<?php checked( $this->value() ); ?>
					/>
					<span class="penbird-toggle__track" aria-hidden="true"></span>
				</label>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'penbird_customizer_icon' ) ) {
/**
 * Inline SVG icons for visual selectors.
 *
 * @param string $key Icon key.
 * @return string
 */
function penbird_customizer_icon( $key ) {
	$icons = array(
		'header-logo-menu' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="8" y="16" width="14" height="12" rx="2" fill="#0A2540"/><rect x="28" y="18" width="36" height="3" rx="1.5" fill="#605BE5"/><rect x="28" y="24" width="24" height="3" rx="1.5" fill="#0A2540"/></svg>',
		'header-centered'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="28" y="13" width="16" height="8" rx="2" fill="#0A2540"/><rect x="16" y="26" width="40" height="3" rx="1.5" fill="#605BE5"/></svg>',
		'header-split'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="8" y="16" width="12" height="12" rx="2" fill="#0A2540"/><rect x="26" y="20" width="20" height="3" rx="1.5" fill="#605BE5"/><rect x="54" y="17" width="10" height="10" rx="2" fill="#0A2540"/></svg>',
		'header-width-boxed' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="14" y="16" width="44" height="12" rx="2" fill="#605BE5"/></svg>',
		'header-width-full'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="8" y="16" width="56" height="12" rx="2" fill="#605BE5"/></svg>',
		'logo-left'          => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="16" width="16" height="12" rx="2" fill="#0A2540"/><rect x="32" y="20" width="26" height="4" rx="2" fill="#605BE5"/></svg>',
		'logo-center'        => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="28" y="16" width="16" height="12" rx="2" fill="#0A2540"/></svg>',
		'logo-right'         => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="14" y="20" width="26" height="4" rx="2" fill="#605BE5"/><rect x="46" y="16" width="16" height="12" rx="2" fill="#0A2540"/></svg>',
		'layout-default'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="12" width="24" height="20" rx="2" fill="#0A2540"/><rect x="38" y="12" width="24" height="20" rx="2" fill="#605BE5"/><circle cx="36" cy="22" r="5" fill="#fff"/><rect x="34" y="16" width="4" height="12" rx="2" fill="#0A2540"/></svg>',
		'container-boxed'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="14" y="12" width="44" height="20" rx="2" fill="#605BE5"/></svg>',
		'container-narrow' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="22" y="12" width="28" height="20" rx="2" fill="#605BE5"/></svg>',
		'container-full'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#605BE5"/></svg>',
		'sidebar-none'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="12" width="52" height="20" rx="2" fill="#605BE5"/></svg>',
		'sidebar-left'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="12" width="16" height="20" rx="2" fill="#0A2540"/><rect x="30" y="12" width="32" height="20" rx="2" fill="#605BE5"/></svg>',
		'sidebar-right'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="12" width="32" height="20" rx="2" fill="#605BE5"/><rect x="46" y="12" width="16" height="20" rx="2" fill="#0A2540"/></svg>',
		'align-left'       => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="14" width="40" height="3" rx="1.5" fill="#0A2540"/><rect x="10" y="21" width="30" height="3" rx="1.5" fill="#605BE5"/><rect x="10" y="28" width="36" height="3" rx="1.5" fill="#0A2540"/></svg>',
		'align-center'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="16" y="14" width="40" height="3" rx="1.5" fill="#0A2540"/><rect x="21" y="21" width="30" height="3" rx="1.5" fill="#605BE5"/><rect x="18" y="28" width="36" height="3" rx="1.5" fill="#0A2540"/></svg>',
		'align-right'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="22" y="14" width="40" height="3" rx="1.5" fill="#0A2540"/><rect x="32" y="21" width="30" height="3" rx="1.5" fill="#605BE5"/><rect x="26" y="28" width="36" height="3" rx="1.5" fill="#0A2540"/></svg>',
		'footer-one'       => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="14" width="52" height="16" rx="2" fill="#605BE5"/></svg>',
		'footer-two'       => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="14" width="24" height="16" rx="2" fill="#605BE5"/><rect x="38" y="14" width="24" height="16" rx="2" fill="#0A2540"/></svg>',
		'footer-three'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 44" fill="none" aria-hidden="true" focusable="false"><rect x="4" y="8" width="64" height="28" rx="3" fill="#F6F9FC"/><rect x="10" y="14" width="15" height="16" rx="2" fill="#605BE5"/><rect x="29" y="14" width="15" height="16" rx="2" fill="#0A2540"/><rect x="48" y="14" width="15" height="16" rx="2" fill="#605BE5"/></svg>',
	);

	return isset( $icons[ $key ] ) ? $icons[ $key ] : '';
}
}
