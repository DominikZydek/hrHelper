<script>
	import AccountGroup from 'svelte-material-icons/AccountGroup.svelte';
	import FileDocumentMultiple from 'svelte-material-icons/FileDocumentMultiple.svelte';
	import CalendarMultiselect from 'svelte-material-icons/CalendarMultiselect.svelte';
	import AccountMultiplePlus from 'svelte-material-icons/AccountMultiplePlus.svelte';
	import NewspaperVariantMultiple from 'svelte-material-icons/NewspaperVariantMultiple.svelte';
	import Tune from 'svelte-material-icons/Tune.svelte';
	import { page } from '$app/state';
	import NotificationCenter from '../../components/NotificationCenter.svelte';
	import NotificationPanel from '../../components/NotificationPanel.svelte';

	// current path
	let path = $derived(page.url.pathname.split('/')[2]);
	let { data } = $props();

	let showPanel = $state(false);
	const togglePanel = () => {
		showPanel = !showPanel;
	};
</script>

<div class="h-screen">
	<nav class="fixed h-full w-20 bg-main-app flex flex-col items-center py-5">
		<a class="mb-5" href="/home"><img class="h-10 w-10" src="/favicon.png" alt="logo" /></a>

		<div
			class="px-4 py-6 w-full relative {path === 'organization-settings'
				? 'bg-auxiliary-darkblue'
				: ''}"
		>
			<a
				class="flex flex-col items-center justify-center h-8 group"
				href="/home/organization-settings"
			>
				<Tune
					class="text-main-white absolute group-hover:-translate-y-4 transition-transform"
					size="2rem"
				/>
				<p
					class="text-white text-xs absolute translate-y-4 opacity-0 group-hover:opacity-100 transition-opacity text-center"
				>
					Ustawienia organizacji
				</p>
			</a>
		</div>

		<ul class="flex flex-col items-center justify-end h-full w-full">
			<li
				class="px-4 py-6 w-full relative {path === 'employee-records'
					? 'bg-auxiliary-darkblue'
					: ''}"
			>
				<a
					class="flex flex-col items-center justify-center h-8 group"
					href="/home/employee-records"
				>
					<AccountGroup
						class="text-main-white absolute group-hover:-translate-y-3 transition-transform"
						size="2rem"
					/>
					<p
						class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity"
					>
						Pracownicy
					</p>
				</a>
			</li>
			<!-- employee records -->
			<li
				class="px-4 py-6 w-full relative {path === 'employee-documents'
					? 'bg-auxiliary-darkblue'
					: ''}"
			>
				<a
					class="flex flex-col items-center justify-center h-8 group"
					href="/home/employee-documents/all"
				>
					<FileDocumentMultiple
						class="text-main-white absolute group-hover:-translate-y-3 transition-transform"
						size="2rem"
					/>
					<p
						class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity"
					>
						Dokumenty
					</p>
				</a>
			</li>
			<!-- employee documents -->
			<li
				class="px-4 py-6 w-full relative {path === 'leave-management'
					? 'bg-auxiliary-darkblue'
					: ''}"
			>
				<a
					class="flex flex-col items-center justify-center h-8 group"
					href="/home/leave-management/my-requests"
				>
					<CalendarMultiselect
						class="text-main-white absolute group-hover:-translate-y-3 transition-transform"
						size="2rem"
					/>
					<p
						class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity"
					>
						Nieobecności
					</p>
				</a>
			</li>
			<!-- leave management -->
			<li class="px-4 py-6 w-full relative {path === 'recruitment' ? 'bg-auxiliary-darkblue' : ''}">
				<a class="flex flex-col items-center justify-center h-8 group" href="/home/recruitment">
					<AccountMultiplePlus
						class="text-main-white absolute group-hover:-translate-y-3 transition-transform"
						size="2rem"
					/>
					<p
						class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity"
					>
						Rekrutacje
					</p>
				</a>
			</li>
			<!-- recruitment -->
			<li class="px-4 py-6 w-full relative {path === 'messages' ? 'bg-auxiliary-darkblue' : ''}">
				<a
					class="flex flex-col items-center justify-center h-8 group"
					href="/home/messages/view-messages"
				>
					<NewspaperVariantMultiple
						class="text-main-white absolute group-hover:-translate-y-3 transition-transform"
						size="2rem"
					/>
					<p
						class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity"
					>
						Wiadomości
					</p>
				</a>
			</li>
			<!-- messages -->
			<li class="px-4 py-6 w-full relative mt-6">
				<div class="flex flex-col items-center justify-center h-8 group cursor-pointer">
					<div class="text-main-white absolute group-hover:-translate-y-3 transition-transform">
						<NotificationCenter user={data.user} {togglePanel} />
					</div>
					<p
						class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity"
					>
						Powiadomienia
					</p>
				</div>
			</li>
		</ul>
	</nav>

	{#if showPanel}
		<NotificationPanel {togglePanel} />
	{/if}

	<div class="ml-20 relative h-full">
		<slot />
	</div>
</div>
