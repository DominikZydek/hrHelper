<script>
	import Calendar from '@event-calendar/core';
	import Dropdown from '../../../../components/Dropdown.svelte';
	import EmployeeList from '../../../../components/EmployeeList.svelte';
	import Popup from '../../../../components/Popup.svelte';
	import SendOutline from 'svelte-material-icons/SendOutline.svelte';
	import { getStatusInfo } from '../../../../utils/getStatusInfo.js';
	import DayGrid from '@event-calendar/day-grid';
	import Interaction from '@event-calendar/interaction';
	import LeaveRequestDetails from '../../../../components/LeaveRequestDetails.svelte';
	import { icons } from '../../../../stores/icons.js';
	import GroupBadge from '../../../../components/GroupBadge.svelte';
	import ArrowULeftTop from 'svelte-material-icons/ArrowULeftTop.svelte';
	import History from 'svelte-material-icons/History.svelte';
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte';
	import { MeterChart } from '@carbon/charts-svelte';
	import { getUserPTOInfo } from '../../../../utils/getUserPTOInfo.js';

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
			start: new Date(request.date_from),
			end: new Date(request.date_to),
			title: `${
				request.user // if user is defined, it's not my request
					? `${request.user.first_name} ${request.user.last_name} - ${request.leave_type.name}`
					: `${request.leave_type.name} - ${request.reason}`
			}`,
			backgroundColor: getStatusInfo(request.status).color,
			editable: false
		}));
	};

	// TODO: These are not rendered when choosing options (only mine, only approved)
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

	const handleDataCellClick = (info) => {
		const clickedDate = info.date.toLocaleDateString('en-CA');

		const dateFromInput = document.getElementById('date_from');
		const dateToInput = document.getElementById('date_to');

		if (dateFromInput.value && dateFromInput.value <= clickedDate) {
			dateToInput.value = clickedDate;
		} else {
			dateFromInput.value = clickedDate;
		}
	};

	const handleNewEventSelection = (info) => {
		const dateFrom = info.start.toLocaleDateString('en-CA');
		const dateTo = info.end.toISOString().split('T')[0]; // this has to be this way since the calendar is a day ahead

		const dateFromInput = document.getElementById('date_from');
		const dateToInput = document.getElementById('date_to');

		dateFromInput.value = dateFrom;
		dateToInput.value = dateTo;
	};

	let showOnlyMyRequestsButtonActive = false;
	let showOnlyApprovedRequestsButtonActive = false;

	let plugins = [DayGrid, Interaction];
	let options = $state({
		view: 'dayGridMonth',
		events: [
			...mapLeaveRequestsToCalendarEvents(calendarDisplayedRequests),
			...mapCompanyHolidaysToCalendarEvents(companyHolidays)
		],
		eventClick: (info) => handleEventClick(info),
		selectable: true,
		unselectAuto: false,
		select: (info) => handleNewEventSelection(info),
		selectBackgroundColor: '#2563EB',
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
	});

	let showEmployeeList = $state(false);
	const toggleEmployeeList = () => {
		showEmployeeList = !showEmployeeList;
	};
	let selectedReplacement = $state(null);
	const onSelectReplacement = (replacement) => {
		selectedReplacement = replacement;
		toggleEmployeeList();
	};

	let selectedLeaveTypeId = $state(data.leaveTypes[0]?.id || null);
	let selectedLeaveType = $state();
	let showReplacementSelect = $state(false);

	$effect(() => {
		selectedLeaveType = data.leaveTypes.find((type) => type.id === selectedLeaveTypeId);
	});

	$effect(() => {
		showReplacementSelect = selectedLeaveType?.requires_replacement === true;
	});

	let saveAsDraft = $state(false);

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
</script>

<div class="flex-1 p-4">
	<div class="flex items-start gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Nowy wniosek</p>
	</div>
	<div class="w-3/4 max-w-5xl m-auto flex flex-col gap-5">
		<Calendar {plugins} {options} />
		<MeterChart data={chartData} options={chartOptions} />
	</div>
