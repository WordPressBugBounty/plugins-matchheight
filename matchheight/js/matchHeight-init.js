( function( $ ) {
	'use strict';

	$( function() {
		var settings = window.matchHeightSettings || {};

		if ( ! settings.selector || 'function' !== typeof $.fn.matchHeight ) {
			return;
		}

		try {
			$( settings.selector ).matchHeight();
		} catch ( error ) {
			// An invalid selector should not prevent other front-end scripts from running.
			if ( window.console && 'function' === typeof window.console.warn ) {
				window.console.warn( 'matchHeight: invalid CSS selector.', error );
			}
		}
	} );
}( jQuery ) );
