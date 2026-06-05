/**
 * Booking page — calendar, dynamic slots via REST, booking submit.
 */
( function () {
	'use strict';

	var api = window.acTechBooking || {};
	var form = document.getElementById( 'ac-tech-booking-form' );
	var successEl = document.getElementById( 'ac-tech-booking-success' );
	var successMsg = document.getElementById( 'ac-tech-booking-success-message' );
	var i18nEl = document.getElementById( 'ac-tech-booking-i18n' );
	var calendarEl = document.getElementById( 'ac-tech-booking-calendar' );
	var daysEl = document.getElementById( 'ac-tech-booking-days' );
	var weekdaysEl = document.getElementById( 'ac-tech-booking-weekdays' );
	var monthLabel = document.getElementById( 'ac-tech-booking-month-label' );
	var dateInput = document.getElementById( 'ac-tech-booking-date' );
	var timeInput = document.getElementById( 'ac-tech-booking-time' );
	var urgencyInput = document.getElementById( 'ac-tech-booking-urgency' );
	var serviceSelect = document.getElementById( 'ac-tech-booking-service' );
	var slotsEl = document.getElementById( 'ac-tech-booking-slots' );
	var slotsHint = document.getElementById( 'ac-tech-booking-slots-hint' );
	var submitBtn = document.getElementById( 'ac-tech-booking-submit' );

	if ( ! form || ! calendarEl || ! daysEl ) {
		return;
	}

	var i18n = i18nEl ? JSON.parse( i18nEl.textContent ) : { months: [], successDetail: '%1$s %2$s' };
	var weekdays = JSON.parse( calendarEl.getAttribute( 'data-weekdays' ) || '[]' );
	var msgs = api.messages || {};

	var viewDate = new Date();
	viewDate.setDate( 1 );
	var selectedDate = null;
	var monthAvailability = {};
	var isSubmitting = false;

	function pad( n ) {
		return n < 10 ? '0' + n : String( n );
	}

	function formatDateKey( y, m, d ) {
		return y + '-' + pad( m + 1 ) + '-' + pad( d );
	}

	function formatMonthKey( y, m ) {
		return y + '-' + pad( m + 1 );
	}

	function isPast( y, m, d ) {
		var today = new Date();
		today.setHours( 0, 0, 0, 0 );
		var check = new Date( y, m, d );
		return check < today;
	}

	function getSelectedService() {
		return serviceSelect ? serviceSelect.value : '';
	}

	function apiUrl( path, params ) {
		var url = ( api.restUrl || '/wp-json/ac-tech/v1/' ) + path;
		if ( params ) {
			var qs = Object.keys( params ).map( function ( key ) {
				return encodeURIComponent( key ) + '=' + encodeURIComponent( params[ key ] );
			} ).join( '&' );
			url += ( url.indexOf( '?' ) >= 0 ? '&' : '?' ) + qs;
		}
		return url;
	}

	function fetchJson( url, options ) {
		var opts = options || {};
		opts.headers = opts.headers || {};
		opts.headers['Content-Type'] = 'application/json';
		if ( api.nonce ) {
			opts.headers['X-WP-Nonce'] = api.nonce;
		}
		return fetch( url, opts ).then( function ( res ) {
			return res.json().then( function ( data ) {
				if ( ! res.ok ) {
					var err = new Error( data && data.message ? data.message : 'Request failed' );
					err.code = data && data.code ? data.code : '';
					err.status = res.status;
					throw err;
				}
				return data;
			} );
		} );
	}

	function setSlotsHint( text ) {
		if ( slotsHint ) {
			slotsHint.textContent = text || '';
		}
	}

	function clearSlots() {
		if ( ! slotsEl ) {
			return;
		}
		slotsEl.innerHTML = '';
		if ( timeInput ) {
			timeInput.value = '';
		}
	}

	function renderSlots( slots ) {
		clearSlots();
		if ( ! slotsEl ) {
			return;
		}

		if ( ! slots || ! slots.length ) {
			setSlotsHint( msgs.noSlots || 'Nu există intervale disponibile.' );
			return;
		}

		setSlotsHint( '' );
		slots.forEach( function ( slot, index ) {
			var btn = document.createElement( 'button' );
			btn.type = 'button';
			btn.className = 'ac-tech-booking-slots__btn' + ( index === 0 ? ' is-active' : '' );
			btn.setAttribute( 'data-slot', slot.start );
			btn.textContent = slot.start + ' - ' + slot.end;
			btn.addEventListener( 'click', function () {
				slotsEl.querySelectorAll( '.ac-tech-booking-slots__btn.is-active' ).forEach( function ( el ) {
					el.classList.remove( 'is-active' );
				} );
				btn.classList.add( 'is-active' );
				if ( timeInput ) {
					timeInput.value = slot.start;
				}
			} );
			slotsEl.appendChild( btn );
		} );

		if ( timeInput && slots[ 0 ] ) {
			timeInput.value = slots[ 0 ].start;
		}
	}

	function loadDaySlots() {
		var service = getSelectedService();
		var date = selectedDate || ( dateInput ? dateInput.value : '' );

		if ( ! service ) {
			clearSlots();
			setSlotsHint( msgs.selectService || 'Selectează serviciul.' );
			return Promise.resolve();
		}

		if ( ! date ) {
			clearSlots();
			return Promise.resolve();
		}

		setSlotsHint( msgs.loadingSlots || 'Se încarcă...' );
		slotsEl && slotsEl.classList.add( 'is-loading' );

		return fetchJson( apiUrl( 'availability', { service: service, date: date } ) )
			.then( function ( data ) {
				renderSlots( data.slots || [] );
			} )
			.catch( function () {
				clearSlots();
				setSlotsHint( msgs.errorGeneric || 'Eroare la încărcare.' );
			} )
			.finally( function () {
				slotsEl && slotsEl.classList.remove( 'is-loading' );
			} );
	}

	function loadMonthAvailability() {
		var service = getSelectedService();
		if ( ! service ) {
			monthAvailability = {};
			return Promise.resolve();
		}

		var year = viewDate.getFullYear();
		var month = viewDate.getMonth();
		var monthKey = formatMonthKey( year, month );

		return fetchJson( apiUrl( 'availability', { service: service, month: monthKey } ) )
			.then( function ( data ) {
				monthAvailability = data.days || {};
			} )
			.catch( function () {
				monthAvailability = {};
			} );
	}

	function renderWeekdays() {
		if ( ! weekdaysEl ) {
			return;
		}
		weekdaysEl.innerHTML = '';
		weekdays.forEach( function ( label ) {
			var cell = document.createElement( 'div' );
			cell.className = 'ac-tech-booking-calendar__weekday';
			cell.textContent = label;
			weekdaysEl.appendChild( cell );
		} );
	}

	function createDayCell( year, month, day, muted ) {
		var btn = document.createElement( 'button' );
		btn.type = 'button';
		btn.className = 'ac-tech-booking-calendar__day';
		btn.textContent = String( day );

		if ( muted ) {
			btn.classList.add( 'is-muted' );
			btn.disabled = true;
			return btn;
		}

		var normalizedMonth = month;
		var normalizedYear = year;
		if ( month < 0 ) {
			normalizedMonth = 11;
			normalizedYear = year - 1;
		} else if ( month > 11 ) {
			normalizedMonth = 0;
			normalizedYear = year + 1;
		}

		if ( isPast( normalizedYear, normalizedMonth, day ) ) {
			btn.classList.add( 'is-muted' );
			btn.disabled = true;
			return btn;
		}

		var key = formatDateKey( normalizedYear, normalizedMonth, day );
		btn.setAttribute( 'data-date', key );

		var service = getSelectedService();
		if ( service && Object.prototype.hasOwnProperty.call( monthAvailability, key ) && ! monthAvailability[ key ] ) {
			btn.classList.add( 'is-muted' );
			btn.disabled = true;
			return btn;
		}

		if ( selectedDate === key ) {
			btn.classList.add( 'is-active' );
		}

		btn.addEventListener( 'click', function () {
			selectedDate = key;
			if ( dateInput ) {
				dateInput.value = key;
			}
			daysEl.querySelectorAll( '.ac-tech-booking-calendar__day.is-active' ).forEach( function ( el ) {
				el.classList.remove( 'is-active' );
			} );
			btn.classList.add( 'is-active' );
			loadDaySlots();
		} );

		return btn;
	}

	function selectFirstAvailable( year, month ) {
		var daysInMonth = new Date( year, month + 1, 0 ).getDate();
		var service = getSelectedService();

		for ( var d = 1; d <= daysInMonth; d++ ) {
			if ( isPast( year, month, d ) ) {
				continue;
			}
			var key = formatDateKey( year, month, d );
			if ( service && Object.prototype.hasOwnProperty.call( monthAvailability, key ) && ! monthAvailability[ key ] ) {
				continue;
			}
			selectedDate = key;
			if ( dateInput ) {
				dateInput.value = selectedDate;
			}
			return;
		}

		selectedDate = null;
		if ( dateInput ) {
			dateInput.value = '';
		}
	}

	function renderCalendar() {
		var year = viewDate.getFullYear();
		var month = viewDate.getMonth();
		var monthName = i18n.months && i18n.months[ month ] ? i18n.months[ month ] : '';

		if ( monthLabel ) {
			monthLabel.textContent = monthName + ' ' + year;
		}

		daysEl.innerHTML = '';

		var firstDay = new Date( year, month, 1 ).getDay();
		var daysInMonth = new Date( year, month + 1, 0 ).getDate();
		var prevMonthDays = new Date( year, month, 0 ).getDate();
		var startOffset = firstDay === 0 ? 6 : firstDay - 1;

		for ( var i = startOffset; i > 0; i-- ) {
			var prevDay = prevMonthDays - i + 1;
			daysEl.appendChild( createDayCell( year, month - 1, prevDay, true ) );
		}

		for ( var d = 1; d <= daysInMonth; d++ ) {
			daysEl.appendChild( createDayCell( year, month, d, false ) );
		}

		var totalCells = daysEl.children.length;
		var remainder = totalCells % 7;
		if ( remainder !== 0 ) {
			for ( var n = 1; n <= 7 - remainder; n++ ) {
				daysEl.appendChild( createDayCell( year, month + 1, n, true ) );
			}
		}

		if ( selectedDate ) {
			var active = daysEl.querySelector( '[data-date="' + selectedDate + '"]' );
			if ( active ) {
				active.classList.add( 'is-active' );
			} else {
				selectFirstAvailable( year, month );
			}
		} else {
			selectFirstAvailable( year, month );
		}

		var activeCell = selectedDate ? daysEl.querySelector( '[data-date="' + selectedDate + '"]' ) : null;
		if ( activeCell ) {
			activeCell.classList.add( 'is-active' );
		}

		loadDaySlots();
	}

	function refreshCalendar() {
		loadMonthAvailability().then( function () {
			renderCalendar();
		} );
	}

	var prevBtn = document.getElementById( 'ac-tech-booking-prev' );
	var nextBtn = document.getElementById( 'ac-tech-booking-next' );

	if ( prevBtn ) {
		prevBtn.addEventListener( 'click', function () {
			viewDate.setMonth( viewDate.getMonth() - 1 );
			selectedDate = null;
			refreshCalendar();
		} );
	}

	if ( nextBtn ) {
		nextBtn.addEventListener( 'click', function () {
			viewDate.setMonth( viewDate.getMonth() + 1 );
			selectedDate = null;
			refreshCalendar();
		} );
	}

	if ( serviceSelect ) {
		serviceSelect.addEventListener( 'change', function () {
			selectedDate = null;
			refreshCalendar();
		} );
	}

	document.querySelectorAll( '.ac-tech-booking-urgency__btn' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			document.querySelectorAll( '.ac-tech-booking-urgency__btn' ).forEach( function ( b ) {
				b.classList.remove( 'is-active' );
			} );
			btn.classList.add( 'is-active' );
			if ( urgencyInput ) {
				urgencyInput.value = btn.getAttribute( 'data-urgency' ) || 'standard';
			}
		} );
	} );

	function formatDisplayDate( key ) {
		if ( ! key ) {
			return '';
		}
		var parts = key.split( '-' );
		if ( parts.length !== 3 ) {
			return key;
		}
		var d = parseInt( parts[ 2 ], 10 );
		var m = parseInt( parts[ 1 ], 10 ) - 1;
		var monthName = i18n.months && i18n.months[ m ] ? i18n.months[ m ] : parts[ 1 ];
		return d + ' ' + monthName + ' ' + parts[ 0 ];
	}

	function showSuccess( slotLabel ) {
		if ( ! successEl ) {
			return;
		}
		var dateLabel = formatDisplayDate( selectedDate || ( dateInput ? dateInput.value : '' ) );

		if ( successMsg && i18n.successDetail ) {
			successMsg.textContent = i18n.successDetail.replace( '%1$s', dateLabel ).replace( '%2$s', slotLabel || '' );
		}

		successEl.hidden = false;
		document.body.classList.add( 'ac-tech-booking-modal-open' );
	}

	document.querySelectorAll( '[data-ac-tech-booking-close]' ).forEach( function ( el ) {
		el.addEventListener( 'click', function () {
			if ( successEl ) {
				successEl.hidden = true;
			}
			document.body.classList.remove( 'ac-tech-booking-modal-open' );
		} );
	} );

	var addCalBtn = document.getElementById( 'ac-tech-booking-add-calendar' );
	if ( addCalBtn ) {
		addCalBtn.addEventListener( 'click', function () {
			var title = 'Programare AC-Tech';
			var start = selectedDate || '';
			var slot = timeInput ? timeInput.value : '';
			var text = title + ' — ' + start + ' ' + slot;
			if ( navigator.clipboard && navigator.clipboard.writeText ) {
				navigator.clipboard.writeText( text );
			}
		} );
	}

	form.addEventListener( 'submit', function ( e ) {
		e.preventDefault();

		if ( isSubmitting ) {
			return;
		}

		if ( ! form.checkValidity() ) {
			form.reportValidity();
			return;
		}

		if ( ! dateInput || ! dateInput.value ) {
			dateInput && dateInput.setCustomValidity( 'Selectează o dată.' );
			form.reportValidity();
			return;
		}
		dateInput.setCustomValidity( '' );

		if ( ! timeInput || ! timeInput.value ) {
			alert( msgs.selectSlot || 'Selectează un interval.' );
			return;
		}

		var payload = {
			service_slug: getSelectedService(),
			date: dateInput.value,
			start_time: timeInput.value,
			name: ( document.getElementById( 'ac-tech-booking-name' ) || {} ).value || '',
			phone: ( document.getElementById( 'ac-tech-booking-phone' ) || {} ).value || '',
			email: ( document.getElementById( 'ac-tech-booking-email' ) || {} ).value || '',
			address: ( document.getElementById( 'ac-tech-booking-address' ) || {} ).value || '',
			urgency: urgencyInput ? urgencyInput.value : 'standard',
			notes: ( document.getElementById( 'ac-tech-booking-notes' ) || {} ).value || '',
		};

		isSubmitting = true;
		if ( submitBtn ) {
			submitBtn.disabled = true;
		}

		fetchJson( apiUrl( 'bookings' ), {
			method: 'POST',
			body: JSON.stringify( payload ),
		} )
			.then( function ( data ) {
				var slotLabel = data.start && data.end ? data.start + ' - ' + data.end : timeInput.value;
				showSuccess( slotLabel );
			} )
			.catch( function ( err ) {
				var message = msgs.errorGeneric || 'Eroare.';
				if ( err.status === 409 || err.code === 'slot_unavailable' || err.code === 'slot_conflict' ) {
					message = msgs.errorConflict || message;
					loadDaySlots();
				}
				alert( err.message || message );
			} )
			.finally( function () {
				isSubmitting = false;
				if ( submitBtn ) {
					submitBtn.disabled = false;
				}
			} );
	} );

	renderWeekdays();
	refreshCalendar();
} )();
