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
	import BellRing from 'svelte-material-icons/BellRing.svelte';
	import Close from 'svelte-material-icons/Close.svelte';
	import CheckAll from 'svelte-material-icons/CheckAll.svelte';
	import IconWithNotificationBadge from './IconWithNotificationBadge.svelte';
	import { browser } from '$app/environment';
	import NotificationPanel from './NotificationPanel.svelte';

	export let user;
	export let togglePanel;

	let echo = null;

	onMount(async () => {
		if (browser) {
			echo = initEcho();
			await fetchNotifications();
			listenForNotifications(user.id);

			if ('Notification' in window && Notification.permission === 'default') {
				await Notification.requestPermission();
			}
		}
	});

	onDestroy(() => {
		if (browser && echo) {
			echo.leave(`App.Models.User.${user.id}`);
		}
	});
</script>

<div class="relative">
	<button on:click={togglePanel} class="relative">
		{#if $unreadCount === 0}
			<IconWithNotificationBadge number={$unreadCount}>
				<Bell size="2rem" slot="icon" class="text-main-white" />
			</IconWithNotificationBadge>
		{:else}
			<IconWithNotificationBadge number={$unreadCount}>
				<BellRing size="2rem" slot="icon" class="text-main-white" />
			</IconWithNotificationBadge>
		{/if}
	</button>
</div>
