<script>
	import { onMount } from 'svelte';

	let { data } = $props();

	let collections = data.me.organization.media_collections;

	let collectionsWithHierarchy = $state([]);

	onMount(() => {
		const parentMap = {};

		collections.forEach((c) => {
			if (!c.name.includes('/')) {
				const collectionObj = { ...c, children: [] };
				collectionsWithHierarchy.push(collectionObj);
				parentMap[c.name] = collectionObj;
			}
		});

		collections.forEach((c) => {
			if (c.name.includes('/')) {
				const parts = c.name.split('/');
				const parentName = parts[0];
				const childName = parts[1];

				const parent = parentMap[parentName];

				if (parent) {
					parent.children.push({
						...c,
						name: childName
					});
				} else {
					const newParent = {
						name: parentName,
						children: [
							{
								...c,
								name: childName
							}
						]
					};
					collectionsWithHierarchy.push(newParent);
					parentMap[parentName] = newParent;
				}
			}
		});
	});
</script>

<form method="POST" enctype="multipart/form-data">
	<input type="file" id="file" name="file" />
	<input type="text" id="user" name="user" />
	<select name="collection" id="collection">
		{#each collectionsWithHierarchy as collection}
			{#if collection.children && collection.children.length > 0}
				<option value={collection.id}>{collection.display_name || collection.name}</option>
				{#each collection.children as childCollection}
					<option value={childCollection.id}
						>&nbsp;&nbsp;— {childCollection.display_name || childCollection.name}</option
					>
				{/each}
			{:else}
				<option value={collection.id}>{collection.display_name || collection.name}</option>
			{/if}
		{/each}
	</select>
	<button>SUBMIT</button>
</form>
