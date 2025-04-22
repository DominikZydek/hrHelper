<script>
	let { data } = $props();
</script>

<form method="POST" enctype="multipart/form-data">
	<input type="file" id="file" name="file" />
	<input type="text" id="user" name="user" />
	<select name="collection" id="collection">
		{#each data.me.organization.media_collections as collection}
			<option value={collection.id}>{collection.display_name}</option>
		{/each}
	</select>
	<button>SUBMIT</button>
</form>
