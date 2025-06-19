<script>
	import Circle from 'svelte-material-icons/Circle.svelte';
	import DotsVertical from 'svelte-material-icons/DotsVertical.svelte';
	import Check from 'svelte-material-icons/Check.svelte';
	import CircleOutline from 'svelte-material-icons/CircleOutline.svelte';
	import GroupBadge from './GroupBadge.svelte';
	import Avatar from './Avatar.svelte';
	export let user;
</script>

<div class="flex flex-col w-full">
	<!-- first step -->
	<div class="flex items-center">
		<div class="flex items-center justify-center w-16">
			<Circle class="text-main-black" size="2rem" />
		</div>
		<div class="flex items-center gap-5 flex-1">
			<Avatar fullName="{user.first_name} {user.last_name}" variant="large" />
			<div class="flex-1">
				<div class="flex justify-between items-start">
					<div>
						<p>{user.first_name} {user.last_name}</p>
						<p>{user.email}</p>
					</div>
					<div class="text-right">
						<p>{user.job_title}</p>
						<div class="flex gap-2 justify-end">
							{#each user.groups as group}
								<GroupBadge {group} />
							{/each}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- separator -->
	<div class="flex py-2">
		<div class="flex items-center justify-center w-16">
			<DotsVertical class="text-main-black" size="2rem" />
		</div>
		<div class="flex-1"></div>
	</div>

	<!-- middle steps -->
	{#each user.approval_process.steps.slice(0, -1) as step, index}
		<div class="flex items-center">
			<div class="flex items-center justify-center w-16">
				<CircleOutline class="text-main-black" size="2rem" />
			</div>
			<div class="flex items-center gap-5 flex-1">
				<Avatar fullName="{step.approver.first_name} {step.approver.last_name}" variant="large" />
				<div class="flex-1">
					<div class="flex justify-between items-start">
						<div>
							<p>{step.approver.first_name} {step.approver.last_name}</p>
							<p>{step.approver.email}</p>
						</div>
						<div class="text-right">
							<p>{step.approver.job_title}</p>
							<div class="flex gap-2 justify-end">
								{#each step.approver.groups as group}
									<GroupBadge {group} />
								{/each}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- separator -->
		<div class="flex py-2">
			<div class="flex items-center justify-center w-16">
				<DotsVertical class="text-main-black" size="2rem" />
			</div>
			<div class="flex-1"></div>
		</div>
	{/each}

	<!-- last step -->
	{#if user.approval_process.steps.length > 0}
		<div class="flex items-center">
			<div class="flex items-center justify-center w-16">
				<Check class="text-main-black" size="2rem" />
			</div>
			<div class="flex items-center gap-5 flex-1">
				<Avatar
					fullName="{user.approval_process.steps[user.approval_process.steps.length - 1].approver
						.first_name} {user.approval_process.steps[user.approval_process.steps.length - 1]
						.approver.last_name}"
					variant="large"
				/>
				<div class="flex-1">
					<div class="flex justify-between items-start">
						<div>
							<p>
								{user.approval_process.steps[user.approval_process.steps.length - 1].approver
									.first_name}
								{user.approval_process.steps[user.approval_process.steps.length - 1].approver
									.last_name}
							</p>
							<p>
								{user.approval_process.steps[user.approval_process.steps.length - 1].approver.email}
							</p>
						</div>
						<div class="text-right">
							<p>
								{user.approval_process.steps[user.approval_process.steps.length - 1].approver
									.job_title}
							</p>
							<div class="flex gap-2 justify-end">
								{#each user.approval_process.steps[user.approval_process.steps.length - 1].approver.groups as group}
									<GroupBadge {group} />
								{/each}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	{/if}
</div>
