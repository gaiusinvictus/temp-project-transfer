<?php

namespace Mdm\Cornerstone\Taxonomies;

class PageCategory extends \Mdm\Cornerstone\Plugin {

	/**
	 * Get taxomony arguments
	 *
	 * I recommend using a tool such as GenerateWP to easily generate taxonomy arguments
	 *
	 * @see  https://generatewp.com/taxonomy/
	 * @since 1.0.0
	 */
	public static function get_tax_args() {
		$labels = array(
			'name'                       => _x( 'Page Categories', 'Taxonomy General Name', self::$name ),
			'singular_name'              => _x( 'Page Category', 'Taxonomy Singular Name', self::$name ),
			'menu_name'                  => __( 'Page Categories', self::$name ),
			'all_items'                  => __( 'All Items', self::$name ),
			'parent_item'                => __( 'Parent Item', self::$name ),
			'parent_item_colon'          => __( 'Parent Item:', self::$name ),
			'new_item_name'              => __( 'New Item Name', self::$name ),
			'add_new_item'               => __( 'Add New Item', self::$name ),
			'edit_item'                  => __( 'Edit Item', self::$name ),
			'update_item'                => __( 'Update Item', self::$name ),
			'view_item'                  => __( 'View Item', self::$name ),
			'separate_items_with_commas' => __( 'Separate items with commas', self::$name ),
			'add_or_remove_items'        => __( 'Add or remove items', self::$name ),
			'choose_from_most_used'      => __( 'Choose from the most used', self::$name ),
			'popular_items'              => __( 'Popular Items', self::$name ),
			'search_items'               => __( 'Search Items', self::$name ),
			'not_found'                  => __( 'Not Found', self::$name ),
			'no_terms'                   => __( 'No items', self::$name ),
			'items_list'                 => __( 'Items list', self::$name ),
			'items_list_navigation'      => __( 'Items list navigation', self::$name ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'show_in_rest'               => true,
		);
		return $args;
	}

	/**
	 * Return the post type(s) this taxonomy should attach to
	 *
	 * @return array : Array of all post types this taxonomy belongs to
	 */
	public static function get_tax_post_types() {
		return array( 'page' );
	}
}