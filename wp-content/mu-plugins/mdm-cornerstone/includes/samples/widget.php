<?php

namespace Mdm\Cornerstone\Widgets;

class Sample extends \WP_Widget {

	public $widget_id_base;
	public $widget_name;
	public $widget_options;
	public $control_options;

	/**
	 * Constructor, initialize the widget
	 * @param $id_base, $name, $widget_options, $control_options ( ALL optional )
	 * @since 1.0.0
	 */
	public function __construct() {
		// Construct some options
		$this->widget_id_base = 'sample_widget_id';
		$this->widget_name    = 'Sample Widget';
		$this->widget_options = array(
			'classname'   => 'sample_widget_class',
			'description' => 'Sample Widget' );
		// Construct parent
		parent::__construct( $this->widget_id_base, $this->widget_name, $this->widget_options );
	}

	/**
	 * Create back end form for specifying image and content
	 * @param $instance
	 * @see https://codex.wordpress.org/Function_Reference/wp_parse_args
	 * @since 1.0.0
	 */
	public function form( $instance ) {
		// define our default values
		$defaults = array(
			'title' => null,
			'sample_option_1' => null,
			'sample_option_2' => null,
		);
		// merge instance with default values
		$instance = wp_parse_args( (array)$instance, $defaults );
		// include our form markup
		include \Mdm\Cornerstone\Plugin::path( 'includes/classes/samples/sample-widget-form.php' );
	}

	/**
	 * Update form values
	 * @param $new_instance, $old_instance
	 * @since 1.0.0
	 */
	public function update( $new_instance, $old_instance ) {
		// Sanitize / clean values
		$instance = array(
			'title'           => sanitize_text_field( $new_instance['title'] ),
			'sample_option_1' => sanitize_text_field( $new_instance['sample_option_1'] ),
			'sample_option_2' => sanitize_text_field( $new_instance['sample_option_2'] ),
		);
		// Merge values
		$instance = wp_parse_args( $instance, $old_instance );
		// Return values
		return $instance;
	}

	/**
	 * Output widget on the front end
	 * @param $args, $instance
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) {
		// Extract the widget arguments ( before_widget, after_widget, description, etc )
		extract( $args );
		// Display before widget args
		echo $before_widget;
		// Display Title
		if( !empty( $instance['title'] ) ) {
			$instance['title']  = apply_filters( 'widget_title', $instance['title'], $instance, $this->widget_id_base );
			// Again check if filters cleared name, in the case of 'dont show titles' filter or something
			$instance['title']  = ( !empty( $instance['title']  ) ) ? $args['before_title'] . $instance['title']  . $args['after_title'] : '';
			// Display Title
			echo $instance['title'];
		}

		/**
		 * DO WIDGETY STUFF
		 */

		// Display after widgets args
		echo $after_widget;
	} // end widget()

} // end class