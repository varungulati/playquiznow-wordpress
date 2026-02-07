( function () {
	'use strict';

	var ALLOWED_ORIGIN = 'https://playquiznow.com';
	var MAX_HEIGHT = 5000;

	window.addEventListener( 'message', function ( event ) {
		if ( event.origin !== ALLOWED_ORIGIN ) {
			return;
		}

		var data = event.data;
		if ( ! data || typeof data !== 'object' || ! data.type ) {
			return;
		}

		switch ( data.type ) {
			case 'pqn-resize':
				handleResize( event, data );
				break;
			case 'pqn-quiz-complete':
				handleQuizComplete( data );
				break;
		}
	} );

	function handleResize( event, data ) {
		var height = parseInt( data.height, 10 );
		if ( ! height || height < 100 ) {
			return;
		}
		if ( height > MAX_HEIGHT ) {
			height = MAX_HEIGHT;
		}

		var iframes = document.querySelectorAll( 'iframe.playquiznow-iframe' );
		for ( var i = 0; i < iframes.length; i++ ) {
			var iframe = iframes[ i ];
			if ( data.quizId ) {
				if ( iframe.dataset.quizId !== data.quizId ) {
					continue;
				}
			} else {
				try {
					if ( iframe.contentWindow !== event.source ) {
						continue;
					}
				} catch ( e ) {
					continue;
				}
			}
			iframe.style.height = height + 'px';
		}
	}

	function handleQuizComplete( data ) {
		if ( typeof window.gtag === 'function' ) {
			window.gtag( 'event', 'quiz_complete', {
				event_category: 'PlayQuizNow',
				event_label: data.quizId || '',
				value: data.score || 0,
			} );
		}
	}
} )();
