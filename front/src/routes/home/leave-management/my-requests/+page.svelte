<script>
	import { getStatusInfo } from '../../../../utils/getStatusInfo.js';
	import Searchbar from '../../../../components/Searchbar.svelte';
	import Popup from '../../../../components/Popup.svelte';
	import LeaveRequestDetails from '../../../../components/LeaveRequestDetails.svelte';
	import Dropdown from '../../../../components/Dropdown.svelte';
	import { icons } from '../../../../stores/icons.js';
	import GroupBadge from '../../../../components/GroupBadge.svelte';
	import ArrowULeftTop from 'svelte-material-icons/ArrowULeftTop.svelte';
	import History from 'svelte-material-icons/History.svelte';
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte';
	import LeaveRequestList from '../../../../components/LeaveRequestList.svelte';
	import { getSearchbarMappers } from '../../../../utils/getSearchbarMappers.js';

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

	let showLeaveRequestHistory = $state(false);
	const toggleLeaveRequestHistory = () => {
		showLeaveRequestHistory = !showLeaveRequestHistory;
	};

	let tableRequests = data.me.leave_requests;
	let displayedRequests = $state(tableRequests);

	const handleFilteredDataChange = (filteredData) => {
		displayedRequests = filteredData;
	};
</script>

<div class="flex-1 p-4">
	<div class="flex items-center gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Moje wnioski</p>
		<div class="flex-1">
			<Searchbar
				placeholderText="Szukaj wniosku..."
				searchData={data.me.leave_requests}
				onFilteredDataChange={handleFilteredDataChange}
				searchMapper={getSearchbarMappers('LeaveRequestList', 'view').searchMapper}
				filterableFields={getSearchbarMappers('LeaveRequestList', 'view').filterableFields}
				fieldLabels={getSearchbarMappers('LeaveRequestList', 'view').fieldLabels}
			/>
		</div>
	</div>
	<LeaveRequestList {onClick} leaveRequests={displayedRequests} />
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
