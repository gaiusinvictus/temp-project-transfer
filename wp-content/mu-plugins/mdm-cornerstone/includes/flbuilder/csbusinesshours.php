<?php

namespace Mdm\Cornerstone\FLBuilder;

class CSBusinessHours extends \FLBuilderModule implements \Mdm\Cornerstone\Interfaces\Action_Hook_Subscriber, \Mdm\Cornerstone\Interfaces\Filter_Hook_Subscriber {

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
			'name'          	=> __( 'Business Hours', 'mdm_cornerstone' ),
			'description'   	=> __( 'Business Hours Table', 'mdm_cornerstone' ),
			'category'      	=> __( 'Custom', 'mdm_cornerstone' ),
			'editor_export' 	=> true,
			'partial_refresh'	=> true,
		));
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

		echo '<table class="business-hours">';
			echo '<tbody>';

				foreach( $settings->rows as $row ) :

					printf( '<tr><th class="title"><span class="inner">%s</span></th><td class="hours"><span class="inner">%s</span></td></tr>',
						$row->title,
						$row->hours
					);

				endforeach;

			echo '</tbody>';
		echo '</table>';
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
	}

	/**
	 * Register the module and its form settings.
	 */
	public function register_module() {
		\FLBuilder::register_module( __CLASS__, array(
			'general'       => array( // Tab
				'title'         => __( 'General', 'wpcl_beaver_extender' ), // Tab title
				'sections'      => array( // Tab Sections
					'general'       => array( // Section
						'title'         => '', // Section Title
						'fields'        => array( // Section Fields
							'rows' => array(
							    'type'          => 'form',
							    'label'         => __( 'Table Row', 'wpcl_beaver_extender' ),
							    'form'   => 'csbusinesshours_item',
							    'preview_text'  => 'title',
							    'multiple'     => true,
							),
						),
					),
				),
			),
		) );
		/**
		 * Register a settings form to use in the "form" field type above.
		 */
		\FLBuilder::register_settings_form( 'csbusinesshours_item' , array(
			'title' => __( 'Add Row', 'fl-builder' ),
			'tabs'  => array(
				'general'       => array( // Tab
					'title'         => __( 'General', 'wpcl_beaver_extender' ), // Tab title
					'sections'      => array( // Tab Sections
						'general'       => array( // Section
							'title'         => '', // Section Title
							'fields'        => array( // Section Fields
								'title'          => array(
									'type'          => 'text',
									'label'         => 'Title',
									'default'       => '',
									'preview'         => array(
										'type'            => 'refresh',
									),
								),
								'hours'          => array(
									'type'          => 'text',
									'label'         => 'Hours',
									'default'       => '',
									'preview'         => array(
										'type'            => 'refresh',
									),
								),
							),
						),
					),
				),
			),
		) );
	}
}