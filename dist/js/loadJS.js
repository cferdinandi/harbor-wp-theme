/*!
 * harbor v1.0.3: A free WordPress theme for animal and pet rescue organizations
 * (c) 2016 Chris Ferdinandi
 * MIT License
 * http://github.com/cferdinandi/harbor-pet-rescue-wordpress-theme
 */

/*! loadJS: load a JS file asynchronously. [c]2014 @scottjehl, Filament Group, Inc. (Based on http://goo.gl/REQGQ by Paul Irish). Licensed MIT */
function loadJS( src, cb ){
	'use strict';
	var ref = window.document.getElementsByTagName( 'script' )[ 0 ];
	var script = window.document.createElement( 'script' );
	script.src = src;
	script.async = true;
	ref.parentNode.insertBefore( script, ref );
	if ( cb && typeof(cb) === 'function' ) {
		script.onload = cb;
	}
	return script;
}