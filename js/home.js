/**
 * Homepage interactions — carousel, smooth anchors, header scroll.
 */
( function () {
	'use strict';

	document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( anchor ) {
		anchor.addEventListener( 'click', function ( event ) {
			const targetId = this.getAttribute( 'href' );

			if ( ! targetId || targetId === '#' ) {
				return;
			}

			const target = document.querySelector( targetId );

			if ( ! target ) {
				return;
			}

			event.preventDefault();
			target.scrollIntoView( { behavior: 'smooth' } );
		} );
	} );

	const header = document.querySelector( '.ac-tech-site-header' );

	if ( header ) {
		window.addEventListener( 'scroll', function () {
			if ( window.scrollY > 50 ) {
				header.classList.add( 'is-scrolled' );
			} else {
				header.classList.remove( 'is-scrolled' );
			}
		} );
	}

	const carousel = document.querySelector( '.ac-tech-home-carousel' );
	if ( ! carousel ) {
		return;
	}

	const slides = carousel.querySelectorAll( '.ac-tech-home-carousel__slide' );
	const mediaItems = carousel.querySelectorAll( '.ac-tech-home-carousel__media-item' );
	const dots = carousel.querySelectorAll( '.ac-tech-home-carousel__dot' );

	if ( slides.length <= 1 ) {
		return;
	}

	let current = 0;
	let timer = null;
	const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	const autoplayMs = parseInt( carousel.getAttribute( 'data-autoplay' ) || '6000', 10 );

	function goTo( index ) {
		current = index;

		slides.forEach( function ( slide, i ) {
			const active = i === index;
			slide.classList.toggle( 'is-active', active );
			slide.setAttribute( 'aria-hidden', active ? 'false' : 'true' );
		} );

		mediaItems.forEach( function ( item, i ) {
			item.classList.toggle( 'is-active', i === index );
		} );

		dots.forEach( function ( dot, i ) {
			const active = i === index;
			dot.classList.toggle( 'is-active', active );
			dot.setAttribute( 'aria-selected', active ? 'true' : 'false' );
		} );
	}

	function next() {
		goTo( ( current + 1 ) % slides.length );
	}

	function resetTimer() {
		if ( timer ) {
			clearInterval( timer );
			timer = null;
		}

		if ( ! reducedMotion && autoplayMs > 0 ) {
			timer = setInterval( next, autoplayMs );
		}
	}

	dots.forEach( function ( dot ) {
		dot.addEventListener( 'click', function () {
			const target = parseInt( dot.getAttribute( 'data-slide-to' ) || '0', 10 );
			if ( ! Number.isNaN( target ) ) {
				goTo( target );
				resetTimer();
			}
		} );
	} );

	carousel.addEventListener( 'mouseenter', function () {
		if ( timer ) {
			clearInterval( timer );
			timer = null;
		}
	} );

	carousel.addEventListener( 'mouseleave', resetTimer );

	goTo( 0 );
	resetTimer();
}() );
