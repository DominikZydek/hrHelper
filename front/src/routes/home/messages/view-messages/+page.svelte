<script>
	import MessageList from '../../../../components/MessageList.svelte';
	import Searchbar from '../../../../components/Searchbar.svelte';

	let { data } = $props();

	let listMessages = data.me.visibleMessages;
	let displayedMessages = $state(listMessages);

	$inspect(displayedMessages);

	const handleFilteredDataChange = (filteredData) => {
		displayedMessages = filteredData;
	};

	const searchMapper = () => {};
</script>

<div class="flex-1 p-4">
	<div class="flex items-center gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Wiadomości</p>
		<div class="flex-1">
			<Searchbar
				placeholderText="Szukaj wiadomości..."
				searchData={data.me.visibleMessages}
				onFilteredDataChange={handleFilteredDataChange}
			/>
		</div>
	</div>

	<MessageList messages={displayedMessages} />
</div>
