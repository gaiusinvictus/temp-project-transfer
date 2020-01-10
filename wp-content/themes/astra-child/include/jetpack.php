<?php
/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function _s_jetpack_theme_support() {

	add_theme_support( 'jetpack-social-menu' );

	add_theme_support( 'jetpack-responsive-videos' );

	// add_theme_support( 'infinite-scroll', array(
	// 	'container' => 'main',
	// 	'render'    => '_s_infinite_scroll_render',
	// 	'footer'    => false, // false, or ID of element to match width
	// 	'wrapper' => false,
	// 	'type' => 'scroll', // click or scroll, or emit
	// ) );

	// add_theme_support( 'jetpack-content-options', array(
	//     'blog-display'       => 'excerpt', // the default setting of the theme: 'content', 'excerpt' or array( 'content', 'excerpt' ) for themes mixing both display.
	//     'author-bio'         => true, // display or not the author bio: true or false.
	//     'author-bio-default' => true, // the default setting of the author bio, if it's being displayed or not: true or false (only required if false).
	//     'masonry'            => '.site-main', // a CSS selector matching the elements that triggers a masonry refresh if the theme is using a masonry layout.
	//     'post-details'       => array(
	//         'stylesheet'      => 'themeslug-style', // name of the theme's stylesheet.
	//         'date'            => '.posted-on', // a CSS selector matching the elements that display the post date.
	//         'categories'      => '.cat-links', // a CSS selector matching the elements that display the post categories.
	//         'tags'            => '.tags-links', // a CSS selector matching the elements that display the post tags.
	//         'author'          => '.byline', // a CSS selector matching the elements that display the post author.
	//         'comment'         => '.comments-link', // a CSS selector matching the elements that display the comment link.
	//     ),
	//     'featured-images'    => array(
	//         'archive'         => true, // enable or not the featured image check for archive pages: true or false.
	//         'archive-default' => false, // the default setting of the featured image on archive pages, if it's being displayed or not: true or false (only required if false).
	//         'post'            => true, // enable or not the featured image check for single posts: true or false.
	//         'post-default'    => false, // the default setting of the featured image on single posts, if it's being displayed or not: true or false (only required if false).
	//         'page'            => true, // enable or not the featured image check for single pages: true or false.
	//         'page-default'    => false, // the default setting of the featured image on single pages, if it's being displayed or not: true or false (only required if false).
	//         'fallback'          => true, // enable or not the featured image fallback: true or false.
	//         'fallback-default'  => true, // the default setting for featured image fallbacks: true or false (only required if false)
	//     ),
	// ) );
}
add_action( 'after_setup_theme', '_s_jetpack_theme_support' );

/**
 * Remove default sharing
 */
function astra_child_remove_jp_share() {
    remove_filter( 'the_content', 'sharing_display', 19 );
    remove_filter( 'the_excerpt', 'sharing_display', 19 );
    if ( class_exists( 'Jetpack_Likes' ) ) {
        remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
    }
}
add_action( 'loop_start', 'astra_child_remove_jp_share' );
add_action( 'wp', 'astra_child_remove_jp_share' );
/**
 * Manually place jetpack sharing buttons when/how/where we want
 */
function astra_child_place_jp_share() {
	if ( function_exists( 'sharing_display' ) ) {
	    sharing_display( '', true );
	}

	if ( class_exists( 'Jetpack_Likes' ) ) {
	    $custom_likes = new Jetpack_Likes;
	    echo $custom_likes->post_likes( '' );
	}
}
add_action( 'astra_entry_bottom', 'astra_child_place_jp_share' );