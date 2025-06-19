<script>
	import GroupBadge from './GroupBadge.svelte';
	import { getMessagePriorityInfo } from '../utils/getMessagePriorityInfo.js';
	import Eye from 'svelte-material-icons/Eye.svelte';
	import { formatLocalDateTime, calculateTimeAgo } from '../utils/timeCalculation.js';
	import Avatar from './Avatar.svelte';

	let { messages } = $props();
	$inspect(messages);
</script>

<ul class="px-10 py-5 flex flex-col gap-5">
	{#each messages as message}
		<li class="p-6 border rounded-xl shadow">
			<div class="flex mb-4">
				<div class="flex items-center gap-5 flex-1">
					<Avatar
						fullName="{message.author.first_name} {message.author.last_name}"
						variant="large"
					/>
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
