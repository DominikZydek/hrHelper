import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import {
	PUBLIC_PUSHER_KEY,
	PUBLIC_PUSHER_CLUSTER,
	PUBLIC_API_URL,
	PUBLIC_FRONTEND_URL,
	PUBLIC_PUSHER_HOST,
	PUBLIC_PUSHER_PORT
} from '$env/static/public';
import { writable } from 'svelte/store';

export const notifications = writable([]);
export const unreadCount = writable(0);

export function initEcho() {
	window.Pusher = Pusher;

	window.Echo = new Echo({
		broadcaster: 'pusher',
		key: PUBLIC_PUSHER_KEY,
		cluster: PUBLIC_PUSHER_CLUSTER,
		...(PUBLIC_PUSHER_HOST ? { wsHost: PUBLIC_PUSHER_HOST } : {}),
		wsPort: PUBLIC_PUSHER_PORT,
		forceTLS: true,
		authEndpoint: `${PUBLIC_FRONTEND_URL}/api/broadcasting/auth`
	});

	return window.Echo;
}

export function listenForNotifications(userId) {
	if (!window.Echo) {
		console.error('Echo is not initialized');
		return;
	}

	const channel = window.Echo.private(`App.Models.User.${userId}`);

	channel.listen(
		'.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated',
		(notification) => {
			notifications.update((n) => {
				const newNotifications = [notification, ...n];
				return newNotifications.slice(0, 50);
			});

			unreadCount.update((count) => count + 1);
		}
	);
}

export async function fetchNotifications() {
	try {
		const query = `
            query {
                userNotifications {
									id,
									type,
									data {
										id,
										type,
										title,
										message,
										url,
										comment,
										action_type
									}
									read_at
									created_at
								}
								unreadNotificationsCount
            }
        `;

		const res = await fetch(`${PUBLIC_FRONTEND_URL}/api/notifications`, {
			method: 'POST',
			credentials: 'include',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ query })
		}).then((res) => res.json());

		console.log(res);

		if (res.errors) {
			throw new Error(res.errors[0].message);
		}

		notifications.set(res.data.userNotifications || []);

		unreadCount.set(res.data.unreadNotificationsCount || 0);
	} catch (error) {
		console.error(error);
	}
}

export async function markAsRead(id = null) {
	try {
		let query;
		let variables = {};

		if (id) {
			query = `
                mutation MarkNotificationAsRead($id: ID!) {
                    markNotificationAsRead(id: $id)
                }
            `;
			variables.id = id;
		} else {
			query = `
                mutation {
                    markAllNotificationsAsRead
                }
            `;
		}

		const response = await fetch(`${PUBLIC_FRONTEND_URL}/api/notifications`, {
			method: 'POST',
			credentials: 'include',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ query, variables })
		});

		const result = await response.json();

		if (result.errors) {
			throw new Error(result.errors[0].message);
		}

		if (id) {
			notifications.update((n) =>
				n.map((notif) =>
					notif.id === id ? { ...notif, read_at: new Date().toISOString() } : notif
				)
			);
			unreadCount.update((count) => Math.max(0, count - 1));
		} else {
			notifications.update((n) =>
				n.map((notif) => ({ ...notif, read_at: notif.read_at || new Date().toISOString() }))
			);
			unreadCount.set(0);
		}
	} catch (error) {
		console.error(error);
	}
}
