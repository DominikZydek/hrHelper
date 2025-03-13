<script>
	import Calendar from '@event-calendar/core';
	import Dropdown from '../../../../components/Dropdown.svelte';
	import { getStatusInfo } from '../../../../utils/getStatusInfo.js';
	import DayGrid from '@event-calendar/day-grid';
	import { getContext, onMount } from 'svelte';
	import { MeterChart } from '@carbon/charts-svelte';
	import { getUserPTOInfo } from '../../../../utils/getUserPTOInfo.js';

	export let data;

	let { usedPtoDays, pendingPtoDays, availablePtoDays, ptoDays } = getUserPTOInfo(data.user);

	let chartData = [
		{
			group: 'Wykorzystane',
			value: usedPtoDays
		},
		{
			group: 'W trakcie rozpatrywania',
			value: pendingPtoDays
		},
		{
			group: 'Dostępne',
			value: availablePtoDays
		}
	];

	let chartOptions = {
		height: '150px',
		meter: {
			proportional: {
				total: ptoDays,
				unit: 'dni'
			}
		},
		color: {
			pairing: {
				option: 2
			}
		},
		toolbar: false,
		getFillColor: (group) => {
			if (group === 'Wykorzystane') return '#DC2626';
			if (group === 'W trakcie rozpatrywania') return '#EAB308';
			if (group === 'Dostępne') return '#059669';
		}
	};

	let { handleEventClick } = getContext('leave-management');

	let allRequests = [...data.me.leave_requests];
	data.me.groups.forEach((group) => {
		group.users.forEach((user) => {
			if (user.id !== data.me.id && user.leave_requests) {
				allRequests = [...allRequests, ...user.leave_requests];
			}
		});
	});
	// remove duplicates
	let calendarDisplayedRequests = [
		...new Map(allRequests.map((request) => [request.id, request])).values()
	];

	let companyHolidays = data.me.organization.holidays;

	const mapLeaveRequestsToCalendarEvents = (requests) => {
		return requests.map((request) => ({
			id: request.id,
			allDay: true,
			start: request.date_from,
			end: request.date_to,
			title: `${
				request.user // if user is defined, it's not my request
					? `${request.user.first_name} ${request.user.last_name} - ${request.leave_type.name}`
					: `${request.leave_type.name} - ${request.reason}`
			}`,
			backgroundColor: getStatusInfo(request.status).color,
			editable: false
		}));
	};

	const mapCompanyHolidaysToCalendarEvents = (holidays) => {
		return holidays.map((holiday) => ({
			id: holiday.id,
			allDay: true,
			start: holiday.date,
			end: holiday.date,
			title: holiday.name,
			backgroundColor: '#2563EB',
			editable: false
		}));
	};

	let showOnlyMyRequestsButtonActive = false;
	let showOnlyApprovedRequestsButtonActive = false;

	let plugins = [DayGrid];
	let options = {
		view: 'dayGridMonth',
		events: [
			...mapLeaveRequestsToCalendarEvents(calendarDisplayedRequests),
			...mapCompanyHolidaysToCalendarEvents(companyHolidays)
		],
		eventClick: (info) => handleEventClick(info),
		locale: 'pl-PL',
		headerToolbar: {
			start: 'prev today next',
			center: 'showOnlyMyRequests showOnlyApprovedRequests',
			end: 'title'
		},
		customButtons: {
			showOnlyMyRequests: {
				text: {
					html: `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem; vertical-align: middle; margin-right: 5px; display: inline;"><title>eye-outline</title><path d="M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M12,4.5C17,4.5 21.27,7.61 23,12C21.27,16.39 17,19.5 12,19.5C7,19.5 2.73,16.39 1,12C2.73,7.61 7,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C15.76,17.5 19.17,15.36 20.82,12C19.17,8.64 15.76,6.5 12,6.5C8.24,6.5 4.83,8.64 3.18,12Z" /></svg>
                    <span style="vertical-align: middle">Pokaż tylko moje</span>
                `
				},
				click: () => {
					if (!showOnlyMyRequestsButtonActive) {
						calendarDisplayedRequests = calendarDisplayedRequests.filter(
							(request) => !request.user
						);
					} else {
						calendarDisplayedRequests = [
							...new Map(allRequests.map((request) => [request.id, request])).values()
						];
					}

					showOnlyMyRequestsButtonActive = !showOnlyMyRequestsButtonActive;

					options = {
						...options,
						events: mapLeaveRequestsToCalendarEvents(calendarDisplayedRequests),
						customButtons: {
							...options.customButtons,
							showOnlyMyRequests: {
								...options.customButtons.showOnlyMyRequests,
								active: showOnlyMyRequestsButtonActive
							}
						}
					};
				}
			},
			showOnlyApprovedRequests: {
				text: {
					html: `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem; vertical-align: middle; margin-right: 5px; display: inline;"><title>eye-outline</title><path d="M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M12,4.5C17,4.5 21.27,7.61 23,12C21.27,16.39 17,19.5 12,19.5C7,19.5 2.73,16.39 1,12C2.73,7.61 7,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C15.76,17.5 19.17,15.36 20.82,12C19.17,8.64 15.76,6.5 12,6.5C8.24,6.5 4.83,8.64 3.18,12Z" /></svg>
                    <span style="vertical-align: middle">Pokaż tylko zatwierdzone</span>
                `
				},
				click: () => {
					if (!showOnlyApprovedRequestsButtonActive) {
						calendarDisplayedRequests = calendarDisplayedRequests.filter(
							(request) => !request.user && request.status === 'APPROVED'
						);
					} else {
						calendarDisplayedRequests = [
							...new Map(allRequests.map((request) => [request.id, request])).values()
						];
					}

					showOnlyApprovedRequestsButtonActive = !showOnlyApprovedRequestsButtonActive;

					options = {
						...options,
						events: mapLeaveRequestsToCalendarEvents(calendarDisplayedRequests),
						customButtons: {
							...options.customButtons,
							showOnlyApprovedRequests: {
								...options.customButtons.showOnlyApprovedRequests,
								active: showOnlyApprovedRequestsButtonActive
							}
						}
					};
				}
			}
		},
		buttonText: (text) => ({ ...text, today: 'Dziś' }),
		dayHeaderFormat: { weekday: 'long' },
		firstDay: 1
	};
</script>

<div class="flex-1 p-4">
	<div class="flex items-center gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Kalendarz</p>
	</div>
	<div class="w-3/4 max-w-5xl m-auto flex flex-col gap-5">
		<Calendar {plugins} {options} />
		<MeterChart data={chartData} options={chartOptions} />
	</div>
</div>
