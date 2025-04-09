<script>
	import { notifications, unreadCount, markAsRead } from '$lib/echo';
	import Close from 'svelte-material-icons/Close.svelte';
	import CheckAll from 'svelte-material-icons/CheckAll.svelte';
	import { browser } from '$app/environment';
	import { calculateTimeAgo } from '../utils/timeCalculation.js';
	import { icons } from '../stores/icons.js';

	let { togglePanel } = $props();

	function handleNotificationClick(notification) {
		markAsRead(notification.id);

		if (browser && notification.data.url) {
			if (window.location.pathname === notification.data.url + '?id=' + notification.data.id) {
				togglePanel();
			} else {
				window.location.href = notification.data.url + '?id=' + notification.data.id;
			}
		} else {
			togglePanel();
		}
	}

	$inspect($notifications);

	function getTypeIcon(type) {
		if (type === 'message') return 'EmailOutline';
		if (type === 'leave_request') return 'CalendarClock';
		return 'BellOutline';
	}

	function markAllNotificationsAsRead() {
		markAsRead();
	}
</script>

<div class="fixed left-24 bottom-4 bg-white shadow-xl rounded-lg overflow-hidden z-50">
	<div class="flex justify-between items-center bg-main-app text-white p-3">
		<h3 class="font-semibold">Powiadomienia ({$unreadCount} nowych)</h3>
		<div class="flex gap-2">
			{#if $unreadCount > 0}
				<button on:click={markAllNotificationsAsRead} title="Oznacz wszystkie jako przeczytane">
					<CheckAll size="1.2rem" />
				</button>
			{/if}
			<button on:click={togglePanel} title="Zamknij">
				<Close size="1.2rem" />
			</button>
		</div>
	</div>

	<div class="max-h-96 overflow-y-auto">
		{#if !$notifications || $notifications.length === 0}
			<div class="p-4 text-center text-gray-500">Brak powiadomień</div>
		{:else}
			<ul class="divide-y divide-gray-200">
				{#each $notifications as notification}
					{@const notificationData = notification.data || {}}
					<li
						class="p-3 hover:bg-gray-50 cursor-pointer {notification.read_at
							? 'bg-white'
							: 'bg-blue-50'}"
						on:click={() => handleNotificationClick(notification)}
					>
						<div class="flex justify-between gap-5">
							<div class="flex items-center gap-2">
								<svelte:component this={$icons[getTypeIcon(notificationData.type)]} />
								<div class="font-semibold">{notificationData.title || 'Powiadomienie'}</div>
							</div>
							<div class="text-xs text-gray-500">{calculateTimeAgo(notification.created_at)}</div>
						</div>
						<div class="text-sm">{notificationData.message || ''}</div>
						{#if notificationData.comment}
							<div class="text-xs text-gray-600 mt-1">{notificationData.comment}</div>
						{/if}
					</li>
				{/each}
			</ul>
		{/if}
	</div>
</div>
