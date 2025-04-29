<script>
	import { page } from '$app/state';
	import Folder from 'svelte-material-icons/Folder.svelte';
	import Archive from 'svelte-material-icons/Archive.svelte';

	let path = $derived(page.url.pathname.split('/').slice(3).join('/'));

	let { data } = $props();

	$inspect(data);
</script>

<div class="w-full h-full flex">
	<div class="flex flex-col gap-2 border py-4 shadow-xl overflow-auto">
		<p class="text-2xl font-semibold text-main-app mb-2 px-4">Dokumenty</p>
		<a
			data-sveltekit-reload
			href="/home/employee-documents/all"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
										{path === 'all' ? 'bg-auxiliary-gray' : ''}"
		>
			<Folder size="1.75rem" />
			<span>Wszystkie pliki</span>
		</a>
		{#each data.collections as collection}
			<a
				data-sveltekit-reload
				href="/home/employee-documents/{collection.name}"
				class="pl-10 flex items-center gap-2 pr-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
										{path === collection.name ? 'bg-auxiliary-gray' : ''}"
			>
				<Folder size="1.75rem" />
				<span>{collection.display_name}</span>
			</a>
			{#each collection.children as subcollection}
				<a
					data-sveltekit-reload
					href="/home/employee-documents/{collection.name}/{subcollection.name}"
					class="pl-20 flex items-center gap-2 pr-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
										{path === collection.name + '/' + subcollection.name ? 'bg-auxiliary-gray' : ''}"
				>
					<Folder size="1.75rem" />
					<span>{subcollection.display_name}</span>
				</a>
			{/each}
		{/each}
		<a
			data-sveltekit-reload
			href="/home/employee-documents/archive"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
										{path === 'archive' ? 'bg-auxiliary-gray' : ''}"
		>
			<Archive size="1.75rem" />
			<span>Archiwum</span>
		</a>
	</div>
	<slot />
</div>
