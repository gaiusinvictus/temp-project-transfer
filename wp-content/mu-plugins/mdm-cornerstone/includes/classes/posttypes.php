<?php

namespace Mdm\Cornerstone\Classes;

class PostTypes extends \Mdm\Cornerstone\Plugin implements \Mdm\Cornerstone\Interfaces\Action_Hook_Subscriber {
	/**
	 * Get the action hooks this class subscribes to.
	 * @return array
	 */
	public function get_actions() {
		return array(
			array( 'init' => 'add_post_types' ),
		);
	}

	/**
	 * Register each custom post type with wordpressw
	 */
	public static function add_post_types() {
		// Get all post types
		$post_types = self::get_child_classes( self::path( 'includes/posttypes/' ) );
		// Loop through each post type
		foreach( $post_types as $post_type => $path ) {
			// Append namespace to post type
			$class = '\\Mdm\\Cornerstone\\PostTypes\\' . $post_type;
			// Initialize post type
			$pt = $class::register();
			// Register with wordpress
			register_post_type( $post_type, $pt::get_post_type_args() );
		}
	}

	public static function get_post_types() {
		return self::get_child_classes();
	}
}