/**
 * Contact page — form validation and success modal (front-end demo).
 */
( function () {
	'use strict';

	var form = document.getElementById( 'ac-tech-contact-form' );
	var successEl = document.getElementById( 'ac-tech-contact-success' );

	if ( ! form ) {
		return;
	}

	function showSuccess() {
		if ( ! successEl ) {
			return;
		}
		successEl.hidden = false;
		document.body.classList.add( 'ac-tech-booking-modal-open' );
	}

	document.querySelectorAll( '[data-ac-tech-contact-close]' ).forEach( function ( el ) {
		el.addEventListener( 'click', function () {
			if ( successEl ) {
				successEl.hidden = true;
			}
			document.body.classList.remove( 'ac-tech-booking-modal-open' );
		} );
	} );

	form.addEventListener( 'submit', function ( e ) {
		e.preventDefault();
		if ( ! form.checkValidity() ) {
			form.reportValidity();
			return;
		}
		showSuccess();
		form.reset();
	} );
} )();
