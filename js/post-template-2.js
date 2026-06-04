/**
 * Post template 2 — parallax hero + reveal cards.
 */
( function () {
	'use strict';

	var parallax = document.querySelector( '[data-ac-tech-parallax]' );
	if ( parallax ) {
		var ticking = false;

		function updateParallax() {
			var y = window.pageYOffset * 0.4;
			parallax.style.transform = 'translate3d(0, ' + y + 'px, 0)';
			ticking = false;
		}

		window.addEventListener(
			'scroll',
			function () {
				if ( ! ticking ) {
					window.requestAnimationFrame( updateParallax );
					ticking = true;
				}
			},
			{ passive: true }
		);
	}

	var cards = document.querySelectorAll( '[data-ac-tech-reveal]' );
	if ( cards.length && 'IntersectionObserver' in window ) {
		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-visible' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.12 }
		);

		cards.forEach( function ( card ) {
			observer.observe( card );
		} );
	}
} )();
