<?php
/**
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package astra-child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_VERSION', WP_DEBUG === true ? time() : '1.0.0' );
define( 'CHILD_THEME_ROOT_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'CHILD_THEME_ROOT_URL', trailingslashit( get_stylesheet_directory_uri() ) );
/**
 * Define $content_width variable for embeds, jetpack, etc
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}
/**
 * Include customizer file if user is logged in
 */
if( is_user_logged_in() ) {
	include CHILD_THEME_ROOT_DIR . 'include/customizer.php';
}
/**
 * Maybe include jetpack
 */
if( class_exists( 'Jetpack' ) ) {
	include CHILD_THEME_ROOT_DIR . 'include/jetpack.php';
}

function astra_child_context() {

	$context = 'default';

	if( is_front_page() && !is_home() ) {
		$context = 'frontpage';
	}

	else if( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		$context = 'woocommerce';
	}

	else if( is_archive() ) {
		$context = 'archive';
	}

	else if( is_search() ) {
		$context = 'search';
	}

	else if( is_home() ) {
		$context = 'blog';
	}

	else if( is_singular() ) {
		$context = 'single';
	}

	else if( is_404() ) {
		$context = '404';
	}

	$context = apply_filters( 'astra_child_context', $context );

	return $context;
}

/**
 * Enqueue styles
 */
function astra_child_enqueue_styles() {

	wp_enqueue_script( 'astra-child-theme-js', CHILD_THEME_ROOT_URL . 'assets/js/public.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	wp_enqueue_style( 'astra-child-theme-css', CHILD_THEME_ROOT_URL . 'assets/css/public.css', array(), CHILD_THEME_VERSION, 'all' );

}
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles', 15 );

function astra_child_contextual_include() {

	$context = astra_child_context();

	if( file_exists( CHILD_THEME_ROOT_DIR . 'include/' . $context . '.php' ) ) {
		include CHILD_THEME_ROOT_DIR . 'include/' . $context . '.php';
	}
}
add_action( 'wp', 'astra_child_contextual_include' );


