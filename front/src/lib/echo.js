import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import {
	PUBLIC_PUSHER_KEY,
	PUBLIC_PUSHER_CLUSTER,
	PUBLIC_API_URL,
	PUBLIC_FRONTEND_URL
} from '$env/static/public';
import { writable } from 'svelte/store';

export const notifications = writable([]);
export const unreadCount = writable(0);

export function initEcho() {
	window.Pusher = Pusher;

	console.log(document);

	window.Echo = new Echo({
		broadcaster: 'pusher',
		key: PUBLIC_PUSHER_KEY,
		cluster: PUBLIC_PUSHER_CLUSTER,
		forceTLS: true,
		authEndpoint: `${PUBLIC_API_URL}/broadcasting/auth`,
		auth: {
			headers: {
				'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
			}
		}
	});

	return window.Echo;
}

function getCookie(name) {
	const value = `; ${document.cookie}`;
	const parts = value.split(`; ${name}=`);
	if (parts.length === 2) return parts.pop().split(';').shift();
	return null;
}

export function listenForNotifications(userId) {
	if (!window.Echo) {
		console.error('Echo nie jest zainicjalizowane');
		return;
	}

	window.Echo.private(`App.Models.User.${userId}`).notification((notification) => {
		notifications.update((n) => {
			const newNotifications = [notification, ...n];
			return newNotifications.slice(0, 50);
		});

		unreadCount.update((count) => count + 1);

		showDesktopNotification(notification);
	});
}

export async function fetchNotifications() {
	try {
		const query = `
            query {
                userNotifications {
									id,
									type,
									data {
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

		const response = await fetch(`${PUBLIC_FRONTEND_URL}/api/notifications`, {
			method: 'POST',
			credentials: 'include',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ query })
		});

		const result = await response.json();

		if (result.errors) {
			throw new Error(result.errors[0].message);
		}

		const data = result.data;

		notifications.set(data.userNotifications || []);

		unreadCount.set(data.unreadNotificationsCount || 0);
	} catch (error) {
		console.error('Błąd podczas pobierania powiadomień:', error);
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
				'Content-Type': 'application/json',
				'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
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
		console.error('Błąd podczas oznaczania jako przeczytane:', error);
	}
}

export async function checkNotificationPermission() {
	if (!('Notification' in window)) {
		console.warn('Ten system nie obsługuje powiadomień');
		return false;
	}

	if (Notification.permission === 'granted') {
		return true;
	}

	if (Notification.permission !== 'denied') {
		const permission = await Notification.requestPermission();
		return permission === 'granted';
	}

	return false;
}

export function showDesktopNotification(notification) {
	if (!('Notification' in window) || Notification.permission !== 'granted') {
		return;
	}

	const data =
		typeof notification.data === 'string' ? JSON.parse(notification.data) : notification.data;

	const notif = new Notification(data.title || 'Nowe powiadomienie', {
		body: data.message || '',
		icon: '/favicon.png',
		tag: notification.id,
		data: { url: data.url }
	});

	notif.onclick = function () {
		window.focus();
		if (this.data && this.data.url) {
			window.location.href = this.data.url;
		}
		this.close();
	};

	setTimeout(notif.close.bind(notif), 5000);
}
