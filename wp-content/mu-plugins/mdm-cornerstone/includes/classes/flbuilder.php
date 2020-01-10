<?php

/**
 * The plugin file that controls the admin functions
 * @link    http://midwestfamilymarketing.com
 * @since   1.0.0
 * @package mdm_wp_cornerstone
 */

namespace Mdm\Cornerstone\Classes;

class FLBuilder extends \Mdm\Cornerstone\Plugin implements \Mdm\Cornerstone\Interfaces\Action_Hook_Subscriber {


	/**
	 * Get the action hooks this class subscribes to.
	 * @since 1.0.0
	 * @return array
	 */
	public function get_actions() {
		return array(
			array( 'init' => 'setup_addon' ),
		);
	}
	// This is where you would register each module
	public function setup_addon() {
		if( !class_exists( 'FLBuilder' ) ) {
			return;
		}
		// Get all modules
		$modules = self::get_child_classes( self::path( 'includes/flbuilder/' ) );
		// Register each
		foreach( $modules as $module => $path ) {
			// Append namespace to module
			$module = '\\Mdm\\Cornerstone\\FLBuilder\\' . $module;
			// Get instance
			$instance = new $module();
			// Register with beaver builder
			$instance->register_module();
		}
	}

} // end class