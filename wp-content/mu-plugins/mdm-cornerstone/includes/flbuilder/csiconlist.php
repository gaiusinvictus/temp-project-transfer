<?php

namespace Mdm\Cornerstone\FLBuilder;

class CSIconList extends \FLBuilderModule implements \Mdm\Cornerstone\Interfaces\Action_Hook_Subscriber, \Mdm\Cornerstone\Interfaces\Filter_Hook_Subscriber {

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
			'name'          	=> __( 'Icon List', 'mdm_cornerstone' ),
			'description'   	=> __( '', 'mdm_cornerstone' ),
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

		echo '<ul class="cs-icon-list">';

		foreach( $settings->rows as $li ) {
			echo '<li>';
			if( !empty( $settings->icon ) || !empty( $li->icon ) ) {
				echo '<span class="bullet">';
					echo !empty( $li->icon ) ? "<span class='icontainer {$li->icon}'></span>" : "<span class='icontainer {$settings->icon}'></span>";
				echo '</span>';
			}
			echo "<span class='content'>{$li->content}</span>";
			echo '</li>';
		}

		echo '</ul>';

		// $title = isset( $settings->headline ) ? trim( $settings->headline ) : 'Downloads';

		// echo '<table class="file-list">';
		// 	echo '<thead>';
		// 		echo "<tr><th>{$title}</th></tr>";
		// 	echo '</thead>';
		// 	echo '<tbody>';

		// 		foreach( $settings->rows as $row ) :

		// 			echo '<tr><td>';
		// 				echo "<a href='{$row->file}' target='_blank' download>";
		// 				echo isset( $row->icon ) && !empty( $row->icon ) ? "<span class='icontainer {$row->icon}'></span>" : '';
		// 				echo "<span class='title'>{$row->title}</span></a>";
		// 			echo '</td></tr>';

		// 		endforeach;

		// 	echo '</tbody>';
		// echo '</table>';
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
							'icon' => array(
							    'type'          => 'icon',
							    'label'         => 'List Icon',
							    'show_remove'   => true
							),
							'rows' => array(
							    'type'          => 'form',
							    'label'         => __( 'List Item', 'wpcl_beaver_extender' ),
							    'form'   => 'csiconlist_item',
							    'preview_text'  => 'content',
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
		\FLBuilder::register_settings_form( 'csiconlist_item' , array(
			'title' => __( 'Add List Item', 'fl-builder' ),
			'tabs'  => array(
				'general'       => array( // Tab
					'title'         => __( 'General', 'wpcl_beaver_extender' ), // Tab title
					'sections'      => array( // Tab Sections
						'general'       => array( // Section
							'title'         => '', // Section Title
							'fields'        => array( // Section Fields
								'icon' => array(
								    'type'          => 'icon',
								    'label'         => 'Icon',
								    'show_remove'   => true,
								    'preview'         => array(
								    	'type'            => 'refresh',
								    ),
								),
								'content'          => array(
									'label'         => 'Content',
									'type'          => 'editor',
									'media_buttons' => false,
									'wpautop'       => true,
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