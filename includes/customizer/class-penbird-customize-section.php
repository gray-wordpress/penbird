<?php
/**
 * Nested Customizer section.
 *
 * WordPress core is Panel → Section → Controls only. This subclass exports a
 * parent `section` id so child sections can live inside another section.
 *
 * @package PenBird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PenBird_Customize_Section' ) ) {
	/**
	 * Customizer section that can nest inside another section.
	 */
	class PenBird_Customize_Section extends WP_Customize_Section {

		/**
		 * Parent section ID. Empty for top-level sections inside a panel.
		 *
		 * @var string
		 */
		public $section = '';

		/**
		 * JS constructor key.
		 *
		 * @var string
		 */
		public $type = 'penbird_section';

		/**
		 * Export parent section id to the Customizer JS app.
		 *
		 * @return array
		 */
		public function json() {
			$array                   = wp_array_slice_assoc(
				(array) $this,
				array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section' )
			);
			$array['title']          = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content']        = $this->get_content();
			$array['active']         = $this->active();
			$array['instanceNumber'] = $this->instance_number;

			$parent_section = ( $this->section ) ? $this->manager->get_section( $this->section ) : null;
			$parent_panel   = ( $this->panel ) ? $this->manager->get_panel( $this->panel ) : null;

			if ( $parent_section ) {
				$array['customizeAction'] = sprintf(
					/* translators: &#9656; is the unicode right-pointing triangle. %s: Parent section title. */
					__( 'Customizing &#9656; %s', 'penbird' ),
					esc_html( $parent_section->title )
				);
			} elseif ( $parent_panel ) {
				$array['customizeAction'] = sprintf(
					/* translators: &#9656; is the unicode right-pointing triangle. %s: Panel title. */
					__( 'Customizing &#9656; %s', 'penbird' ),
					esc_html( $parent_panel->title )
				);
			} else {
				$array['customizeAction'] = __( 'Customizing', 'penbird' );
			}

			return $array;
		}
	}
}

if ( ! function_exists( 'penbird_add_customize_section' ) ) {
	/**
	 * Register a PenBird section. Pass `section` to nest under another section.
	 *
	 * Child sections still use `panel` => Theme Settings so a failed nest cannot
	 * dump them at the Customizer root.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer.
	 * @param string               $id           Section ID.
	 * @param array                $args         Section args.
	 */
	function penbird_add_customize_section( $wp_customize, $id, $args ) {
		$wp_customize->add_section( new PenBird_Customize_Section( $wp_customize, $id, $args ) );
	}
}
