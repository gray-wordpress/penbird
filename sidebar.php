<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PenBird
 */

$penbird_sidebar_id = penbird_get_sidebar_id();

if ( ! is_active_sidebar( $penbird_sidebar_id ) ) {
	return;
}
?>

<aside id="penbird-primary-sidebar" class="widget-area">
	<?php dynamic_sidebar( $penbird_sidebar_id ); ?>
</aside>
