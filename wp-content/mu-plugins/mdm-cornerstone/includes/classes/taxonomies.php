<?php

namespace Mdm\Cornerstone\Classes;

class Taxonomies extends \Mdm\Cornerstone\Plugin implements \Mdm\Cornerstone\Interfaces\Action_Hook_Subscriber {

	/**
	 * Get the action hooks this class subscribes to.
	 * @return array
	 */
	public function get_actions() {
		return array(
			array( 'init' => 'add_taxonomies' ),
		);
	}

	/**
	 * Register taxonomies
	 * @see https://codex.wordpress.org/Function_Reference/register_taxonomy_for_object_type
	 * @see https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public static function add_taxonomies() {
		// Get all taxonomies
		$taxonomies = self::get_child_classes( self::path( 'includes/taxonomies/' ) );
		// Iterate and register each
		foreach( $taxonomies as $taxonomy => $path ) {
			// Append namespace to taxonomy
			$class = '\\Mdm\\Cornerstone\\Taxonomies\\' . $taxonomy;
			// Initialize post type
			$tax = $class::register();
			// Get the post types the taxonomy belongs to
			$post_types = $tax::get_tax_post_types();
			// Register with wordpress
			register_taxonomy( $taxonomy, $post_types, $tax::get_tax_args() );
			// Register for object type
			foreach( $post_types as $post_type ) {
				register_taxonomy_for_object_type( $taxonomy, $post_type );
			}
		}
	}
}