<script>
	import { icons } from '../stores/icons.js';
	import Circle from 'svelte-material-icons/Circle.svelte';
	import CircleOutline from 'svelte-material-icons/CircleOutline.svelte';
	import ChevronDown from 'svelte-material-icons/ChevronDown.svelte';
	import ChevronUp from 'svelte-material-icons/ChevronUp.svelte';
	import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte';
	import EmployeeList from './EmployeeList.svelte';
	import GroupBadge from './GroupBadge.svelte';
	import Dropdown from './Dropdown.svelte';
	import { getStatusInfo, STATUS_ICONS } from '../utils/getStatusInfo.js';
	export let leaveRequest;
	export let user;

	let hoveredUser = null;
	let userTrigger = null;
	let approverTriggers = {};

	const onUserHoverStart = (user) => {
		hoveredUser = user;
		toggleDropdown(user.id);
	};
	const onUserHoverEnd = () => {
		hoveredUser = null;
		openDropdownId = null;
	};

	let openDropdownId = null;
	const toggleDropdown = (id) => {
		openDropdownId = openDropdownId === id ? null : id;
	};

	let rejectionTrigger = null;
	let replacementTrigger = null;

	$: rejectionStep =
		leaveRequest.status === 'REJECTED'
			? leaveRequest.approval_steps_history.find((step) => step.status === 'REJECTED')
			: null;

	$: leaveRequestStatusInfo = getStatusInfo(leaveRequest.status);
	$: replacementStatusInfo = leaveRequest.replacement
		? getStatusInfo(leaveRequest.replacement.status)
		: null;
</script>

