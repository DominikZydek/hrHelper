<script>
	import MessageList from '../../../../components/MessageList.svelte';
	import Searchbar from '../../../../components/Searchbar.svelte';
	import { getMessagePriorityInfo } from '../../../../utils/getMessagePriorityInfo.js';

	let { data } = $props();

	let listMessages = data.me.visibleMessages;
	let displayedMessages = $state(listMessages);

	$inspect(displayedMessages);

	const handleFilteredDataChange = (filteredData) => {
		displayedMessages = filteredData;
	};

	const searchMapper = (message) => {
		let groups = [];

		message.author.groups.forEach((g) => {
			groups.push(g.name);
		});

		return {
			first_name: message.author.first_name,
			last_name: message.author.last_name,
			full_name: message.author.first_name + ' ' + message.author.last_name,
			email: message.author.email,
			job_title: message.author.job_title,
			groups: groups,
			category: message.category.name,
			priority: getMessagePriorityInfo(message.priority).message,
			subject: message.subject,
			publication_date_locale_date: new Date(message.publication_date).toLocaleDateString(),
			publication_date_locale_time: new Date(message.publication_date).toLocaleTimeString()
		};
	};
</script>

<div class="flex-1 p-4 overflow-auto">
	<div class="flex items-center gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Wiadomości</p>
		<div class="flex-1">
			<Searchbar
				placeholderText="Szukaj wiadomości..."
				searchData={data.me.visibleMessages}
				onFilteredDataChange={handleFilteredDataChange}
				{searchMapper}
			/>
		</div>
	</div>

	<MessageList messages={displayedMessages} />
</div>
