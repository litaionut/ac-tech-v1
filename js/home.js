/**
 * Homepage interactions from home.html.
 */
( function() {
	document.querySelectorAll( 'a[href^="#"]' ).forEach( function( anchor ) {
		anchor.addEventListener( 'click', function( event ) {
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

	if ( ! header ) {
		return;
	}

	window.addEventListener( 'scroll', function() {
		if ( window.scrollY > 50 ) {
			header.classList.add( 'is-scrolled' );
		} else {
			header.classList.remove( 'is-scrolled' );
		}
	} );
}() );
