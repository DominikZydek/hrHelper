<script>
	import Magnify from 'svelte-material-icons/Magnify.svelte';
	import Plus from 'svelte-material-icons/Plus.svelte';
	import Close from 'svelte-material-icons/Close.svelte';

	export let placeholderText;
	export let searchData;
	export let onFilteredDataChange;
	export let searchMapper = (item) => item;
	export let filterableFields = [];
	export let fieldLabels = {}; // map field - name

	let searchTerm = '';
	let filterValue = '';
	let activeFilters = [];
	let showFilterMenu = false;
	let selectedField = filterableFields.length > 0 ? filterableFields[0] : null;
	let availableValues = [];
	let selectedFilterValue = '';

	const getFieldLabel = (fieldName) => {
		return fieldLabels[fieldName] || fieldName;
	};

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

	const itemMatchesFilters = (item) => {
		if (activeFilters.length === 0) return true;

		const mappedItem = searchMapper(item);

		return activeFilters.every((filter) => {
			const value = mappedItem[filter.field];

			if (value === null || value === undefined) return false;

			if (Array.isArray(value)) {
				if (filter.isExactMatch) {
					return value.some((v) => v.toString() === filter.value);
				} else {
					return value.some((v) => v.toString().toLowerCase().includes(filter.value.toLowerCase()));
				}
			}

			if (filter.isExactMatch) {
				return value.toString() === filter.value;
			} else {
				return value.toString().toLowerCase().includes(filter.value.toLowerCase());
			}
		});
	};

	const addFilter = () => {
		if (!selectedField) return;

		let newValue;
		let isExactMatch = false;

		if (availableValues.length > 0) {
			newValue = selectedFilterValue;
			isExactMatch = true;
		} else {
			if (!filterValue) return;
			newValue = filterValue;
		}

		activeFilters = [
			...activeFilters,
			{
				field: selectedField,
				value: newValue,
				isExactMatch
			}
		];

		filterValue = '';

		showFilterMenu = false;

		updateFilteredResults();
	};

	const removeFilter = (index) => {
		activeFilters = activeFilters.filter((_, i) => i !== index);
		updateFilteredResults();
	};

	const updateFilteredResults = () => {
		let filtered = searchData;

		if (activeFilters.length > 0) {
			filtered = filtered.filter((item) => itemMatchesFilters(item));
		}

		if (searchTerm) {
			filtered = filtered.filter((item) => searchAllProperties(item, searchTerm));
		}

		onFilteredDataChange(filtered);
	};

	const handleSearch = (e) => {
		e.preventDefault();
	};

	$: if (searchData) {
		updateFilteredResults();
	}

	$: if (searchTerm !== undefined) {
		updateFilteredResults();
	}

	$: if (activeFilters) {
		updateFilteredResults();
	}
</script>

<div class="flex flex-col gap-2">
	<div class="flex gap-5">
		<form class="flex items-center gap-2">
			<input
				class="border h-8 px-2 rounded border-main-gray"
				type="text"
				placeholder={placeholderText}
				bind:value={searchTerm}
			/>
			<button type="submit" on:click|preventDefault={handleSearch}>
				<Magnify class="text-main-gray" size="1.75rem" />
			</button>
			<button
				on:click|preventDefault={() => (showFilterMenu = !showFilterMenu)}
				class="flex gap-1 items-center text-main-app font-semibold h-8 px-4"
			>
				<Plus />
				Dodaj filtr
			</button>
		</form>

		{#if showFilterMenu}
			<form class="flex items-center gap-2">
				<select bind:value={selectedField} class="border h-8 px-2 rounded border-main-gray">
					{#each filterableFields as field}
						<option value={field}>{getFieldLabel(field)}</option>
					{/each}
				</select>

				{#if availableValues.length > 0}
					<select bind:value={selectedFilterValue} class="border h-8 px-2 rounded border-main-gray">
						{#each availableValues as value}
							<option {value}>{value}</option>
						{/each}
					</select>
				{:else}
					<input
						class="border h-8 px-2 rounded border-main-gray"
						type="text"
						placeholder="Wartość filtra..."
						bind:value={filterValue}
					/>
				{/if}

				<button
					on:click|preventDefault={addFilter}
					class="bg-main-app text-white px-3 py-1 rounded"
				>
					Zastosuj
				</button>
			</form>
		{/if}
	</div>

	{#if activeFilters.length > 0}
		<div class="flex flex-wrap gap-2 mt-2">
			{#each activeFilters as filter, index}
				<div class="flex items-center gap-1 bg-gray-200 px-2 py-1 rounded">
					<span class="font-medium">{getFieldLabel(filter.field)}:</span>
					<span>{filter.value}</span>
					<button
						on:click|preventDefault={() => removeFilter(index)}
						class="ml-1 text-gray-600 hover:text-red-500"
					>
						<Close size="1rem" />
					</button>
				</div>
			{/each}
		</div>
	{/if}
</div>
