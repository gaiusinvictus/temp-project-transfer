<?php

/**
 * The main plugin file definition
 * This file isn't instatiated directly, it acts as a shared parent for other classes
 * @link    http://midwestdigitalmarketing.com
 * @since   1.0.0
 * @package mdm_cornerstone
 */

namespace Mdm\Cornerstone;

class Plugin {

	/**
	 * Plugin Name
	 * @since 1.0.0
	 * @access protected
	 * @var (string) $name : The unique identifier for this plugin
	 */
	protected static $name = 'mdm_cornerstone';

	/**
	 * Plugin Version
	 * @since 1.0.0
	 * @access protected
	 * @var (string) $version : The version number of the plugin, used to version scripts / styles
	 */
	protected static $version = '0.1.0';

	/**
	 * Plugin Path
	 * @since 1.0.0
	 * @access protected
	 * @var (string) $path : The path to the plugins location on the server, is inherited by child classes
	 */
	protected static $path;

	/**
	 * Plugin URL
	 * @since 1.0.0
	 * @access protected
	 * @var (string) $url : The URL path to the location on the web, accessible by a browser
	 */
	protected static $url;

	/**
	 * Plugin Slug
	 * @since 1.0.0
	 * @access protected
	 * @var (string) $slug : Basename of the plugin, needed for Wordpress to set transients, and udpates
	 */
	protected static $slug;

	/**
	 * Plugin Options
	 * @since 1.0.0
	 * @access protected
	 * @var (array) $settings : The array that holds plugin options
	 */
	protected $loader;

	/**
	 * Instances
	 * @since 1.0.0
	 * @access protected
	 * @var (array) $instances : Collection of instantiated classes
	 */
	protected static $instances = array();

	/**
	 * Registers our plugin with WordPress.
	 */
	public static function register( $class_name = null ) {
		// Get called class
		$class_name = !is_null( $class_name ) ? $class_name : get_called_class();
		// Instantiate class
		$class = $class_name::get_instance( $class_name );
		// Create API manager
		$class->loader = \Mdm\Cornerstone\Loader::get_instance();
		// Register stuff
		$class->loader->register( $class );
		// Return instance
		return $class;
	}

	/**
	 * Gets an instance of our class.
	 */
	public static function get_instance( $class_name = null ) {
		// Use late static binding to get called class
		$class = !is_null( $class_name ) ? $class_name : get_called_class();
		// Get instance of class
		if( !isset(self::$instances[$class] ) ) {
			self::$instances[$class] = new $class();
		}
		return self::$instances[$class];
	}

	/**
	 * Constructor
	 * @since 1.0.0
	 * @access protected
	 */
	protected function __construct() {
		self::$path = plugin_dir_path( MDM_CORNERSTONE_ROOT ) . 'mdm-cornerstone/';
		self::$url  = plugin_dir_url( MDM_CORNERSTONE_ROOT ) . 'mdm-cornerstone/';
		self::$slug = plugin_basename( MDM_CORNERSTONE_ROOT );
	}

	/**
	 * Helper function to use relative URLs
	 * @since 1.0.0
	 * @access protected
	 */
	public static function url( $url = '' ) {
		return self::$url . ltrim( $url, '/' );
	}

	/**
	 * Helper function to use relative paths
	 * @since 1.0.0
	 * @access protected
	 */
	public static function path( $path = '' ) {
		return self::$path . ltrim( $path, '/' );
	}

	public function burn_baby_burn() {
		$classes = $this->get_child_classes( self::path( 'includes/classes' ) );
		// Loop through each post type
		foreach( $classes as $class_name => $class_path ) {
			// Append namespace
			$class_name = '\\Mdm\\Cornerstone\\Classes\\' . $class_name;
			// // Register
			$class_name::register();
		}
	}

	protected static function get_child_classes( $path = null ) {
		$classes = array();
		// Try to create path from called class if no path is passed in
		if( empty( $path ) ) {
			return array();
			// // Use ReflectionClass to get the shortname
			// $reflection = new \ReflectionClass( get_called_class() );
			// // Attempt to construct to path
			// $path = self::path( sprintf( 'includes/classes/%s/', strtolower( $reflection->getShortName() ) ) );
		}

		$files = glob( trailingslashit( $path ) . '*.php' );

		foreach( $files as $file ) {
			$classes[str_replace( '.php', '', basename( $file ) ) ] = $file;
		}
		return $classes;
	}

	public static function __return_string( $string ) {
		if( is_array( $string ) ) {
			return json_encode( $string );
		} else {
			return $string;
		}
	}

	public static function expose( $item ) {
		if( is_admin() ) {
			echo '<pre style="margin-left: 200px">';
		} else {
			echo '<pre>';
		}
		print_r($item);
		echo '</pre>';
	}

} // end class