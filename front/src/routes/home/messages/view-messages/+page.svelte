<script>
	import MessageList from '../../../../components/MessageList.svelte';
	import Searchbar from '../../../../components/Searchbar.svelte';
	import { getMessagePriorityInfo } from '../../../../utils/getMessagePriorityInfo.js';
	import { getSearchbarMappers } from '../../../../utils/getSearchbarMappers.js';
	import { onMount } from 'svelte';

	let { data } = $props();
	let isReady = $state(false);

	let listMessages = data.me.visibleMessages;
	let displayedMessages = $state(listMessages);

	$inspect(displayedMessages);

	const handleFilteredDataChange = (filteredData) => {
		displayedMessages = filteredData;
	};

	onMount(() => {
		const params = new URLSearchParams(document.location.search);
		const id = params.get('id');

		// if redirected via notification
		if (id) {
			displayedMessages = [data.me.visibleMessages.find((m) => m.id === id)].filter(Boolean);
		}

		isReady = true;
	});
</script>

<div class="flex-1 p-4 overflow-auto">
	<div class="flex items-start gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Wiadomości</p>
		<div class="flex-1">
			<Searchbar
				placeholderText="Szukaj wiadomości..."
				searchData={data.me.visibleMessages}
				onFilteredDataChange={handleFilteredDataChange}
				searchMapper={getSearchbarMappers('MessageList').searchMapper}
				filterableFields={getSearchbarMappers('MessageList').filterableFields}
				fieldLabels={getSearchbarMappers('MessageList').fieldLabels}
			/>
		</div>
	</div>

	{#if isReady}
		<MessageList messages={displayedMessages} />
	{:else}
		<!-- TODO: loading component -->
	{/if}
</div>
