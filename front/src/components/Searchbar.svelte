<script>
	import Magnify from 'svelte-material-icons/Magnify.svelte';
	import Plus from 'svelte-material-icons/Plus.svelte';
	export let placeholderText;
	export let searchData;
	export let onFilteredDataChange;
	export let searchMapper = (item) => item;

	let searchTerm = '';
	let filteredData = searchData;

	const searchAllProperties = (item, term) => {
		const mappedItem = searchMapper(item);

		return Object.values(mappedItem).some((value) => {
			if (value === null || value === undefined) return false;
			if (Array.isArray(value)) {
				return value.some((v) => v.toString().toLowerCase().includes(term.toLowerCase()));
			}
			const stringValue = value.toString().toLowerCase();
			return stringValue.includes(term.toLowerCase());
		});
	};
	const handleSearch = (e) => {
		e.preventDefault();
		const filtered = searchTerm
			? searchData.filter((item) => searchAllProperties(item, searchTerm))
			: searchData;
		onFilteredDataChange(filtered);
	};

	$: {
		const filtered = searchTerm
			? searchData.filter((item) => searchAllProperties(item, searchTerm))
			: searchData;
		onFilteredDataChange(filtered);
	}
</script>

<!-- TODO: add mappers to all usages -->
<form class="flex items-center gap-2">
	<input
		class="w-1/4 border h-8 px-2 rounded border-main-gray"
		type="text"
		placeholder={placeholderText}
		bind:value={searchTerm}
	/>
	<button type="submit">
		<Magnify class="text-main-gray" size="1.75rem" />
	</button>
	<button class="flex gap-1 items-center text-main-app font-semibold h-8 px-4">
		<Plus class="" />
		Dodaj filtr
	</button>
	<!-- TODO: applied filters rendered here -->
</form>
