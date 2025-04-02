<script>
	import MessageList from '../../../../components/MessageList.svelte';
	import Searchbar from '../../../../components/Searchbar.svelte';
	import { getMessagePriorityInfo } from '../../../../utils/getMessagePriorityInfo.js';
	import { getSearchbarMappers } from '../../../../utils/getSearchbarMappers.js';

	let { data } = $props();

	let listMessages = data.me.visibleMessages;
	let displayedMessages = $state(listMessages);

	$inspect(displayedMessages);

	const handleFilteredDataChange = (filteredData) => {
		displayedMessages = filteredData;
	};
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

	<MessageList messages={displayedMessages} />
</div>
