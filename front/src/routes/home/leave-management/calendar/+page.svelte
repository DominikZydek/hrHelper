<script>
	import Calendar from '@event-calendar/core';
	import { getStatusInfo } from '../../../../utils/getStatusInfo.js';
	import DayGrid from '@event-calendar/day-grid';
	import { MeterChart } from '@carbon/charts-svelte';
	import { getUserPTOInfo } from '../../../../utils/getUserPTOInfo.js';
	import Popup from '../../../../components/Popup.svelte';
	import LeaveRequestDetails from '../../../../components/LeaveRequestDetails.svelte';
	import Dropdown from '../../../../components/Dropdown.svelte';
	import { icons } from '../../../../stores/icons.js';
	import GroupBadge from '../../../../components/GroupBadge.svelte';
	import ArrowULeftTop from 'svelte-material-icons/ArrowULeftTop.svelte';
	import History from 'svelte-material-icons/History.svelte';
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte';

	let { data } = $props();
	let showPopup = $state(false);
	const togglePopup = () => {
		showPopup = !showPopup;
	};

	let showOptions = $state(false);
	const toggleOptions = () => {
		showOptions = !showOptions;
	};

	let optionButton = $state(null);

	let selectedLeaveRequest = $state(null);

	const onClick = (leaveRequest) => {
		selectedLeaveRequest = leaveRequest;
		console.log(leaveRequest);
		togglePopup();
	};

	const handleEventClick = (info) => {
		selectedLeaveRequest = data.me.leave_requests.filter(
			(request) => info.event.id === request.id
		)[0];
		if (selectedLeaveRequest) {
			togglePopup();
		}
	};

	let showLeaveRequestHistory = $state(false);
	const toggleLeaveRequestHistory = () => {
		showLeaveRequestHistory = !showLeaveRequestHistory;
	};

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
		height: '100px',
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
	<div class="flex items-start gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Kalendarz</p>
	</div>
	<div class="w-3/4 max-w-5xl m-auto flex flex-col gap-5">
		<Calendar {plugins} {options} />
		<MeterChart data={chartData} options={chartOptions} />
	</div>
</div>

{#if showPopup}
	<Popup {togglePopup} title="Szczegóły wniosku">
		<svelte:fragment slot="header-right">
			<button type="button" bind:this={optionButton} onclick={() => toggleOptions()}>
				<DotsHorizontal class="text-main-gray" size="2rem" />
			</button>
		</svelte:fragment>
		{#if showOptions}
			<Dropdown triggerElement={optionButton} toggleDropdown={toggleOptions}>
				<div class="flex flex-col py-2">
					<button
						onclick={() => toggleLeaveRequestHistory()}
						type="button"
						class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-app"
					>
						<History size="1.25rem" />
						<span>Pokaż historię wniosku</span>
					</button>

					{#if showLeaveRequestHistory}
						<Popup togglePopup={toggleLeaveRequestHistory} title="Historia wniosku">
							<ul>
								{#each selectedLeaveRequest.approval_steps_history as step_history}
									{@const stepHistoryStatus = getStatusInfo(step_history.status)}
									{@const approver = step_history.approver || data.user}

									<li class="flex items-center gap-5 w-full">
										<div class="min-w-[200px]">
											<p>{new Date(step_history.date).toLocaleString()}</p>
											<div class="{stepHistoryStatus.class} flex gap-2 items-center">
												<p class="font-semibold">
													{stepHistoryStatus.message}
												</p>
												<svelte:component this={$icons[stepHistoryStatus.icon]} size="1.5rem" />
											</div>
										</div>
										<div class="flex items-center gap-5 flex-1">
											<img class="h-16 w-16" src="/favicon.png" alt="" />
											<div class="flex-1">
												<div class="flex gap-10 items-start w-full">
													<div>
														<p>{approver.first_name} {approver.last_name}</p>
														<p>{approver.email}</p>
													</div>
													<div class="ml-auto">
														<p>{approver.job_title}</p>
														<div class="flex gap-2 justify-end">
															{#each approver.groups as group}
																<GroupBadge {group} />
															{/each}
														</div>
													</div>
												</div>
											</div>
										</div>
									</li>
								{/each}
							</ul>
						</Popup>
					{/if}

					<button
						type="button"
						class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-accent-orange"
					>
						<Pencil size="1.25rem" />
						<span>Edytuj wniosek</span>
					</button>
					<button
						type="button"
						class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray"
					>
						<ArrowULeftTop size="1.25rem" />
						<span>Wycofaj wniosek</span>
					</button>
				</div>
			</Dropdown>
		{/if}
		<LeaveRequestDetails
			leaveRequest={selectedLeaveRequest}
			user={selectedLeaveRequest.user || data.user}
		/>
	</Popup>
{/if}
