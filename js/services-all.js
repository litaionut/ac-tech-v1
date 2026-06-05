/**
 * Services catalog page — scroll reveal.
 */
( function () {
	'use strict';

	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		document.querySelectorAll( '.ac-tech-services-all-reveal' ).forEach( function ( el ) {
			el.classList.add( 'is-visible' );
		} );
		return;
	}

	var blocks = document.querySelectorAll( '.ac-tech-services-all-reveal' );
	if ( ! blocks.length ) {
		return;
	}

	if ( ! ( 'IntersectionObserver' in window ) ) {
		blocks.forEach( function ( el ) {
			el.classList.add( 'is-visible' );
		} );
		return;
	}

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-visible' );
					observer.unobserve( entry.target );
				}
			} );
		},
		{ threshold: 0.12, rootMargin: '0px 0px -5% 0px' }
	);

	blocks.forEach( function ( el ) {
		observer.observe( el );
	} );
}() );
