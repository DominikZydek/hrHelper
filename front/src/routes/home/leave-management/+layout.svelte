<script>
	import FilePlusOutline from 'svelte-material-icons/FilePlusOutline.svelte';
	import FileDocumentOutline from 'svelte-material-icons/FileDocumentOutline.svelte';
	import CalendarMonth from 'svelte-material-icons/CalendarMonth.svelte';
	import ClockTimeFourOutline from 'svelte-material-icons/ClockTimeFourOutline.svelte';
	import { page } from '$app/state';
	import { getStatusInfo } from '../../../utils/getStatusInfo.js';
	import Popup from '../../../components/Popup.svelte';
	import LeaveRequestDetails from '../../../components/LeaveRequestDetails.svelte';
	import Dropdown from '../../../components/Dropdown.svelte';
	import { icons } from '../../../stores/icons.js';
	import GroupBadge from '../../../components/GroupBadge.svelte';
	import ArrowULeftTop from 'svelte-material-icons/ArrowULeftTop.svelte';
	import History from 'svelte-material-icons/History.svelte';
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte';
	import { setContext } from 'svelte';

	let path = $derived(page.url.pathname.split('/')[3]);

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

	setContext('leave-management', {
		selectedLeaveRequest,
		handleEventClick,
		onClick,
		togglePopup
	});

	let { data } = $props();
</script>

<div class="w-full h-full flex">
	<div class="flex flex-col gap-2 border py-4 shadow-xl overflow-auto">
		<p class="text-2xl font-semibold text-main-app mb-2 px-4">Nieobecności</p>
		<a
			href="/home/leave-management/new-request"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                  {path === 'new-request' ? 'bg-auxiliary-gray' : ''}"
		>
			<FilePlusOutline size="1.75rem" />
			<span>Nowy wniosek</span>
		</a>
		<a
			href="/home/leave-management/my-requests"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                  {path === 'my-requests' ? 'bg-auxiliary-gray' : ''}"
		>
			<FileDocumentOutline size="1.75rem" />
			<span>Moje wnioski</span>
		</a>
		<a
			href="/home/leave-management/calendar"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                 {path === 'calendar' ? 'bg-auxiliary-gray' : ''}"
		>
			<CalendarMonth size="1.75rem" />
			<span>Kalendarz</span>
		</a>
		<a
			href="/home/leave-management/approvals"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                  {path === 'approvals' ? 'bg-auxiliary-gray' : ''}"
		>
			<ClockTimeFourOutline size="1.75rem" />
			<span>Wnioski do rozpatrzenia</span>
		</a>
	</div>
	<slot />
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
