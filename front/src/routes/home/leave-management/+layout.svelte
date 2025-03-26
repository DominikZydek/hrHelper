<script>
	import FilePlusOutline from 'svelte-material-icons/FilePlusOutline.svelte';
	import FileDocumentOutline from 'svelte-material-icons/FileDocumentOutline.svelte';
	import CalendarMonth from 'svelte-material-icons/CalendarMonth.svelte';
	import ClockTimeFourOutline from 'svelte-material-icons/ClockTimeFourOutline.svelte';
	import { page } from '$app/state';
	import IconWithNotificationBadge from '../../../components/IconWithNotificationBadge.svelte';
	import { setContext } from 'svelte';

	let path = $derived(page.url.pathname.split('/')[3]);

	let { data } = $props();

	let notificationCounter = $state(0);

	setContext('leave-management', {
		setNotificationCounter: (val) => (notificationCounter = val)
	});
</script>

<div class="w-full h-full flex">
	<div class="flex flex-col gap-2 border py-4 shadow-xl overflow-auto">
		<p class="text-2xl font-semibold text-main-app mb-2 px-4">Nieobecności</p>
		<a
			href="/home/leave-management/new-request"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                  {path === 'new-request' ? 'bg-auxiliary-gray' : ''}"
		>
			<FilePlusOutline size="1.75rem" />
			<span>Nowy wniosek</span>
		</a>
		<a
			href="/home/leave-management/my-requests"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                  {path === 'my-requests' ? 'bg-auxiliary-gray' : ''}"
		>
			<FileDocumentOutline size="1.75rem" />
			<span>Moje wnioski</span>
		</a>
		<a
			href="/home/leave-management/calendar"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                 {path === 'calendar' ? 'bg-auxiliary-gray' : ''}"
		>
			<CalendarMonth size="1.75rem" />
			<span>Kalendarz</span>
		</a>
		<a
			href="/home/leave-management/approvals"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                  {path === 'approvals' ? 'bg-auxiliary-gray' : ''}"
		>
			<IconWithNotificationBadge number={notificationCounter}>
				<ClockTimeFourOutline slot="icon" size="1.75rem" />
			</IconWithNotificationBadge>
			<span>Wnioski do rozpatrzenia</span>
		</a>
	</div>
	<slot />
</div>
