<script>
	import {
		notifications,
		unreadCount,
		initEcho,
		listenForNotifications,
		fetchNotifications,
		markAsRead
	} from '$lib/echo';
	import { onDestroy, onMount } from 'svelte';
	import { browser } from '$app/environment';

	let { data } = $props();

	let echo = null;
	let user = data.user;

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

	$inspect($notifications, $unreadCount);
</script>
