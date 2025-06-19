<script>
	import GroupBadge from './GroupBadge.svelte';
	import Avatar from './Avatar.svelte';

	export let users;
	export let onClick;
</script>

<ul class="flex flex-col divide-y divide-main-gray">
	{#each users as user}
		<li class="flex mx-10 py-6 items-center cursor-pointer" on:click={() => onClick(user)}>
			<div class="flex items-center gap-5 w-1/2">
				<Avatar fullName="{user.first_name} {user.last_name}" variant="large" />
				<div>
					<p>{user.first_name} {user.last_name}</p>
					<p>{user.email}</p>
				</div>
			</div>
			<div class="w-1/2">
				<p>{user.job_title}</p>
				<div class="flex gap-2">
					{#each user.groups as group}
						<GroupBadge {group} />
					{/each}
				</div>
				<p>W firmie od: {new Date(user.employed_from).toLocaleDateString()}</p>
			</div>
		</li>
	{/each}
</ul>
