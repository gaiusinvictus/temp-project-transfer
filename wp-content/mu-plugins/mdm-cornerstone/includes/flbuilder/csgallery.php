<?php

namespace Mdm\Cornerstone\FLBuilder;

use \Mdm\Cornerstone\Classes\Utilities as Utilities;

class CSGallery extends \FLBuilderModule implements \Mdm\Cornerstone\Interfaces\Action_Hook_Subscriber, \Mdm\Cornerstone\Interfaces\Filter_Hook_Subscriber {

	/**
	 * API Manager / Loader to interact with the other parts of the plugin
	 * @since 1.0.0
	 * @var (object) $api : The instance of the api manager class
	 */
	protected $api;

	/**
	 * Hook Name
	 * @since 1.0.0
	 * @var [string] : hook name, same as the slug created later by FLBuilderModule
	 */
	protected $hook_name;

	/**
	 * @method __construct
	 */
	public function __construct() {

		/**
		 * Set the hook name. Same as the slug, but created here so we can access it
		 */
		$this->hook_name = basename( __FILE__, '.php' );

		/**
		 * Get the API instance to interact with the other parts of our plugin
		 */
		$this->api = \Mdm\Cornerstone\Loader::get_instance( $this );

		/**
		 * Construct our parent class (FLBuilderModule);
		 */
		parent::__construct( array(
			'name'          	=> __( 'Gallery', 'mdm_cornerstone' ),
			'description'   	=> '',
			'category'      	=> __( 'Custom', 'mdm_cornerstone' ),
			'editor_export' 	=> true,
			'partial_refresh'	=> true,
		));

		$this->add_js('jquery-magnificpopup');
		$this->add_css('jquery-magnificpopup');

		// wp_enqueue_script( 'be-google-maps', sprintf( '//maps.googleapis.com/maps/api/js?key=%s', 'AIzaSyD3vRSONT1Ii_8_mFLx8QJi6Zis9Zrx1Uk' ), array(), '', false );

		// wp_enqueue_script( 'zonemap' );
	}

	/**
	 * Get the action hooks this class subscribes to.
	 * @return array
	 */
	public function get_actions() {
		return array(
			array( "mdm_cornerstone_frontend_{$this->hook_name}" => array( 'do_frontend' , 10, 3 ) ),
			array( "mdm_cornerstone_css_{$this->hook_name}" => array( 'do_css' , 10, 3 ) ),
			array( "mdm_cornerstone_js_{$this->hook_name}" => array( 'do_js' , 10, 3 ) ),
		);
	}

	/**
	 * Get the filter hooks this class subscribes to.
	 * @return array
	 */
	public function get_filters() {
		return array(

		);
	}

	/**
	 * Organize the front end output
	 * @param  [object] $module  : The instance of this module
	 * @param  [array] $settings : The array of settings for this instance
	 * @param  [string] $id : the unique ID of the module
	 */
	public function do_frontend( $module, $settings, $id ) {
		// Bail if it's not this specific instance
		if( $module !== $this || !is_object( $settings ) ) {
			return;
		}

		if( empty( $settings->photos ) ) {
			return;
		}

		Utilities::markup( array(
			'open' => '<div %s>',
			'context' => 'be-gallery',
			'instance' => $module,
		) );

		$args = '';

		if( !empty( $settings->cols ) ) {
			$args .= " columns='{$settings->cols}'";
		}
		if( !empty( $settings->orderby ) ) {
			$args .= " orderby='{$settings->orderby}'";
		}
		if( !empty( $settings->order ) ) {
			$args .= " order='{$settings->order}'";
		}
		if( !empty( $settings->size ) ) {
			$args .= " size='{$settings->size}'";
		}
		if( !empty( $settings->link_to ) ) {
			$args .= " link='{$settings->link_to}'";
		}
		if( !empty( $settings->photos ) ) {
			$ids = implode( ',', $settings->photos );

			$args .= " include='{$ids}'";
		}

		if( !empty( $settings->gallery_type ) ) {
			$args .= " type='{$settings->gallery_type}'";
		}

		$args = trim( $args );

		echo do_shortcode( "[gallery {$args}]" );

		Utilities::markup( array(
			'close' => '</div>',
			'context' => 'be-gallery',
		) );

	}

