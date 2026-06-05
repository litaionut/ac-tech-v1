/**
 * Admin booking calendar — block days / day ranges / time intervals per service.
 */
( function () {
	'use strict';

	var api = window.acTechBookingAdmin || {};
	var calendarEl = document.getElementById( 'ac-tech-admin-calendar' );
	var daysEl = document.getElementById( 'ac-tech-admin-cal-days' );
	var weekdaysEl = document.getElementById( 'ac-tech-admin-cal-weekdays' );
	var monthLabel = document.getElementById( 'ac-tech-admin-cal-month-label' );
	var servicesWrap = document.getElementById( 'ac-tech-admin-cal-services' );
	var selectAllBtn = document.getElementById( 'ac-tech-admin-cal-select-all' );
	var clearAllBtn = document.getElementById( 'ac-tech-admin-cal-clear-all' );
	var modeSelect = document.getElementById( 'ac-tech-admin-cal-mode' );
	var intervalFields = document.getElementById( 'ac-tech-admin-cal-interval-fields' );
	var rangeFields = document.getElementById( 'ac-tech-admin-cal-range-fields' );
	var rangeHint = document.getElementById( 'ac-tech-admin-cal-range-hint' );
	var selectedDateEl = document.getElementById( 'ac-tech-admin-cal-selected-date' );
	var dateFromInput = document.getElementById( 'ac-tech-admin-cal-date-from' );
	var dateToInput = document.getElementById( 'ac-tech-admin-cal-date-to' );
	var startInput = document.getElementById( 'ac-tech-admin-cal-start' );
	var endInput = document.getElementById( 'ac-tech-admin-cal-end' );
	var reasonInput = document.getElementById( 'ac-tech-admin-cal-reason' );
	var confirmBtn = document.getElementById( 'ac-tech-admin-cal-confirm' );
	var blocksList = document.getElementById( 'ac-tech-admin-cal-blocks-list' );
	var statusEl = document.getElementById( 'ac-tech-admin-cal-status' );
	var prevBtn = document.getElementById( 'ac-tech-admin-cal-prev' );
	var nextBtn = document.getElementById( 'ac-tech-admin-cal-next' );

	if ( ! calendarEl || ! daysEl ) {
		return;
	}

	var msgs = api.messages || {};
	var serviceLabels = api.serviceLabels || {};
	var weekdays = JSON.parse( calendarEl.getAttribute( 'data-weekdays' ) || '[]' );
	var months = api.months || [];

	var viewDate = new Date();
	viewDate.setDate( 1 );
	var selectedDate = null;
	var selectedDateEnd = null;
	var monthData = { days: {}, blocks: [] };
	var isBusy = false;

	function pad( n ) {
		return n < 10 ? '0' + n : String( n );
	}

	function formatDateKey( y, m, d ) {
		return y + '-' + pad( m + 1 ) + '-' + pad( d );
	}

	function formatMonthKey( y, m ) {
		return y + '-' + pad( m + 1 );
	}

	function countDaysInRange( from, to ) {
		if ( ! from || ! to ) {
			return 0;
		}
		var startParts = from.split( '-' );
		var endParts = to.split( '-' );
		var start = new Date( parseInt( startParts[ 0 ], 10 ), parseInt( startParts[ 1 ], 10 ) - 1, parseInt( startParts[ 2 ], 10 ) );
		var end = new Date( parseInt( endParts[ 0 ], 10 ), parseInt( endParts[ 1 ], 10 ) - 1, parseInt( endParts[ 2 ], 10 ) );
		return Math.round( ( end - start ) / 86400000 ) + 1;
	}

	function getServiceCheckboxes() {
		if ( ! servicesWrap ) {
			return [];
		}
		return Array.prototype.slice.call(
			servicesWrap.querySelectorAll( 'input[type="checkbox"][name="ac-tech-admin-cal-service[]"]' )
		);
	}

	function getCheckedServices() {
		return getServiceCheckboxes()
			.filter( function ( input ) {
				return input.checked;
			} )
			.map( function ( input ) {
				return input.value;
			} );
	}

	function setAllServicesChecked( checked ) {
		getServiceCheckboxes().forEach( function ( input ) {
			input.checked = checked;
		} );
		updateActionPanel();
		loadMonth();
	}

	function getMode() {
		return modeSelect ? modeSelect.value : 'day';
	}

	function requireCheckedServices() {
		var services = getCheckedServices();
		if ( ! services.length ) {
			setStatus( msgs.selectServices || 'Selectează cel puțin un serviciu.' );
			return null;
		}
		return services;
	}

	function setStatus( text ) {
		if ( statusEl ) {
			statusEl.textContent = text || '';
		}
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
					throw err;
				}
				return data;
			} );
		} );
	}

	function formatServicesLabel( services ) {
		if ( ! services || ! services.length ) {
			return msgs.allServices || 'Toate serviciile';
		}
		return services.map( function ( slug ) {
			return serviceLabels[ slug ] || slug;
		} ).join( ', ' );
	}

	function dayMeta( key ) {
		return monthData.days && monthData.days[ key ] ? monthData.days[ key ] : null;
	}

	function normalizeRangeDates() {
		if ( selectedDate && selectedDateEnd && selectedDateEnd < selectedDate ) {
			var tmp = selectedDate;
			selectedDate = selectedDateEnd;
			selectedDateEnd = tmp;
		}
	}

	function syncRangeInputs() {
		normalizeRangeDates();
		if ( dateFromInput ) {
			dateFromInput.value = selectedDate || '';
		}
		if ( dateToInput ) {
			dateToInput.value = selectedDateEnd || '';
		}
	}

	function isDateInSelectedRange( key ) {
		if ( ! selectedDate ) {
			return false;
		}
		if ( ! selectedDateEnd ) {
			return key === selectedDate;
		}
		normalizeRangeDates();
		return key >= selectedDate && key <= selectedDateEnd;
	}

	function isSelectedDayFullyBlocked() {
		if ( ! selectedDate ) {
			return false;
		}
		var meta = dayMeta( selectedDate );
		return !!( meta && meta.blocked_full );
	}

	function isSelectedRangeFullyBlocked() {
		if ( ! selectedDate || ! selectedDateEnd ) {
			return false;
		}
		normalizeRangeDates();

		var startParts = selectedDate.split( '-' );
		var endParts = selectedDateEnd.split( '-' );
		var current = new Date( parseInt( startParts[ 0 ], 10 ), parseInt( startParts[ 1 ], 10 ) - 1, parseInt( startParts[ 2 ], 10 ) );
		var end = new Date( parseInt( endParts[ 0 ], 10 ), parseInt( endParts[ 1 ], 10 ) - 1, parseInt( endParts[ 2 ], 10 ) );

		while ( current <= end ) {
			var key = formatDateKey( current.getFullYear(), current.getMonth(), current.getDate() );
			var meta = dayMeta( key );
			if ( ! meta || ! meta.blocked_full ) {
				return false;
			}
			current.setDate( current.getDate() + 1 );
		}

		return true;
	}

	function updateSelectedDateLabel() {
		if ( ! selectedDateEl ) {
			return;
		}

		if ( getMode() === 'day_range' ) {
			if ( selectedDate && selectedDateEnd ) {
				selectedDateEl.textContent = selectedDate + ' → ' + selectedDateEnd;
			} else if ( selectedDate ) {
				selectedDateEl.textContent = selectedDate + ' → …';
			} else {
				selectedDateEl.textContent = msgs.noDateSelected || '—';
			}
			return;
		}

		selectedDateEl.textContent = selectedDate || ( msgs.noDateSelected || '—' );
	}

	function updateActionPanel() {
		var services = getCheckedServices();
		var hasServices = services.length > 0;
		var mode = getMode();
		var isInterval = mode === 'interval';
		var isDayRange = mode === 'day_range';
		var hasDate = !!selectedDate;
		var hasRange = !!( selectedDate && selectedDateEnd );

		if ( intervalFields ) {
			intervalFields.hidden = ! isInterval;
		}
		if ( rangeFields ) {
			rangeFields.hidden = ! isDayRange;
		}
		if ( rangeHint ) {
			rangeHint.hidden = ! isDayRange;
			rangeHint.textContent = isDayRange ? ( msgs.rangeHint || '' ) : '';
		}

		updateSelectedDateLabel();

		if ( confirmBtn ) {
			var canConfirm = hasServices && hasDate;
			if ( isDayRange ) {
				canConfirm = hasServices && hasRange;
			}

			confirmBtn.disabled = ! canConfirm;

			if ( ! canConfirm ) {
				confirmBtn.textContent = isDayRange
					? ( msgs.confirmDisabledRange || 'Selectează ambele date.' )
					: ( msgs.confirmDisabled || 'Selectează o dată.' );
			} else if ( isInterval ) {
				confirmBtn.textContent = msgs.confirmBlockInterval || 'Blochează intervalul orar';
			} else if ( isDayRange ) {
				var days = countDaysInRange( selectedDate, selectedDateEnd );
				if ( isSelectedRangeFullyBlocked() ) {
					confirmBtn.textContent = ( msgs.confirmUnblockDayRange || 'Deblochează intervalul de zile' ) + ' (' + days + ')';
				} else {
					confirmBtn.textContent = ( msgs.confirmBlockDayRange || 'Blochează intervalul de zile' ) + ' (' + days + ')';
				}
			} else if ( isSelectedDayFullyBlocked() ) {
				confirmBtn.textContent = msgs.confirmUnblockDay || 'Deblochează ziua';
			} else {
				confirmBtn.textContent = msgs.confirmBlockDay || 'Blochează ziua';
			}
		}
	}

	function clearRangeSelection() {
		selectedDate = null;
		selectedDateEnd = null;
		syncRangeInputs();
	}

	function selectSingleDate( key ) {
		selectedDate = key;
		selectedDateEnd = null;
		syncRangeInputs();
		updateActionPanel();
	}

	function selectRangeDate( key ) {
		if ( ! selectedDate || ( selectedDate && selectedDateEnd ) ) {
			selectedDate = key;
			selectedDateEnd = null;
		} else {
			selectedDateEnd = key;
			normalizeRangeDates();
		}
		syncRangeInputs();
		renderCalendar();
		updateActionPanel();
	}

	function handleDayClick( key ) {
		if ( getMode() === 'day_range' ) {
			selectRangeDate( key );
		} else {
			selectSingleDate( key );
			renderCalendar();
		}
		setStatus( '' );
	}

	function onRangeInputChange() {
		selectedDate = dateFromInput && dateFromInput.value ? dateFromInput.value : null;
		selectedDateEnd = dateToInput && dateToInput.value ? dateToInput.value : null;
		normalizeRangeDates();
		syncRangeInputs();
		renderCalendar();
		updateActionPanel();
	}

	function renderBlocksList() {
		if ( ! blocksList ) {
			return;
		}

		blocksList.innerHTML = '';
		var blocks = monthData.blocks || [];

		if ( ! blocks.length ) {
			var empty = document.createElement( 'li' );
			empty.className = 'ac-tech-admin-calendar-blocks__empty';
			empty.textContent = msgs.noBlocks || 'Nicio blocare.';
			blocksList.appendChild( empty );
			return;
		}

		blocks.sort( function ( a, b ) {
			if ( a.date === b.date ) {
				return ( a.start || '' ).localeCompare( b.start || '' );
			}
			return a.date.localeCompare( b.date );
		} );

		blocks.forEach( function ( block ) {
			var li = document.createElement( 'li' );
			li.className = 'ac-tech-admin-calendar-blocks__item';

			var title = document.createElement( 'strong' );
			var typeLabel = block.type === 'day' ? ( msgs.dayType || 'Zi întreagă' ) : ( msgs.intervalType || 'Interval' );
			var timePart = block.type === 'interval' ? ' ' + block.start + '–' + block.end : '';
			title.textContent = block.date + ' — ' + typeLabel + timePart;
			li.appendChild( title );

			var meta = document.createElement( 'span' );
			meta.className = 'ac-tech-admin-calendar-blocks__meta';
			meta.textContent = formatServicesLabel( block.services );
			if ( block.reason ) {
				meta.textContent += ' · ' + block.reason;
			}
			li.appendChild( meta );

			var removeBtn = document.createElement( 'button' );
			removeBtn.type = 'button';
			removeBtn.className = 'button-link-delete';
			removeBtn.textContent = msgs.remove || 'Elimină';
			removeBtn.addEventListener( 'click', function () {
				removeBlock( block.key );
			} );
			li.appendChild( removeBtn );

			blocksList.appendChild( li );
		} );
	}

	function loadMonth() {
		var services = requireCheckedServices();
		if ( ! services ) {
			daysEl.innerHTML = '';
			if ( blocksList ) {
				blocksList.innerHTML = '';
			}
			updateActionPanel();
			return Promise.resolve();
		}

		var year = viewDate.getFullYear();
		var month = viewDate.getMonth();
		var monthKey = formatMonthKey( year, month );

		setStatus( msgs.loading || 'Se încarcă...' );
		daysEl.classList.add( 'is-loading' );

		return fetchJson( apiUrl( 'admin/calendar', { month: monthKey, services: services.join( ',' ) } ) )
			.then( function ( data ) {
				monthData = data || { days: {}, blocks: [] };
				renderCalendar();
				renderBlocksList();
				updateActionPanel();
				setStatus( '' );
			} )
			.catch( function ( err ) {
				setStatus( err && err.message ? err.message : ( msgs.error || 'Eroare.' ) );
			} )
			.finally( function () {
				daysEl.classList.remove( 'is-loading' );
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

	function applyDayClasses( btn, key ) {
		var meta = dayMeta( key );
		var checked = getCheckedServices();
		var mode = getMode();

		if ( meta ) {
			if ( meta.blocked_full ) {
				btn.classList.add( 'is-blocked-full' );
			}
			if ( meta.has_interval && ! meta.blocked_full ) {
				btn.classList.add( 'is-blocked-partial' );
			}
			if ( checked.length === 1 && mode !== 'day_range' ) {
				if ( meta.visitor_available ) {
					btn.classList.add( 'is-visitor-open' );
				} else {
					btn.classList.add( 'is-visitor-closed' );
				}
			}
		}

		if ( mode === 'day_range' && isDateInSelectedRange( key ) ) {
			btn.classList.add( 'is-in-range' );
			if ( key === selectedDate ) {
				btn.classList.add( 'is-range-start' );
			}
			if ( selectedDateEnd && key === selectedDateEnd ) {
				btn.classList.add( 'is-range-end' );
			}
		} else if ( selectedDate === key ) {
			btn.classList.add( 'is-active' );
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

		var key = formatDateKey( year, month, day );
		btn.setAttribute( 'data-date', key );
		applyDayClasses( btn, key );

		btn.addEventListener( 'click', function () {
			if ( ! requireCheckedServices() ) {
				return;
			}
			handleDayClick( key );
		} );

		return btn;
	}

	function renderCalendar() {
		var year = viewDate.getFullYear();
		var month = viewDate.getMonth();
		var monthName = months[ month ] || '';

		if ( monthLabel ) {
			monthLabel.textContent = monthName + ' ' + year;
		}

		daysEl.innerHTML = '';

		var firstDay = new Date( year, month, 1 ).getDay();
		var daysInMonth = new Date( year, month + 1, 0 ).getDate();
		var prevMonthDays = new Date( year, month, 0 ).getDate();
		var startOffset = firstDay === 0 ? 6 : firstDay - 1;

		for ( var i = startOffset; i > 0; i-- ) {
			daysEl.appendChild( createDayCell( year, month - 1, prevMonthDays - i + 1, true ) );
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
	}

	function withBusy( promise, savingMsg ) {
		if ( isBusy ) {
			return Promise.resolve();
		}
		isBusy = true;
		if ( confirmBtn ) {
			confirmBtn.disabled = true;
		}
		setStatus( savingMsg || msgs.saving || 'Se salvează...' );
		return promise.finally( function () {
			isBusy = false;
			updateActionPanel();
		} );
	}

	function toggleDayBlock( date, services ) {
		return fetchJson( apiUrl( 'admin/blocks' ), {
			method: 'POST',
			body: JSON.stringify( {
				action: 'toggle_day',
				date: date,
				services: services,
				reason: reasonInput ? reasonInput.value : '',
			} ),
		} );
	}

	function addIntervalBlock( date, services ) {
		return fetchJson( apiUrl( 'admin/blocks' ), {
			method: 'POST',
			body: JSON.stringify( {
				action: 'add',
				type: 'interval',
				date: date,
				start: startInput ? startInput.value : '',
				end: endInput ? endInput.value : '',
				services: services,
				reason: reasonInput ? reasonInput.value : '',
			} ),
		} );
	}

	function addDayRangeBlock( dateFrom, dateTo, services ) {
		return fetchJson( apiUrl( 'admin/blocks' ), {
			method: 'POST',
			body: JSON.stringify( {
				action: 'add_day_range',
				date_from: dateFrom,
				date_to: dateTo,
				services: services,
				reason: reasonInput ? reasonInput.value : '',
			} ),
		} );
	}

	function removeDayRangeBlock( dateFrom, dateTo, services ) {
		return fetchJson( apiUrl( 'admin/blocks' ), {
			method: 'POST',
			body: JSON.stringify( {
				action: 'remove_day_range',
				date_from: dateFrom,
				date_to: dateTo,
				services: services,
			} ),
		} );
	}

	function formatDayRangeMessage( data ) {
		var tpl = msgs.dayRangeAdded || '%1$d zile blocate (%2$d existente deja).';
		return tpl
			.replace( '%1$d', String( data.added || 0 ) )
			.replace( '%2$d', String( data.skipped || 0 ) );
	}

	function confirmBlock() {
		var services = requireCheckedServices();
		if ( ! services ) {
			return;
		}

		var mode = getMode();
		var request;

		if ( mode === 'day_range' ) {
			if ( ! selectedDate || ! selectedDateEnd ) {
				setStatus( msgs.confirmDisabledRange || 'Selectează ambele date.' );
				return;
			}
			normalizeRangeDates();
			if ( isSelectedRangeFullyBlocked() ) {
				request = removeDayRangeBlock( selectedDate, selectedDateEnd, services );
			} else {
				request = addDayRangeBlock( selectedDate, selectedDateEnd, services );
			}
		} else if ( mode === 'interval' ) {
			if ( ! selectedDate ) {
				setStatus( msgs.selectDay || 'Selectează o zi.' );
				return;
			}
			request = addIntervalBlock( selectedDate, services );
		} else {
			if ( ! selectedDate ) {
				setStatus( msgs.selectDay || 'Selectează o zi.' );
				return;
			}
			request = toggleDayBlock( selectedDate, services );
		}

		withBusy(
			request
				.then( function ( data ) {
					if ( mode === 'interval' ) {
						setStatus( msgs.intervalAdded || 'Interval blocat.' );
					} else if ( mode === 'day_range' ) {
						if ( data && data.action === 'remove_day_range' ) {
							var removedTpl = msgs.dayRangeRemoved || '%d zile deblocate.';
							setStatus( removedTpl.replace( '%d', String( data.removed || 0 ) ) );
						} else {
							setStatus( formatDayRangeMessage( data || {} ) );
						}
					} else {
						setStatus(
							data && data.state === 'removed'
								? ( msgs.dayUnblocked || 'Deblocat.' )
								: ( msgs.dayBlocked || 'Blocat.' )
						);
					}
					if ( reasonInput ) {
						reasonInput.value = '';
					}
					return loadMonth();
				} )
				.catch( function ( err ) {
					setStatus( err && err.message ? err.message : ( msgs.error || 'Eroare.' ) );
				} ),
			msgs.saving
		);
	}

	function removeBlock( blockKey ) {
		withBusy(
			fetchJson( apiUrl( 'admin/blocks' ), {
				method: 'DELETE',
				body: JSON.stringify( { block_key: blockKey } ),
			} )
				.then( function () {
					setStatus( msgs.blockRemoved || 'Eliminat.' );
					return loadMonth();
				} )
				.catch( function ( err ) {
					setStatus( err && err.message ? err.message : ( msgs.error || 'Eroare.' ) );
				} ),
			msgs.saving
		);
	}

	if ( prevBtn ) {
		prevBtn.addEventListener( 'click', function () {
			viewDate.setMonth( viewDate.getMonth() - 1 );
			loadMonth();
		} );
	}

	if ( nextBtn ) {
		nextBtn.addEventListener( 'click', function () {
			viewDate.setMonth( viewDate.getMonth() + 1 );
			loadMonth();
		} );
	}

	if ( servicesWrap ) {
		servicesWrap.addEventListener( 'change', function () {
			updateActionPanel();
			loadMonth();
		} );
	}

	if ( selectAllBtn ) {
		selectAllBtn.addEventListener( 'click', function () {
			setAllServicesChecked( true );
		} );
	}

	if ( clearAllBtn ) {
		clearAllBtn.addEventListener( 'click', function () {
			setAllServicesChecked( false );
		} );
	}

	if ( modeSelect ) {
		modeSelect.addEventListener( 'change', function () {
			if ( getMode() === 'day_range' ) {
				selectedDateEnd = null;
			} else {
				selectedDateEnd = null;
			}
			syncRangeInputs();
			renderCalendar();
			updateActionPanel();
		} );
	}

	if ( dateFromInput ) {
		dateFromInput.addEventListener( 'change', onRangeInputChange );
	}

	if ( dateToInput ) {
		dateToInput.addEventListener( 'change', onRangeInputChange );
	}

	if ( confirmBtn ) {
		confirmBtn.addEventListener( 'click', confirmBlock );
	}

	renderWeekdays();
	updateActionPanel();
	loadMonth();
} )();
