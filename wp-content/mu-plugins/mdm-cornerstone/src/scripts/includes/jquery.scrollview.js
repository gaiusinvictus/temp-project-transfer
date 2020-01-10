( function( $ ) {
	'use strict';
	$.fn.ScrollView = function( options ) {

		var transitionEnd;
		// Transitional elements
		transitionEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend';
		// Extend options
		options = $.extend( {}, { triggerOffset : 0 }, options );

		return $.map( this, function( el ) {
			return new InView( el );
		});

		function InView( el ) {
			var $el, $waypoint, animations = {};

			var _cacheDom = function() {
				$el = $( el );
				animations = {
					enter : $el.data( 'enter-animation' ),
					exit  : $el.data( 'exit-animation' ),
					onload : $el.data( 'onload-animation' )
				};
			};

			var _bindEvents = function() {
				$el.one( '_animate', _animate );
			};

			var _createWaypoint = function() {
				$waypoint = new Waypoint.Inview( {
			    	element: $el,
			      	enter: function( direction ) {
			      		if( direction === 'down' ) {
			      			$el.trigger( '_animate', [ { direction : direction, timing : 'enter' } ] );
			      		}
			      	},
			    	entered: function(direction) {
			    		if( direction === 'down' ) {
			    			$el.trigger( '_animate', [ { direction : direction, timing : 'entered' } ] );
			    		}
			    	},
			    	exit: function(direction) {
			    		if( direction === 'up' ) {
			    			$el.trigger( '_animate', [ { direction : direction, timing : 'exit' } ] );
			    		}
			    	},
			    	exited: function(direction) {
			    		if( direction === 'up' ) {
			    			$el.trigger( '_animate', [ { direction : direction, timing : 'exited' } ] );
			    		}
			    	}
			    });
			};

			var _animate = function( event, data ) {

				if( typeof animations[data.timing] === 'undefined' ) {
					return false;
				}

				$el.addClass( 'animated ' + animations[data.timing] ).one( transitionEnd, function() {
				    $el.removeClass( 'animated ' + animations[data.timing] );
				});

			};

			/**
			 * Anonomous init function
			 * Organize execution of module
			 * @type self invoking function to kickoff the module
			 */
			( function() {
			    _cacheDom();
			    // If an anload animation exists, clear onload and delay bind events
			    if( $el.hasClass( 'animated' ) && typeof animations.onload !== 'undefined' ) {
			    	setTimeout( function(){
			    		// Clear the onload animation
			    		// $el.removeClass( 'animated ' + animations.onload );
			    		//
			    		// Bind the events
			    		// _bindEvents();
			    	}, 1000 );
			    } else {
			    	// Else bind events immediatly
			    	_bindEvents();
			    }
			    // Create the waypoint
			    _createWaypoint();

			})();

			return $el;
		}
	};

})( jQuery );