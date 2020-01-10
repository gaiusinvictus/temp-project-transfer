<?php

namespace Mdm\Cornerstone\PostTypes;

class Sample extends \Mdm\Cornerstone\Plugin {

	/**
	 * Get post type arguments
	 *
	 * I recommend using a tool such as GenerateWP to easily generate post type arguments
	 *
	 * @see https://generatewp.com/post-type/
	 * @since 1.0.0
	 */
	public static function get_post_type_args() {
		$labels = array(
			'name'                  => _x( 'Samples', 'Post Type General Name', self::$name ),
			'singular_name'         => _x( 'Sample', 'Post Type Singular Name', self::$name ),
			'menu_name'             => __( 'Sample Post Type', self::$name ),
			'name_admin_bar'        => __( 'Sample Post Type', self::$name ),
			'archives'              => __( 'Item Archives', self::$name ),
			'attributes'            => __( 'Item Attributes', self::$name ),
			'parent_item_colon'     => __( 'Parent Item:', self::$name ),
			'all_items'             => __( 'All Items', self::$name ),
			'add_new_item'          => __( 'Add New Item', self::$name ),
			'add_new'               => __( 'Add New', self::$name ),
			'new_item'              => __( 'New Item', self::$name ),
			'edit_item'             => __( 'Edit Item', self::$name ),
			'update_item'           => __( 'Update Item', self::$name ),
			'view_item'             => __( 'View Item', self::$name ),
			'view_items'            => __( 'View Items', self::$name ),
			'search_items'          => __( 'Search Item', self::$name ),
			'not_found'             => __( 'Not found', self::$name ),
			'not_found_in_trash'    => __( 'Not found in Trash', self::$name ),
			'featured_image'        => __( 'Featured Image', self::$name ),
			'set_featured_image'    => __( 'Set featured image', self::$name ),
			'remove_featured_image' => __( 'Remove featured image', self::$name ),
			'use_featured_image'    => __( 'Use as featured image', self::$name ),
			'insert_into_item'      => __( 'Insert into item', self::$name ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', self::$name ),
			'items_list'            => __( 'Items list', self::$name ),
			'items_list_navigation' => __( 'Items list navigation', self::$name ),
			'filter_items_list'     => __( 'Filter items list', self::$name ),
		);
		$rewrite = array(
			'slug'                  => 'samples',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Sample', self::$name ),
			'description'           => __( 'Post Type Description', self::$name ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'excerpt', 'genesis-seo', 'genesis-cpt-archives-settings', 'genesis-layouts', 'genesis-scripts' ),
			'taxonomies'            => array( 'category', 'post_tag', 'sample' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'rewrite'               => $rewrite,
		);

		return $args;
	}
}