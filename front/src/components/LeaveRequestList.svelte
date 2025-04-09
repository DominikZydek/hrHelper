<script>
	import { getStatusInfo } from '../utils/getStatusInfo.js';
	import { icons } from '../stores/icons.js';
	import GroupBadge from './GroupBadge.svelte';
	import IconWithNotificationBadge from './IconWithNotificationBadge.svelte';
	import { onMount } from 'svelte';
	export let leaveRequests;
	export let onClick;

	// string setting the mode of the component, 'view' or 'manage'<br>
	// default - 'view'
	export let mode = 'view';

	// a flag determining if the component is to be displayed with h-full, if false -> h-[50vh]<br>
	// default - true
	export let fullHeight = true;

	let isReady = false;
	let redirectedViaId = null;

	onMount(() => {
		const params = new URLSearchParams(document.location.search);
		const id = params.get('id');

		if (id) {
			redirectedViaId = id;
			onClick(leaveRequests.find((r) => r.id === id));
		}

		isReady = true;
	});
</script>

{#if isReady}
	{#if mode === 'view'}
		<div class="w-full {fullHeight ? '' : 'max-h-[50vh]'} overflow-auto rounded-lg shadow-xl">
			<table class="w-full text-left border">
				<thead class="sticky top-0 z-10">
					<tr class="bg-blue-100 text-main-gray">
						<th class="px-4 py-3">Typ urlopu</th>
						<th class="px-4 py-3">Termin urlopu</th>
						<th class="px-4 py-3 text-center">Dni</th>
						<th class="px-4 py-3 text-center">Status</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-main-gray">
					{#each leaveRequests as leaveRequest}
						{@const statusInfo = getStatusInfo(leaveRequest.status)}
						<tr
							class="cursor-pointer hover:bg-auxiliary-gray"
							on:click={() => onClick(leaveRequest)}
						>
							<td class="px-4 py-3">{leaveRequest.leave_type.name}</td>
							<td class="px-4 py-3"
								>{new Date(leaveRequest.date_from).toLocaleDateString()} - {new Date(
									leaveRequest.date_to
								).toLocaleDateString()}</td
							>
							<td class="px-4 py-3 text-center">
								<span
									class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full font-medium bg-blue-100 text-main-app"
								>
									{leaveRequest.days_count}
								</span>
							</td>
							<td class="px-4 py-3">
								<div class="flex items-center justify-center">
									<div class="flex gap-2 items-center px-3 py-1 rounded-full {statusInfo.class}">
										<p class="font-semibold">{statusInfo.message}</p>
										<svelte:component this={$icons[statusInfo.icon]} size="1.5rem" />
									</div>
								</div>
							</td>
						</tr>
					{/each}
				</tbody>
			</table>
		</div>
	{:else if mode === 'manage'}
		<div class="w-full {fullHeight ? '' : 'max-h-[50vh]'} overflow-auto rounded-lg shadow-xl">
			<table class="w-full text-left border">
				<thead class="sticky top-0 z-10">
					<tr class="bg-blue-100 text-main-gray">
						<th class="px-4 py-3 w-1/3">Wnioskujący</th>
						<th class="px-4 py-3 w-1/6">Typ urlopu</th>
						<th class="px-4 py-3 w-1/6">Termin urlopu</th>
						<th class="px-4 py-3 text-center w-1/12">Dni</th>
						<th class="px-4 py-3 text-center w-1/6">Status</th>
					</tr></thead
				>
				<tbody class="divide-y divide-main-gray">
					{#each leaveRequests as leaveRequest}
						{@const statusInfo = getStatusInfo(leaveRequest.status)}
						<tr
							class="cursor-pointer hover:bg-auxiliary-gray"
							on:click={() => onClick(leaveRequest)}
						>
							<td class="px-4 py-3">
								<div class="flex items-center gap-5">
									{#if leaveRequest.id === redirectedViaId}
										<IconWithNotificationBadge>
											<img class="h-16 w-16" src="/favicon.png" alt="" slot="icon" />
										</IconWithNotificationBadge>
									{:else}
										<img class="h-16 w-16" src="/favicon.png" alt="" />
									{/if}
									<div class="flex-1">
										<div class="flex gap-5 items-start">
											<div>
												<p>{leaveRequest.user.first_name} {leaveRequest.user.last_name}</p>
												<p>{leaveRequest.user.email}</p>
											</div>
											<div class="text-right">
												<p>{leaveRequest.user.job_title}</p>
												<div class="flex gap-2 justify-end">
													{#each leaveRequest.user.groups as group}
														<GroupBadge {group} />
													{/each}
												</div>
											</div>
										</div>
									</div>
								</div>
							</td>
							<td class="px-4 py-3">{leaveRequest.leave_type.name}</td>
							<td class="px-4 py-3"
								>{new Date(leaveRequest.date_from).toLocaleDateString()} - {new Date(
									leaveRequest.date_to
								).toLocaleDateString()}</td
							>
							<td class="px-4 py-3 text-center">
								<span
									class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full font-medium bg-blue-100 text-main-app"
								>
									{leaveRequest.days_count}
								</span>
							</td>
							<td class="px-4 py-3">
								<div class="flex items-center justify-center">
									<div class="flex gap-2 items-center px-3 py-1 rounded-full {statusInfo.class}">
										<p class="font-semibold">{statusInfo.message}</p>
										<svelte:component this={$icons[statusInfo.icon]} size="1.5rem" />
									</div>
								</div>
							</td>
						</tr>
					{/each}
				</tbody>
			</table>
		</div>
	{/if}
{/if}
