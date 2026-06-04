/**
 * Igienizare AC page — FAQ accordion (single open item).
 */
( function () {
	const items = document.querySelectorAll( '.ac-tech-svc-ig-faq__item' );
	if ( ! items.length ) {
		return;
	}

	items.forEach( ( item ) => {
		item.addEventListener( 'toggle', () => {
			if ( ! item.open ) {
				return;
			}
			items.forEach( ( other ) => {
				if ( other !== item ) {
					other.removeAttribute( 'open' );
				}
			} );
		} );
	} );
}() );