	/**
	 * Organize the css output
	 * @param  [object] $module  : The instance of this module
	 * @param  [array] $settings : The array of settings for this instance
	 * @param  [string] $id : the unique ID of the module
	 */
	public function do_css( $module, $settings, $id ) {
		/**
		 * Bail if not this instance
		 */
		if( $module !== $this || !is_object( $settings ) ) {
			return;
		}



	}

	/**
	 * Organize the js output
	 * @param  [object] $module  : The instance of this module
	 * @param  [array] $settings : The array of settings for this instance
	 * @param  [string] $id : the unique ID of the module
	 */
	public function do_js( $module, $settings, $id ) {
		/**
		 * Bail if not this instance
		 */
		if( $module !== $this || !is_object( $settings ) ) {
			return;
		}

		//echo '$(document).ready(function() { $(".lightbox").magnificPopup({type:"image", delegate: "a", gallery:{enabled:true}});});';

	}

	private function get_image_sizes() {
		$sizes = get_intermediate_image_sizes();

		$settings = array();

		foreach( $sizes as $size ) {
			$settings[$size] = $size;
		}

		return $settings;
	}

	/**
	 * Register the module and its form settings.
	 */
	public function register_module() {
		\FLBuilder::register_module( __CLASS__, array(
			'general' => array(
				'title' => __( 'General', 'fl-builder' ),
				'sections' => array(
					'general' => array(
						'title' => '',
						'fields' => array(
							'photos' => array(
							    'type'          => 'multiple-photos',
							    'label'         => __( 'Multiple Photos Field', 'fl-builder' )
							),
							'link_to' => array(
							    'type'          => 'select',
							    'label'         => __( 'Link To', 'fl-builder' ),
							    'default'       => 'none',
							    'options'       => array(
							        'none'      => __( 'None', 'fl-builder' ),
							        'media'      => __( 'Media File', 'fl-builder' ),
							        'attachment'      => __( 'Attachment Page', 'fl-builder' )
							    ),
							),
							'cols' => array(
								'type'        => 'unit',
								'label'       => 'Columns',
								'description' => 'columns',
								'default'     => 3,
								'slider' => array(
									'min'  	=> 1,
									'max'  	=> 9,
									'step' 	=> 1,
								),
							),
							'orderby' => array(
							    'type'          => 'select',
							    'label'         => __( 'Order By', 'fl-builder' ),
							    'default'       => 'menu_order',
							    'options'       => array(
							        'menu_order'      => __( 'Menu Order', 'fl-builder' ),
							        'title'      => __( 'Title', 'fl-builder' ),
							        'post_date'      => __( 'Date', 'fl-builder' ),
							        'ID'      => __( 'ID', 'fl-builder' ),
							        'rand'      => __( 'Random', 'fl-builder' ),
							    ),
							),
							'order' => array(
								'type'    => 'button-group',
								'label'   => 'Order',
								'default' => 'ASC',
								'options' => array(
									'ASC'    => 'ASC',
									'DESC'    => 'DESC',
								),
							),
							'size' => array(
							    'type'          => 'select',
							    'label'         => __( 'Image Size', 'fl-builder' ),
							    'default'       => 'none',
							    'options'       => $this->get_image_sizes(),
							),
							'gallery_type' => array(
							    'type'          => 'select',
							    'label'         => __( 'Type', 'fl-builder' ),
							    'default'       => 'default',
							    'options'       => array(
							        'default'      => __( 'Default Grid', 'fl-builder' ),
							        'rectangular'      => __( 'Tiled Rectangular', 'fl-builder' ),
							        'square'      => __( 'Tiled Square', 'fl-builder' ),
							        'columns'      => __( 'Tiled Columns', 'fl-builder' ),
							        'circle'      => __( 'Circle', 'fl-builder' ),
							        // 'block'      => __( 'Block', 'fl-builder' ),
							    ),
							    // 'toggle'  => array(
							    // 	'default' => array(
							    // 		'fields' => array( 'size', 'order', 'orderby', 'link_to' ),
							    // 	),
							    // 	'block' => array(
							    // 		'fields' => array( 'link_to' ),
							    // 	),
							    // ),
							),
						),
					),
				),
			),
		));
	}
}