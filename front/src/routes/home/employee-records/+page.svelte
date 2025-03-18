<script>
	import EmployeeList from '../../../components/EmployeeList.svelte';
	import Searchbar from '../../../components/Searchbar.svelte';
	import EmployeeDrawer from '../../../components/EmployeeDrawer.svelte';

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
		showDrawer = !showDrawer;
	};

	const handleFilteredDataChange = (filteredData) => {
		displayedUsers = filteredData;
	};
</script>

<div class="p-8">
	<div class="px-10">
		<Searchbar
			placeholderText="Szukaj pracownika..."
			searchData={allUsers}
			onFilteredDataChange={handleFilteredDataChange}
		/>
	</div>
	<EmployeeList users={displayedUsers} {onClick} />
	{#if selectedUser}
		{#if showDrawer}
			<EmployeeDrawer
				{toggleDrawer}
				user={selectedUser}
				{allUsers}
				groups={data.groups}
				roles={data.roles}
			/>
		{/if}
	{/if}
</div>
