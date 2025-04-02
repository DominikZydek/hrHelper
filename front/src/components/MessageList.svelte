<script>
	import GroupBadge from './GroupBadge.svelte';
	import { getMessagePriorityInfo } from '../utils/getMessagePriorityInfo.js';
	import Eye from 'svelte-material-icons/Eye.svelte';

	let { messages } = $props();
	$inspect(messages);
	const convertUTCtoLocalTime = (utcDateTime) => {
		// make sure the date is in ISO format
		let dateStr = utcDateTime;
		if (typeof dateStr === 'string' && !dateStr.endsWith('Z') && !dateStr.includes('+')) {
			dateStr = dateStr + 'Z';
		}

		const date = new Date(dateStr);
		return date;
	};

	const calculateTimeAgo = (dateTime) => {
		const publicationDate = convertUTCtoLocalTime(dateTime);
		const now = new Date();

		const diffMs = now - publicationDate;

		const diffSec = Math.floor(diffMs / 1000);
		const diffMin = Math.floor(diffSec / 60);
		const diffHour = Math.floor(diffMin / 60);
		const diffDay = Math.floor(diffHour / 24);
		const diffMonth = Math.floor(diffDay / 30);
		const diffYear = Math.floor(diffDay / 365);

		if (diffYear > 0) {
			return diffYear === 1 ? '1 rok temu' : `${diffYear} lat${diffYear < 5 ? 'a' : ''} temu`;
		} else if (diffMonth > 0) {
			return diffMonth === 1
				? '1 miesiąc temu'
				: `${diffMonth} miesiąc${diffMonth < 5 && diffMonth !== 1 ? 'e' : diffMonth >= 5 ? 'y' : ''} temu`;
		} else if (diffDay > 0) {
			return diffDay === 1 ? '1 dzień temu' : `${diffDay} dni temu`;
		} else if (diffHour > 0) {
			return diffHour === 1
				? '1 godzinę temu'
				: `${diffHour} godzin${diffHour < 5 && diffHour !== 1 ? 'y' : ''} temu`;
		} else if (diffMin > 0) {
			return diffMin === 1
				? '1 minutę temu'
				: `${diffMin} minut${diffMin < 5 && diffMin !== 1 ? 'y' : ''} temu`;
		} else {
			return 'mniej niż minutę temu';
		}
	};

	const formatLocalDateTime = (dateTime) => {
		const date = convertUTCtoLocalTime(dateTime);

		const options = {
			day: '2-digit',
			month: '2-digit',
			year: 'numeric',
			hour: '2-digit',
			minute: '2-digit',
			hour12: false
		};

		return new Intl.DateTimeFormat('pl-PL', options).format(date).replace(',', ' o');
	};
</script>

<ul class="px-10 py-5 flex flex-col gap-5">
	{#each messages as message}
		<li class="p-6 border rounded-xl shadow">
			<div class="flex mb-4">
				<div class="flex items-center gap-5 flex-1">
					<img class="h-16 w-16 flex-shrink-0" src="/favicon.png" alt="" />
					<div class="flex-1">
						<div class="flex w-full">
							<div class="min-w-48 w-auto">
								<p>{message.author.first_name} {message.author.last_name}</p>
								<p>{message.author.email}</p>
							</div>
							<div class="ml-10 flex-1">
								<p>{message.author.job_title}</p>
								<div class="flex gap-2">
									{#each message.author.groups as group}
										<GroupBadge {group} />
									{/each}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="flex items-start gap-2">
					<GroupBadge group={{ name: message.category.name }} />
					<GroupBadge
						group={{ name: getMessagePriorityInfo(message.priority).message }}
						colorClass={getMessagePriorityInfo(message.priority).colorClass}
					/>
				</div>
			</div>
			<div>
				<p class="text-xl font-bold">{message.subject}</p>
				<p class="font-light text-main-gray text-sm mb-4">
					Wysłano: {formatLocalDateTime(message.publication_date)}
					({calculateTimeAgo(message.publication_date)})
				</p>
				<p class="whitespace-pre-wrap text-lg">{message.content}</p>
				{#if message.require_confirmation}
					<form action="?/markMessageAsSeen" method="POST">
						<input type="hidden" id="message" name="message" value={message.id} />
						<button
							type="submit"
							class="flex gap-1 items-center font-semibold h-8 self-end mt-5
            {message.seen
								? 'bg-main-white text-main-gray'
								: 'px-4 bg-accent-green text-main-white'}"
							disabled={message.seen}
						>
							<Eye />
							{#if !message.seen}
								Potwierdź odczytanie
							{:else}
								Odczytano
							{/if}
						</button>
					</form>
				{/if}
			</div>
		</li>
	{/each}
</ul>
