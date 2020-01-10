<?php

namespace Mdm\Cornerstone\Classes;

class Utilities extends \Mdm\Cornerstone\Plugin {

	public static function markup( $args = array() ) {

		$defaults = array(
			'context' => '',
			'open'    => '',
			'close'   => '',
			'content' => '',
			'echo'    => true,
			'params'  => array(),
		);

		$args = wp_parse_args( $args, $defaults );

		/**
		 * Filter to short circuit the markup API.
		 *
		 * @since 1.0.0
		 *
		 * @param bool  false Flag indicating short circuit content.
		 * @param array $args Array with markup arguments.
		 *
		 * @see scaffoliding_markup $args Array.
		 */
		$override = apply_filters( "scaffoliding_markup_{$args['context']}", false, $args );

		if( $override !== false ) {
			if ( !$args['echo'] ) {
				return $override;
			}
			echo $override;
		}


		if ( $args['context'] ) {

			$open = $args['open'] ? sprintf( $args['open'], self::markup_attr( $args['context'], $args['params'], $args ) ) : '';

			/**
			 * Contextual filter to modify 'open' markup.
			 *
			 * @since 2.4.0
			 *
			 * @param string $open HTML tag being processed by the API.
			 * @param array  $args Array with markup arguments.
			 *
			 * @see scaffoliding_markup $args Array.
			 */
			$open = apply_filters( "scaffoliding_markup_{$args['context']}_open", $open, $args );

			/**
			 * Contextual filter to modify 'close' markup.
			 *
			 * @since 2.4.0
			 *
			 * @param string $close HTML tag being processed by the API.
			 * @param array  $args  Array with markup arguments.
			 *
			 * @see scaffoliding_markup $args Array.
			 */
			$close = apply_filters( "scaffoliding_markup_{$args['context']}_close", $args['close'], $args );

			/**
			 * Contextual filter to modify 'content'.
			 *
			 * @since 2.6.0
			 *
			 * @param string $content Content being passed through Markup API.
			 * @param array  $args  Array with markup arguments.
			 *
			 * @see scaffoliding_markup $args Array.
			 */
			$content = apply_filters( "scaffoliding_markup_{$args['context']}_content", $args['content'], $args );

		} else {

			$open    = $args['open'];
			$close   = $args['close'];
			$content = $args['content'];

		}

		if ( $open || $args['content'] ) {
			/**
			 * Non-contextual filter to modify 'open' markup.
			 *
			 * @since 2.4.0
			 *
			 * @param string $open HTML tag being processed by the API.
			 * @param array  $args Array with markup arguments.
			 *
			 * @see scaffoliding_markup $args Array.
			 */
			$open = apply_filters( 'cornerstone_markup_open', $open, $args );
		}

		if ( $close || $args['content'] ) {
			/**
			 * Non-contextual filter to modify 'close' markup.
			 *
			 * @since 2.4.0
			 *
			 * @param string $open HTML tag being processed by the API.
			 * @param array  $args Array with markup arguments.
			 *
			 * @see scaffoliding_markup $args Array.
			 */
			$close = apply_filters( 'cornerstone_markup_close', $close, $args );
		}

		if ( $args['echo'] ) {
			echo $open . $content . $close;
			return null;
		} else {
			return $open . $content . $close;
		}
	}

	public static function markup_attr( $context, $attributes = array(), $args = array() ) {

		$attributes = self::parse_attr( $context, $attributes, $args );

		$output = '';

		// Cycle through attributes, build tag attribute string.
		foreach ( $attributes as $key => $value ) {

			if ( !$value ) {
				continue;
			}

			if ( $value === true ) {
				$output .= esc_html( $key ) . ' ';
			} else {
				$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
			}

		}

		$output = apply_filters( "cornerstone_markup_attr_{$context}_output", $output, $attributes, $context, $args );

		return trim( $output );
	}

