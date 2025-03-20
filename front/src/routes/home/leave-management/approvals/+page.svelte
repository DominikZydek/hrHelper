<script>
	import { getStatusInfo } from '../../../../utils/getStatusInfo.js';
	import GroupBadge from '../../../../components/GroupBadge.svelte';
	import Searchbar from '../../../../components/Searchbar.svelte';
	import { icons } from '../../../../stores/icons.js';
	import { getContext } from 'svelte';
	import LeaveRequestList from '../../../../components/LeaveRequestList.svelte';

	export let data;

	let { onClick } = getContext('leave-management');

	let tableRequests = data.leaveRequestsAwaitingApproval;
	let displayedRequests = tableRequests;

	const handleFilteredDataChange = (filteredData) => {
		displayedRequests = filteredData;
	};
</script>

<div class="flex-1 p-4">
	<div class="flex items-center gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Wnioski do rozpatrzenia</p>
		<div class="flex-1">
			<Searchbar
				placeholderText="Szukaj wniosku..."
				searchData={data.leaveRequestsAwaitingApproval}
				onFilteredDataChange={handleFilteredDataChange}
			/>
		</div>
	</div>

	<LeaveRequestList leaveRequests={displayedRequests} {onClick} mode="manage" />
</div>