<div>
	<div class="relative w-full">
		<div class="{leaveRequestStatusInfo.class} flex gap-2 items-center">
			<p class="font-semibold text-lg">
				{leaveRequestStatusInfo.message}
			</p>
			<svelte:component this={$icons[leaveRequestStatusInfo.icon]} size="1.75rem" />
			{#if leaveRequest.status === 'REJECTED' && rejectionStep.comment}
				<div class="text-main-black">
					<button
						type="button"
						bind:this={rejectionTrigger}
						class="flex items-center"
						on:click={() => toggleDropdown('rejection')}
					>
						{#if openDropdownId !== 'rejection'}
							<ChevronDown class="text-main-gray" size="1.75rem" />
						{:else}
							<ChevronUp class="text-main-gray" size="1.75rem" />
						{/if}
					</button>
					{#if openDropdownId === 'rejection'}
						<Dropdown
							triggerElement={rejectionTrigger}
							toggleDropdown={() => toggleDropdown('rejection')}
						>
							<div class="p-4">
								<p class="font-semibold">Wniosek odrzucony przez:</p>
								<div class="flex items-center gap-5 flex-1">
									<img class="h-16 w-16" src="/favicon.png" alt="" />
									<div class="flex-1">
										<div class="flex gap-10 items-start">
											<div>
												<p>
													{rejectionStep.approver.first_name}
													{rejectionStep.approver.last_name}
												</p>
												<p>{rejectionStep.approver.email}</p>
											</div>
											<div class="text-right">
												<p>{rejectionStep.approver.job_title}</p>
												<div class="flex gap-2 justify-end">
													{#each rejectionStep.approver.groups as group}
														<GroupBadge {group} />
													{/each}
												</div>
											</div>
										</div>
									</div>
								</div>
								<p class="font-semibold">Powód odrzucenia:</p>
								<p>{rejectionStep.comment}</p>
							</div>
						</Dropdown>
					{/if}
				</div>
			{/if}
		</div>
	</div>
	<div>
		<p>{leaveRequest.leave_type.name}</p>
		<p>{leaveRequest.reason}</p>
		<p>
			{new Date(leaveRequest.date_from).toLocaleDateString()} - {new Date(
				leaveRequest.date_to
			).toLocaleDateString()} ({leaveRequest.days_count} dni)
		</p>
		{#if leaveRequest.leave_type.requires_replacement && leaveRequest.replacement && replacementStatusInfo}
			<p class="inline-block">Zastępstwo:</p>
			<div class="relative inline-block">
				<div class="{replacementStatusInfo.class} flex gap-2 items-center">
					<p class="font-semibold">
						{replacementStatusInfo.message}
					</p>
					<svelte:component this={$icons[replacementStatusInfo.icon]} size="1.5rem" />
					<div class="text-main-black">
						<button
							type="button"
							bind:this={replacementTrigger}
							class="flex items-center"
							on:click={() => toggleDropdown('replacement')}
						>
							{#if openDropdownId !== 'replacement'}
								<ChevronDown class="text-main-gray" size="1.5rem" />
							{:else}
								<ChevronUp class="text-main-gray" size="1.5rem" />
							{/if}
						</button>
						{#if openDropdownId === 'replacement'}
							<Dropdown
								triggerElement={replacementTrigger}
								toggleDropdown={() => toggleDropdown('replacement')}
							>
								<div class="p-4">
									<p class="font-semibold">Osoba wyznaczona do zastępstwa:</p>
									<div class="flex items-center gap-5 flex-1">
										<img class="h-16 w-16" src="/favicon.png" alt="" />
										<div class="flex-1">
											<div class="flex gap-10 items-start">
												<div>
													<p>
														{leaveRequest.replacement.user.first_name}
														{leaveRequest.replacement.user.last_name}
													</p>
													<p>{leaveRequest.replacement.user.email}</p>
												</div>
												<div class="text-right">
													<p>{leaveRequest.replacement.user.job_title}</p>
													<div class="flex gap-2 justify-end">
														{#each leaveRequest.replacement.user.groups as group}
															<GroupBadge {group} />
														{/each}
													</div>
												</div>
											</div>
										</div>
									</div>
									{#if leaveRequest.replacement.comment}
										<p class="font-semibold">Komentarz:</p>
										<p>{leaveRequest.replacement.comment}</p>
									{/if}
								</div>
							</Dropdown>
						{/if}
					</div>
				</div>
			</div>
		{/if}
	</div>
	<div class="flex">
		<div
			class="flex flex-col items-center w-48"
			bind:this={userTrigger}
			on:pointerenter={() => onUserHoverStart(user)}
			on:pointerleave={() => onUserHoverEnd()}
		>
			<img class="h-10 w-10" src="/favicon.png" alt="" />
			<p>{user.first_name} {user.last_name}</p>
			<div class="flex gap-2 text-main-app items-center">
				<p class="font-semibold">Wysłany</p>
				<svelte:component this={$icons[STATUS_ICONS['SENT']]} size="1.5rem" />
			</div>
		</div>

		{#if hoveredUser?.id === user.id && userTrigger}
			<Dropdown triggerElement={userTrigger} toggleDropdown={() => toggleDropdown(user.id)}>
				<div class="p-4">
					<div class="flex items-center gap-5 flex-1">
						<img class="h-16 w-16" src="/favicon.png" alt="" />
						<div class="flex-1">
							<div class="flex gap-10 items-start">
								<div>
									<p>{user.first_name} {user.last_name}</p>
									<p>{user.email}</p>
								</div>
								<div class="text-right">
									<p>{user.job_title}</p>
									<div class="flex gap-2 justify-end">
										{#each user.groups as group}
											<GroupBadge {group} />
										{/each}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</Dropdown>
		{/if}

		{#each leaveRequest.approval_process.steps as step}
			{@const stepHistory = leaveRequest.approval_steps_history.find(
				(history) => history.step === step.order
			)}
			{@const isCurrentStep = leaveRequest.current_approval_step === step.order}
			{@const stepStatusInfo = stepHistory ? getStatusInfo(stepHistory.status) : null}

			<div
				class="flex flex-col items-center w-48"
				bind:this={approverTriggers[step.approver.id]}
				on:pointerenter={() => onUserHoverStart(step.approver)}
				on:pointerleave={() => onUserHoverEnd()}
			>
				<img class="h-10 w-10" src="/favicon.png" alt="" />
				<p>{step.approver.first_name} {step.approver.last_name}</p>

				{#if stepHistory && stepStatusInfo}
					<div class="flex gap-2 {stepStatusInfo.class} items-center">
						<p class="font-semibold">{stepStatusInfo.message}</p>
						<svelte:component this={$icons[stepStatusInfo.icon]} size="1.5rem" />
					</div>
				{:else if isCurrentStep}
					<div class="flex gap-2 text-accent-orange items-center">
						<p class="font-semibold">Oczekuje</p>
						<svelte:component this={$icons[STATUS_ICONS['IN_PROGRESS']]} size="1.5rem" />
					</div>
				{/if}
			</div>

			{#if hoveredUser?.id === step.approver.id && approverTriggers[step.approver.id]}
				<Dropdown
					triggerElement={approverTriggers[step.approver.id]}
					toggleDropdown={() => toggleDropdown(step.approver.id)}
				>
					<div class="p-4">
						<div class="flex items-center gap-5 flex-1">
							<img class="h-16 w-16" src="/favicon.png" alt="" />
							<div class="flex-1">
								<div class="flex gap-10 items-start">
									<div>
										<p>{step.approver.first_name} {step.approver.last_name}</p>
										<p>{step.approver.email}</p>
									</div>
									<div class="text-right">
										<p>{step.approver.job_title}</p>
										<div class="flex gap-2 justify-end">
											{#each step.approver.groups as group}
												<GroupBadge {group} />
											{/each}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</Dropdown>
			{/if}
		{/each}
	</div>
</div>
