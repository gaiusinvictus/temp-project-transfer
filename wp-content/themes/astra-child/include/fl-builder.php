<?php

/**
 * Add our theme stylesheet as a dependency to beaver builder
 */
function astrachild_fl_builder_layout_style_dependencies( $deps ) {
	$deps[] = 'astra-child-theme-css';
	return $deps;
}
add_filter( 'fl_builder_layout_style_dependencies', 'astrachild_fl_builder_layout_style_dependencies' );