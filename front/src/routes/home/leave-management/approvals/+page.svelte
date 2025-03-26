<script>
	import { getStatusInfo } from '../../../../utils/getStatusInfo.js';
	import GroupBadge from '../../../../components/GroupBadge.svelte';
	import Searchbar from '../../../../components/Searchbar.svelte';
	import { icons } from '../../../../stores/icons.js';
	import Popup from '../../../../components/Popup.svelte';
	import LeaveRequestDetails from '../../../../components/LeaveRequestDetails.svelte';
	import Dropdown from '../../../../components/Dropdown.svelte';
	import Close from 'svelte-material-icons/Close.svelte';
	import History from 'svelte-material-icons/History.svelte';
	import Check from 'svelte-material-icons/Check.svelte';
	import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte';
	import LeaveRequestList from '../../../../components/LeaveRequestList.svelte';
	import { superForm } from 'sveltekit-superforms';
	import { getContext, onMount } from 'svelte';

	let { data } = $props();

	const { form, errors, constraints, message, enhance } = superForm(data.form);

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

	let showApproveLeaveRequestPopup = $state(false);
	const toggleApproveLeaveRequestPopup = () => {
		showApproveLeaveRequestPopup = !showApproveLeaveRequestPopup;
	};

	let showRejectLeaveRequestPopup = $state(false);
	const toggleRejectLeaveRequestPopup = () => {
		showRejectLeaveRequestPopup = !showRejectLeaveRequestPopup;
	};

	let status = $state(null);

	$effect(() => {
		status = showApproveLeaveRequestPopup ? 'APPROVED' : 'REJECTED';
	});

	let tableRequests = data.leaveRequestsWhereUserIsApprover;
	let displayedRequests = $state(tableRequests);

	const handleFilteredDataChange = (filteredData) => {
		displayedRequests = filteredData;
	};
</script>

{#snippet setLeaveRequestStatusForm()}
	<Popup
		togglePopup={showApproveLeaveRequestPopup
			? toggleApproveLeaveRequestPopup
			: toggleRejectLeaveRequestPopup}
		title={showApproveLeaveRequestPopup ? 'Zatwierdź wniosek' : 'Odrzuć wniosek'}
		closeOnClickOutside={false}
	>
		<p class="mb-2">
			Czy na pewno chcesz {showApproveLeaveRequestPopup ? 'zatwierdzić' : 'odrzucić'} wniosek
			{selectedLeaveRequest.user.first_name}
			{selectedLeaveRequest.user.last_name}
			o {selectedLeaveRequest.leave_type.name}
			z powodu: {selectedLeaveRequest.reason}
			w terminie: {new Date(selectedLeaveRequest.date_from).toLocaleDateString()} -
			{new Date(selectedLeaveRequest.date_to).toLocaleDateString()} ({selectedLeaveRequest.days_count}
			dni roboczych)?
		</p>

		<label for="comment">Dodaj komentarz:</label>

		<form id="set_leave_request_status" action="?/setLeaveRequestStatus" method="POST" use:enhance>
			<input
				id="leave_request"
				name="leave_request"
				type="hidden"
				value={selectedLeaveRequest.id}
			/>

			<input id="status" name="status" type="hidden" bind:value={status} />

			<textarea
				class="border border-main-gray rounded resize-none {$errors.comment
					? 'outline-accent-red border border-accent-red'
					: ''}"
				aria-invalid={$errors.comment ? 'true' : ''}
				cols="35"
				rows="3"
				name="comment"
				id="comment"
				bind:value={$form.comment}
			></textarea>
		</form>

		{#if $errors.comment}
			<small class="text-accent-red">{$errors.comment[0]}</small>
		{/if}

		<div class="flex justify-end gap-2">
			<button
				type="submit"
				form="set_leave_request_status"
				class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4"
			>
				<Check />
				Tak
			</button>
			<button
				onclick={() => toggleApproveLeaveRequestPopup()}
				type="button"
				class="flex gap-1 items-center bg-accent-red text-main-white font-semibold h-8 px-4"
			>
				<Close />
				Nie
			</button>
		</div>
	</Popup>
{/snippet}

<div class="flex-1 p-4">
	<div class="flex items-center gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Rozpatrywane wnioski</p>
		<div class="flex-1">
			<Searchbar
				placeholderText="Szukaj wniosku..."
				searchData={data.leaveRequestsWhereUserIsApprover}
				onFilteredDataChange={handleFilteredDataChange}
			/>
		</div>
	</div>
	<LeaveRequestList leaveRequests={displayedRequests} {onClick} mode="manage" fullHeight={false} />
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
						disabled={!selectedLeaveRequest.isUserCurrentApprover}
						onclick={() => toggleApproveLeaveRequestPopup()}
						type="button"
						class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-accent-green
										{!selectedLeaveRequest.isUserCurrentApprover ? 'hidden' : ''}"
					>
						<Check size="1.25rem" />
						<span>Zatwierdź wniosek</span>
					</button>

					{#if showApproveLeaveRequestPopup}
						{@render setLeaveRequestStatusForm()}
					{/if}

					<button
						onclick={() => toggleRejectLeaveRequestPopup()}
						type="button"
						class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-accent-red
										{!selectedLeaveRequest.isUserCurrentApprover ? 'hidden' : ''}"
					>
						<Close size="1.25rem" />
						<span>Odrzuć wniosek</span>
					</button>

					{#if showRejectLeaveRequestPopup}
						{@render setLeaveRequestStatusForm()}
					{/if}
				</div>
			</Dropdown>
		{/if}
		<LeaveRequestDetails
			leaveRequest={selectedLeaveRequest}
			user={selectedLeaveRequest.user || data.user}
		/>
	</Popup>
{/if}
