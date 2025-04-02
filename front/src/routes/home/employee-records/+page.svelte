<script>
	import EmployeeList from '../../../components/EmployeeList.svelte';
	import Searchbar from '../../../components/Searchbar.svelte';
	import EmployeeDrawer from '../../../components/EmployeeDrawer.svelte';
	import Plus from 'svelte-material-icons/Plus.svelte';
	import { getSearchbarMappers } from '../../../utils/getSearchbarMappers.js';

	export let data;

	let allUsers = data.users;
	let displayedUsers = allUsers;

	let selectedUser = null;
	const onClick = (user) => {
		selectedUser = user;
		toggleDrawer();
	};

	let showDrawer = false;
	const toggleDrawer = () => {
		if (showDrawer) {
			selectedUser = null;
		}
		showDrawer = !showDrawer;
	};

	const handleFilteredDataChange = (filteredData) => {
		displayedUsers = filteredData;
	};
</script>

<div class="p-8">
	<div class="px-10 flex justify-between">
		<div class="flex items-center gap-8 mb-4 flex-1">
			<p class="font-semibold text-2xl text-main-app">Pracownicy</p>
			<div class="flex-1">
				<Searchbar
					placeholderText="Szukaj pracownika..."
					searchData={allUsers}
					onFilteredDataChange={handleFilteredDataChange}
					searchMapper={getSearchbarMappers('EmployeeList').searchMapper}
					filterableFields={getSearchbarMappers('EmployeeList').filterableFields}
					fieldLabels={getSearchbarMappers('EmployeeList').fieldLabels}
				/>
			</div>
		</div>
		<button
			type="button"
			on:click={toggleDrawer}
			class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4"
		>
			<Plus />
			Dodaj pracownika
		</button>
	</div>
	<EmployeeList users={displayedUsers} {onClick} />
	{#if showDrawer}
		<EmployeeDrawer
			{toggleDrawer}
			user={selectedUser}
			{allUsers}
			groups={data.groups}
			roles={data.roles}
		/>
	{/if}
</div>
