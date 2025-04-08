<script>
	import { onMount, onDestroy } from 'svelte';
	import { page } from '$app/stores';
	import {
		notifications,
		unreadCount,
		initEcho,
		listenForNotifications,
		fetchNotifications,
		markAsRead
	} from '$lib/echo';
	import { slide } from 'svelte/transition';
	import Bell from 'svelte-material-icons/Bell.svelte';
	import BellOutline from 'svelte-material-icons/BellOutline.svelte';
	import Close from 'svelte-material-icons/Close.svelte';
	import CheckAll from 'svelte-material-icons/CheckAll.svelte';
	import IconWithNotificationBadge from './IconWithNotificationBadge.svelte';
	import { browser } from '$app/environment';

	export let user;

	let showPanel = false;
	let echo = null;

	onMount(async () => {
		if (browser) {
			// Kod wykorzystujący window
			echo = initEcho();
			await fetchNotifications();
			listenForNotifications(user.id);

			if ('Notification' in window && Notification.permission === 'default') {
				await Notification.requestPermission();
			}
		}
	});

	onDestroy(() => {
		// Zatrzymaj nasłuchiwanie powiadomień
		if (browser && echo) {
			echo.leave(`App.Models.User.${user.id}`);
		}
	});

	function togglePanel() {
		showPanel = !showPanel;
	}

	function handleNotificationClick(notification) {
		// Oznacz jako przeczytane
		markAsRead(notification.id);

		// Przekieruj jeśli jest URL
		if (browser && notification.url) {
			if (window.location.pathname === notification.url) {
				togglePanel();
			} else {
				window.location.href = notification.url;
			}
		} else {
			togglePanel();
		}
	}

	// Formatowanie daty
	function formatDate(dateString) {
		const date = new Date(dateString);
		const now = new Date();

		// Ten sam dzień
		if (date.toDateString() === now.toDateString()) {
			return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
		}

		// W tym tygodniu
		const daysAgo = Math.floor((now - date) / (1000 * 60 * 60 * 24));
		if (daysAgo < 7) {
			const options = { weekday: 'long' };
			return date.toLocaleDateString(undefined, options);
		}

		// Dawniej
		return date.toLocaleDateString();
	}

	function getTypeIcon(type) {
		if (type === 'message') return 'EmailOutline';
		if (type === 'leave_request') return 'CalendarClock';
		return 'BellOutline';
	}

	function markAllNotificationsAsRead() {
		markAsRead();
	}
</script>

<div class="relative">
	<button on:click={togglePanel} class="relative">
		<IconWithNotificationBadge number={$unreadCount}>
			{#if $unreadCount > 0}
				<Bell size="1.75rem" slot="icon" class="text-main-white" />
			{:else}
				<BellOutline size="1.75rem" slot="icon" class="text-main-white" />
			{/if}
		</IconWithNotificationBadge>
	</button>

	{#if showPanel}
		<div
			transition:slide={{ duration: 200 }}
			class="absolute right-0 mt-2 w-80 bg-white shadow-xl rounded-lg overflow-hidden z-50"
		>
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
				{#if $notifications.length === 0}
					<div class="p-4 text-center text-gray-500">Brak powiadomień</div>
				{:else}
					<ul class="divide-y divide-gray-200">
						{#each $notifications as notification}
							<li
								class="p-3 hover:bg-gray-50 cursor-pointer {notification.read_at
									? 'bg-white'
									: 'bg-blue-50'}"
								on:click={() => handleNotificationClick(notification)}
							>
								<div class="flex justify-between">
									<div class="font-semibold">{notification.title}</div>
									<div class="text-xs text-gray-500">{formatDate(notification.created_at)}</div>
								</div>
								<div class="text-sm">{notification.message}</div>
								{#if notification.comment}
									<div class="text-xs text-gray-600 mt-1">{notification.comment}</div>
								{/if}
							</li>
						{/each}
					</ul>
				{/if}
			</div>
		</div>
	{/if}
</div>