</div>

<div class="flex flex-col gap-2 border py-4 shadow-xl overflow-auto">
	<form
		id="createLeaveRequest"
		action="?/createLeaveRequest"
		method="POST"
		class="flex flex-col gap-5 px-4"
	>
		<table class="text-left w-full">
			<tbody>
				<tr class="flex flex-col">
					<th class="font-bold text-main-gray">
						<label for="leave_type">TYP NIEOBECNOŚCI</label>
					</th>
					<td class="text-main-black font-semibold">
						<select
							bind:value={selectedLeaveTypeId}
							class="w-full border border-main-gray rounded"
							name="leave_type"
							id="leave_type"
							type="text"
						>
							{#each data.leaveTypes as leave_type}
								<option value={leave_type.id}>{leave_type.name}</option>
							{/each}
						</select>
					</td>
				</tr>
				<tr class="flex flex-col">
					<th class="font-bold text-main-gray">
						<label for="date_from">DATA ROZPOCZĘCIA NIEOBECNOŚCI</label>
					</th>
					<td class="text-main-black font-semibold">
						<input
							class="w-full border border-main-gray rounded"
							name="date_from"
							id="date_from"
							type="date"
						/>
					</td>
				</tr>
				<tr class="flex flex-col">
					<th class="font-bold text-main-gray">
						<label for="date_to">DATA ZAKOŃCZENIA NIEOBECNOŚCI</label>
					</th>
					<td class="text-main-black font-semibold">
						<input
							class="w-full border border-main-gray rounded"
							name="date_to"
							id="date_to"
							type="date"
						/>
					</td>
				</tr>
				<tr class="flex flex-col">
					<th class="font-bold text-main-gray">
						<label for="reason">POWÓD NIEOBECNOŚCI</label>
					</th>
					<td class="text-main-black font-semibold">
						<textarea
							class="border border-main-gray rounded resize-none"
							cols="35"
							rows="3"
							name="reason"
							id="reason"
						></textarea>
					</td>
				</tr>
				<tr class="flex flex-col">
					<th class="font-bold text-main-gray">
						<label for="comment">KOMENTARZ</label>
					</th>
					<td class="text-main-black font-semibold">
						<textarea
							class="border border-main-gray rounded resize-none"
							cols="35"
							rows="3"
							name="comment"
							id="comment"
						></textarea>
					</td>
				</tr>
				{#if showReplacementSelect}
					<tr class="flex flex-col">
						<th class="font-bold text-main-gray">
							<label for="replacement_select">OSOBA ZASTĘPUJĄCA</label>
						</th>
						<td class="text-main-black font-semibold">
							<input
								onclick={() => toggleEmployeeList()}
								class="w-full border border-main-gray rounded"
								type="text"
								id="replacement_select"
								readonly
								placeholder={selectedReplacement ? '' : 'Wybierz zastępstwo'}
								value={selectedReplacement
									? `${selectedReplacement?.first_name} ${selectedReplacement?.last_name}`
									: null}
							/>
							<input
								name="replacement"
								id="replacement"
								type="hidden"
								value={selectedReplacement?.id}
							/>
						</td>
						{#if showEmployeeList}
							<Popup title="Wybierz zastępstwo" togglePopup={toggleEmployeeList}>
								<EmployeeList users={data.users} onClick={onSelectReplacement} />
							</Popup>
						{/if}
					</tr>
				{/if}
			</tbody>
		</table>

		<div class="flex">
			<button
				type="submit"
				class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4"
			>
				<SendOutline />
				Wyślij wniosek
			</button>
			<button
				type="submit"
				onclick={() => (saveAsDraft = true)}
				class="flex gap-1 items-center text-main-gray h-8 px-4"
			>
				Zapisz jako wersja robocza
			</button>
			<input type="hidden" id="save_as_draft" name="save_as_draft" value={saveAsDraft} />
		</div>
	</form>
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
