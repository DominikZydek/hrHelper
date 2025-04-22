<script>
	import Searchbar from '../../../../components/Searchbar.svelte';
	import { page } from '$app/state';
	import { icons } from '../../../../stores/icons.js';
	import GroupBadge from '../../../../components/GroupBadge.svelte';

	let { data } = $props();
	let path = $derived(page.url.pathname.split('/')[3]);

	const onClick = () => {};
</script>

<!--<form method="POST" enctype="multipart/form-data">-->
<!--	<input type="file" id="file" name="file" />-->
<!--	<input type="text" id="user" name="user" />-->
<!--	<select name="collection" id="collection">-->
<!--		{#each collectionsWithHierarchy as collection}-->
<!--			{#if collection.children && collection.children.length > 0}-->
<!--				<option value={collection.id}>{collection.display_name || collection.name}</option>-->
<!--				{#each collection.children as childCollection}-->
<!--					<option value={childCollection.id}-->
<!--						>&nbsp;&nbsp;— {childCollection.display_name || childCollection.name}</option-->
<!--					>-->
<!--				{/each}-->
<!--			{:else}-->
<!--				<option value={collection.id}>{collection.display_name || collection.name}</option>-->
<!--			{/if}-->
<!--		{/each}-->
<!--	</select>-->
<!--	<button>SUBMIT</button>-->
<!--</form>-->

<div class="flex-1 p-4">
	<div class="flex items-start gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">
			{data.collections.find((c) => c.name === path).display_name}
		</p>
		<div class="flex-1">
			<Searchbar
				placeholderText="Szukaj dokumentu..."
				searchData={[]}
				onFilteredDataChange={() => {}}
			/>
		</div>
	</div>
	<div class="w-full overflow-auto rounded-lg shadow-xl">
		<table class="w-full text-left border">
			<thead class="sticky top-0 z-10">
				<tr class="bg-blue-100 text-main-gray">
					<th class="px-4 py-3">Nazwa dokumentu</th>
					<th class="px-4 py-3">Pracownik</th>
					<th class="px-4 py-3">Kategoria</th>
					<th class="px-4 py-3">Data dodania</th>
					<th class="px-4 py-3">Data ważności</th>
					<th class="px-4 py-3 text-center">Status</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-main-gray">
				<tr class="cursor-pointer hover:bg-auxiliary-gray">
					<!--						on:click={() => onClick(leaveRequest)}-->
					<!--					>-->
					<td class="px-4 py-3">Umowa o pracę</td>
					<td class="px-4 py-3">
						<div class="flex items-center gap-5">
							<img class="h-16 w-16" src="/favicon.png" alt="" />
							<div class="flex-1">
								<div class="flex gap-5 items-start">
									<div>
										<p>{data.user.first_name} {data.user.last_name}</p>
										<p>{data.user.email}</p>
									</div>
									<div class="text-right">
										<p>{data.user.job_title}</p>
										<div class="flex gap-2 justify-end">
											{#each data.user.groups as group}
												<GroupBadge {group} />
											{/each}
										</div>
									</div>
								</div>
							</div>
						</div>
					</td>
					<td class="px-4 py-3"> Kategoria </td>
					<td class="px-4 py-3">
						{new Date('2024-12-02').toLocaleDateString()}
					</td>
					<td class="px-4 py-3">
						{new Date('2024-12-02').toLocaleDateString()}
					</td>
					<td class="px-4 py-3">
						<div class="flex items-center justify-center">
							<div class="flex gap-2 items-center px-3 py-1 rounded-full text-accent-green">
								<p class="font-semibold">Aktywny</p>
								<svelte:component this={$icons['CheckboxMarkedCircleOutline']} size="1.5rem" />
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