	public static function parse_attr( $context, $attributes = array(), $args = array() ) {

		$defaults = array(
			'class' => sanitize_html_class( $context ),
		);

		// Make sure each is a string or number
		foreach( $attributes as $att => $atts ) {
			if( is_object( $atts ) || is_array( $atts ) ) {
				unset( $attributes[$att] );
			}
		}

		if( isset( $attributes['class'] ) && !empty( trim( $attributes['class'] ) ) ) {
			$attributes['class'] = sanitize_html_class( $context ) . ' ' . trim( $attributes['class'] );
		}

		$attributes = wp_parse_args( $attributes, $defaults );
		// Generic filter
		$attributes = apply_filters( "cornerstone_markup_attr", $attributes, $context, $args );
		// Contextual filter.
		$attributes = apply_filters( "cornerstone_markup_attr_{$context}", $attributes, $context, $args );

		return $attributes;
	}

	public static function flbuilder_dimension_rule( $args = array() ) {

		$args = array_merge( array( 'settings' => null, 'setting_name' => null, 'selector' => null, 'rule' => 'margin' ), $args );

		if( !is_object( $args['settings'] ) || empty( $args['setting_name'] ) || empty( $args['selector'] ) ) {
			return;
		}

		$css = array(
			'base' => '',
			'medium' => '',
			'responsive' => '',
		);

		$units = array(
			'base' => isset( $args['settings']->{"{$args['setting_name']}_unit"} ) ? $args['settings']->{"{$args['setting_name']}_unit"} : 'px',
			'medium' => isset( $args['settings']->{"{$args['setting_name']}_medium_unit"} ) ? $args['settings']->{"{$args['setting_name']}_medium_unit"} : 'px',
			'responsive' => isset( $args['settings']->{"{$args['setting_name']}_responsive_unit"} ) ? $args['settings']->{"{$args['setting_name']}_responsive_unit"} : 'px',
		);

		foreach( array( 'top', 'right', 'bottom', 'left' ) as $pos ) {
			/**
			 * Base
			 */
			if( isset( $args['settings']->{"{$args['setting_name']}_{$pos}"} ) && !empty( $args['settings']->{"{$args['setting_name']}_{$pos}"} ) ) {
				$css['base'] .= "{$args['rule']}-{$pos}:" . $args['settings']->{"{$args['setting_name']}_{$pos}"} . $units['base'] . ';';
			}
			/**
			 * Medium
			 */
			if( isset( $args['settings']->{"{$args['setting_name']}_{$pos}_medium"} ) && !empty( $args['settings']->{"{$args['setting_name']}_{$pos}_medium"} ) ) {
				$css['medium'] .= "{$args['rule']}-{$pos}:" . $args['settings']->{"{$args['setting_name']}_{$pos}_medium"} . $units['medium'] . ';';
			}
			/**
			 * Responsive
			 */
			if( isset( $args['settings']->{"{$args['setting_name']}_{$pos}_responsive"} ) && !empty( $args['settings']->{"{$args['setting_name']}_{$pos}_responsive"} ) ) {
				$css['responsive'] .= "{$args['rule']}-{$pos}:" . $args['settings']->{"{$args['setting_name']}_{$pos}_mresponsive"} . $units['responsive'] . ';';
			}
		}


		//Gets media breakpoints and more
		$global_settings  = \FLBuilderModel::get_global_settings();

		$output  = '';

		if( !empty( $css['base'] ) ) {
			$output .= $args['selector'] . '{' . $css['base'] . '}';
		}

		if( !empty( $css['medium'] ) ) {
			$output .= "@media (max-width: {$global_settings->medium_breakpoint}px){" . $args['selector'] . '{' . $css['medium'] . '} }';
		}

		if( !empty( $css['responsive'] ) ) {
			$output .= "@media (max-width: {$global_settings->responsive_breakpoint}px){" . $args['selector'] . '{' . $css['responsive'] . '} }';
		}

		return $output;
	}

} // end class