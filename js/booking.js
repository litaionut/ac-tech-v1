/**
 * Booking page — calendar, slots, urgency, success modal.
 */
( function () {
	'use strict';

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

	if ( ! form || ! calendarEl || ! daysEl ) {
		return;
	}

	var i18n = i18nEl ? JSON.parse( i18nEl.textContent ) : { months: [], successDetail: '%1$s %2$s' };
	var weekdays = JSON.parse( calendarEl.getAttribute( 'data-weekdays' ) || '[]' );

	var viewDate = new Date();
	viewDate.setDate( 1 );
	var selectedDate = null;

	function pad( n ) {
		return n < 10 ? '0' + n : String( n );
	}

	function formatDateKey( y, m, d ) {
		return y + '-' + pad( m + 1 ) + '-' + pad( d );
	}

	function isPast( y, m, d ) {
		var today = new Date();
		today.setHours( 0, 0, 0, 0 );
		var check = new Date( y, m, d );
		return check < today;
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

		if ( ! selectedDate ) {
			selectFirstAvailable( year, month );
		}
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
		} );

		return btn;
	}

	function selectFirstAvailable( year, month ) {
		var daysInMonth = new Date( year, month + 1, 0 ).getDate();
		for ( var d = 1; d <= daysInMonth; d++ ) {
			if ( ! isPast( year, month, d ) ) {
				selectedDate = formatDateKey( year, month, d );
				if ( dateInput ) {
					dateInput.value = selectedDate;
				}
				var active = daysEl.querySelector( '[data-date="' + selectedDate + '"]' );
				if ( active ) {
					active.classList.add( 'is-active' );
				}
				return;
			}
		}
	}

	var prevBtn = document.getElementById( 'ac-tech-booking-prev' );
	var nextBtn = document.getElementById( 'ac-tech-booking-next' );

	if ( prevBtn ) {
		prevBtn.addEventListener( 'click', function () {
			viewDate.setMonth( viewDate.getMonth() - 1 );
			renderCalendar();
		} );
	}

	if ( nextBtn ) {
		nextBtn.addEventListener( 'click', function () {
			viewDate.setMonth( viewDate.getMonth() + 1 );
			renderCalendar();
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

	var slotsEl = document.getElementById( 'ac-tech-booking-slots' );
	if ( slotsEl ) {
		slotsEl.querySelectorAll( '.ac-tech-booking-slots__btn' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				slotsEl.querySelectorAll( '.ac-tech-booking-slots__btn' ).forEach( function ( b ) {
					b.classList.remove( 'is-active' );
				} );
				btn.classList.add( 'is-active' );
				if ( timeInput ) {
					timeInput.value = btn.getAttribute( 'data-slot' ) || '';
				}
			} );
		} );
	}

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

	function showSuccess() {
		if ( ! successEl ) {
			return;
		}
		var slotBtn = slotsEl ? slotsEl.querySelector( '.ac-tech-booking-slots__btn.is-active' ) : null;
		var slotLabel = slotBtn ? slotBtn.textContent.trim() : ( timeInput ? timeInput.value : '' );
		var dateLabel = formatDisplayDate( selectedDate || ( dateInput ? dateInput.value : '' ) );

		if ( successMsg && i18n.successDetail ) {
			successMsg.textContent = i18n.successDetail.replace( '%1$s', dateLabel ).replace( '%2$s', slotLabel );
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
			var slot = timeInput ? timeInput.value.replace( '-', ' to ' ) : '';
			var text = title + ' — ' + start + ' ' + slot;
			if ( navigator.clipboard && navigator.clipboard.writeText ) {
				navigator.clipboard.writeText( text );
			}
		} );
	}

	form.addEventListener( 'submit', function ( e ) {
		e.preventDefault();
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
		showSuccess();
	} );

	renderWeekdays();
	renderCalendar();
} )();
