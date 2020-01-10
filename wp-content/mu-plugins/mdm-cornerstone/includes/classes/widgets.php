<?php

/**
 * The plugin file that controls the widget hooks
 * @link    http://midwestfamilymarketing.com
 * @since   1.0.0
 * @package mdm_cornerstone
 */

namespace Mdm\Cornerstone\Classes;

class Widgets extends \Mdm\Cornerstone\Plugin implements \Mdm\Cornerstone\Interfaces\Action_Hook_Subscriber {

	protected static $widgets = array();

	/**
	 * Get the action hooks this class subscribes to.
	 * @return array
	 */
	public function get_actions() {
		return array(
			array( 'widgets_init' => 'add_widgets' ),
		);
	}

	public function add_widgets() {
		// Get all widgets
		$widgets = self::get_child_classes( self::path( 'includes/widgets/' ) );
		// Register each
		foreach( $widgets as $widget => $path ) {
			// Append namespace to widget
			$widget = '\\Mdm\\Cornerstone\\Widgets\\' . $widget;
			// Register with wordpress
			register_widget( $widget );
		}
	}
} // end class