( function( $ ) {
	'use strict';
	$.fn.ScrollToggle = function( options ) {

		var transitionEnd, states, antistates;
		// Transitional elements
		transitionEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend';
		// Classes to add during a transition
		states = {
			'up' : {
				'transition' : 'scrollingUp',
				'complete'   : 'scrollUp',
			},
			'down' : {
				'transition' : 'scrollingDown',
				'complete'   : 'scrollDown',
			},
		};
		// Classes to remove during a transition
		antistates = {
			'up' : {
				'transition' : 'scrollDown scrollingDown scrollUp',
				'complete'   : 'scrollDown scrollingDown scrollingUp',
			},
			'down' : {
				'transition' : 'scrollDown scrollingUp scrollUp',
				'complete'   : 'scrollingDown scrollingUp scrollUp',
			},
		};
		// Extend options
		options = $.extend( {}, { triggerOffset : 0 }, options );

		return $.map( this, function( el ) {
			return new Toggle( el );
		});

		function Toggle( el ) {
			var $el, $trigger, triggerOffset;
			var cacheDom = function() {
				// $trigger = $el;
				$el = $( el );
				$trigger = $el.data( 'trigger-element' ) || options.triggerElement || $el;
				triggerOffset = $el.data( 'trigger-offset' ) || options.triggerOffset;
			};

			var bindEvents = function() {
				$trigger.waypoint( scrollTrigger, { offset :triggerOffset } );
			};

			var scrollTrigger = function( direction ) {
				$el.trigger( 'scrolltoggle:start', [{ direction : direction }] );
				// Add classes to individual elements
				$el.stop().removeClass( antistates[direction].transition ).addClass( states[direction].transition ).one( transitionEnd, function() {
				    $el.addClass( states[direction].complete ).removeClass( antistates[direction].complete );
				});
				// Set timeout in case ending events done fire
				setTimeout( function() {
				    // If the class we need to remove was already removed by something else, let's remove the handler and bail
				    if( !$el.hasClass( states[direction].transition ) ) {
				        $el.off( transitionEnd );
				        return;
				    }
				    // If we made it here, we have some cleanup to do
				    $el.addClass( states[direction].complete ).removeClass( antistates[direction].complete );
				}, 1000 );
				$el.trigger( 'scrolltoggle:end', [{ direction : direction }] );
				return;
			};

			/**
			 * Anonomous init function
			 * Organize execution of module
			 * @type self invoking function to kickoff the module
			 */
			( function() {
			    cacheDom();
			    bindEvents();
			})();

			return $el;
		}
	};

})( jQuery );