<script>
	import AccountCircle from 'svelte-material-icons/AccountCircle.svelte';
	import LeaveRequestList from './LeaveRequestList.svelte';
	import CalendarMultiselect from 'svelte-material-icons/CalendarMultiselect.svelte';
	import Searchbar from './Searchbar.svelte';
	export let data;
	export let onLeaveRequestClick;
	export let selectedLeaveRequest;
	export let toggleLeaveDetails;

	let tableRequests = data.leaveRequests;
	let displayedRequests = tableRequests;

	const handleFilteredDataChange = (filteredData) => {
		displayedRequests = filteredData;
	};
</script>

<div class="rounded border shadow col-span-2 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<AccountCircle size="1.5rem" />
		<p class="text-xl font-semibold">Wskaźniki rekrutacyjne ??</p>
	</div>
</div>
<div class="rounded border shadow col-span-2 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<AccountCircle size="1.5rem" />
		<p class="text-xl font-semibold">Analiza wynagrodzeń</p>
	</div>
</div>
<div class="rounded border shadow col-span-2 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<AccountCircle size="1.5rem" />
		<p class="text-xl font-semibold">Informacje o dniach urlopowych pracowników</p>
	</div>
</div>
<div class="rounded border shadow col-span-6 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<CalendarMultiselect size="1.5rem" />
		<p class="text-xl font-semibold">Wnioski urlopowe firmy</p>
		<div class="flex-1 text-main-black">
			<Searchbar
				placeholderText="Szukaj wniosku..."
				searchData={data.leaveRequests}
				onFilteredDataChange={handleFilteredDataChange}
			/>
		</div>
	</div>
	<div>
		<LeaveRequestList
			leaveRequests={displayedRequests}
			onClick={onLeaveRequestClick}
			mode="manage"
			fullHeight={false}
		/>
	</div>
</div>
<div class="rounded border shadow col-span-6 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<AccountCircle size="1.5rem" />
		<p class="text-xl font-semibold">Raporty i analityka HR</p>
	</div>
</div>
