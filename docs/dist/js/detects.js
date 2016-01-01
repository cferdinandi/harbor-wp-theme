/*!
 * harbor v1.0.0: A free WordPress theme for animal and pet rescue organizations
 * (c) 2015 Chris Ferdinandi
 * MIT License
 * http://github.com/cferdinandi/harbor-pet-rescue-wordpress-theme
 */

/**
 * Run code after document is ready
 * @param  {Function} fn The function to run
 */
var ready = function ( fn ) {

	// Sanity check
	if ( typeof (fn) !== 'function' ) return;

	// If document is already loaded, run method
	if ( document.readyState === 'interactive' ) {
		return fn();
	}

	// Otherwise, wait until document is loaded
	document.onreadystatechange = function () {
		if ( document.readyState === 'interactive' ) {
			fn();
		}
	};

};
/*!
loadCSS: load a CSS file asynchronously.
[c]2014 @scottjehl, Filament Group, Inc.
Licensed MIT
*/

/* exported loadCSS */
function loadCSS( href, before, media, callback ){
	"use strict";
	// Arguments explained:
	// `href` is the URL for your CSS file.
	// `before` optionally defines the element we'll use as a reference for injecting our <link>
	// By default, `before` uses the first <script> element in the page.
	// However, since the order in which stylesheets are referenced matters, you might need a more specific location in your document.
	// If so, pass a different reference element to the `before` argument and it'll insert before that instead
	// note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
	var ss = window.document.createElement( "link" );
	var ref = before || window.document.getElementsByTagName( "script" )[ 0 ];
	var sheets = window.document.styleSheets;
	ss.rel = "stylesheet";
	ss.href = href;
	// temporarily, set media to something non-matching to ensure it'll fetch without blocking render
	ss.media = "only x";
	// DEPRECATED
	if( callback ) {
		ss.onload = callback;
	}

	// inject link
	ref.parentNode.insertBefore( ss, ref );
	// This function sets the link's media back to `all` so that the stylesheet applies once it loads
	// It is designed to poll until document.styleSheets includes the new sheet.
	ss.onloadcssdefined = function( cb ){
		var defined;
		for( var i = 0; i < sheets.length; i++ ){
			if( sheets[ i ].href && sheets[ i ].href === ss.href ){
				defined = true;
			}
		}
		if( defined ){
			cb();
		} else {
			setTimeout(function() {
				ss.onloadcssdefined( cb );
			});
		}
	};
	ss.onloadcssdefined(function() {
		ss.media = media || "all";
	});
	return ss;
}
;(function (window, document, undefined) {

    'use strict';

    // SVG feature detection
    var supports = !!document.createElementNS && !!document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect;

    // Check against Opera Mini (throws a false positive)
    var whitelist = navigator.userAgent.indexOf('Opera Mini') === -1;

    // If SVG is supported, add `.svg` class to <html> element
    if ( supports && whitelist ) {
        document.documentElement.className += (document.documentElement.className ? ' ' : '') + 'svg';
    }

})(window, document);