<script>
	import GroupBadge from '../components/GroupBadge.svelte';
	import AccountCircle from 'svelte-material-icons/AccountCircle.svelte';
	import CalendarMonth from 'svelte-material-icons/CalendarMonth.svelte';
	import CalendarMultiselect from 'svelte-material-icons/CalendarMultiselect.svelte';
	import NewspaperVariantMultiple from 'svelte-material-icons/NewspaperVariantMultipleOutline.svelte';
	import CalendarClock from 'svelte-material-icons/CalendarClock.svelte';
	import { PieChart } from '@carbon/charts-svelte';
	import Eye from 'svelte-material-icons/Eye.svelte';
	import Popup from '../components/Popup.svelte';
	import LeaveRequestDetails from '../components/LeaveRequestDetails.svelte';
	import LeaveRequestList from '../components/LeaveRequestList.svelte';
	import { getUserPTOInfo } from '../utils/getUserPTOInfo.js';
	import Searchbar from './Searchbar.svelte';
	import { getStatusInfo } from '../utils/getStatusInfo.js';
	import { getSearchbarMappers } from '../utils/getSearchbarMappers.js';
	export let onLeaveRequestClick;
	export let selectedLeaveRequest;
	export let toggleLeaveDetails;

	export let data;

	let { usedPtoDays, pendingPtoDays, availablePtoDays } = getUserPTOInfo(data.me);

	let pieData = [
		{
			group: 'Wykorzystane',
			value: usedPtoDays
		},
		{
			group: 'W trakcie rozpatrywania',
			value: pendingPtoDays
		},
		{
			group: 'Dostępne',
			value: availablePtoDays
		}
	];
	let pieOptions = {
		resizable: true,
		legend: {
			alignment: 'center'
		},
		pie: {
			alignment: 'center'
		},
		height: '275px',
		// width: '300px',
		toolbar: false,
		getFillColor: (group) => {
			if (group === 'Wykorzystane') return '#DC2626';
			if (group === 'W trakcie rozpatrywania') return '#EAB308';
			if (group === 'Dostępne') return '#059669';
		}
	};

	const closestApprovedLeave = data.me.leave_requests
		.filter((request) => request.status === 'APPROVED')
		.filter((request) => new Date(request.date_from) >= new Date())
		.sort((a, b) => new Date(a.date_from) - new Date(b.date_from))[0];

	const closestCompanyHoliday = data.me.organization.holidays
		.filter((holiday) => new Date(holiday.date) >= new Date())
		.sort((a, b) => new Date(a.date) - new Date(b.date))[0];

	let tableRequests = data.me.leave_requests;
	let displayedRequests = tableRequests;

	const handleFilteredDataChange = (filteredData) => {
		displayedRequests = filteredData;
	};
</script>

<div class="rounded border shadow col-span-4 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<AccountCircle size="1.5rem" />
		<p class="text-xl font-semibold">Moje dane</p>
		<!-- TODO: maybe calendar?? -->
	</div>
	<table class="text-left w-full">
		<tbody>
			<tr>
				<th class="font-bold text-main-gray w-1/2">IMIĘ</th>
				<td class="font-semibold">{data.me.first_name}</td>
			</tr>
			<tr>
				<th class="font-bold text-main-gray w-1/2">NAZWISKO</th>
				<td class="font-semibold">{data.me.last_name}</td>
			</tr>
			<tr>
				<th class="font-bold text-main-gray w-1/2">STANOWISKO</th>
				<td class="font-semibold">{data.me.job_title}</td>
			</tr>
			<tr>
				<th class="font-bold text-main-gray w-1/2">E-MAIL</th>
				<td class="font-semibold">{data.me.email}</td>
			</tr>
			<tr>
				<th class="font-bold text-main-gray w-1/2">NUMER TELEFONU</th>
				<td class="font-semibold">{data.me.phone_number}</td>
			</tr>
			<tr>
				<th class="font-bold text-main-gray w-1/2">ZESPOŁY</th>
				<td class="w-1/2 text-main-black font-semibold flex gap-2">
					{#each data.me.groups as group}
						<GroupBadge {group} />
					{/each}
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="rounded border shadow col-span-4 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<CalendarClock size="1.5rem" />
		<p class="text-xl font-semibold">Stan dni urlopowych</p>
	</div>
	<div class="flex items-center justify-center">
		<!-- TODO: transferred pto should be added here -->
		<PieChart data={pieData} options={pieOptions} />
	</div>
</div>
<div class="rounded border shadow col-span-4 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<CalendarMonth size="1.5rem" />
		<p class="text-xl font-semibold">Ważne daty</p>
	</div>
	<div class="flex flex-col gap-2">
		{#if data.me.employed_to}
			<div>
				<p class="font-bold text-main-gray">DATA ZAKOŃCZENIA UMOWY</p>
				<p class="font-semibold">{new Date(data.me.employed_to).toLocaleDateString()}</p>
			</div>
		{/if}
		{#if data.me.health_check_expired_by}
			<div>
				<p class="font-bold text-main-gray">DATA WAŻNOŚCI BADAŃ LEKARSKICH</p>
				<p class="font-semibold">
					{new Date(data.me.health_check_expired_by).toLocaleDateString()}
				</p>
			</div>
		{/if}
		{#if data.me.health_and_safety_training_expired_by}
			<div>
				<p class="font-bold text-main-gray">DATA WAŻNOŚCI SZKOLENIA BHP</p>
				<p class="font-semibold">
					{new Date(data.me.health_and_safety_training_expired_by).toLocaleDateString()}
				</p>
			</div>
		{/if}
		<hr />
		{#if closestApprovedLeave}
			<div>
				<p class="font-bold text-main-gray">NAJBLIŻSZY URLOP</p>
				<div class="flex gap-3 items-center">
					<p class="font-semibold">
						{new Date(closestApprovedLeave.date_from).toLocaleDateString()} -
						{new Date(closestApprovedLeave.date_to).toLocaleDateString()} ({closestApprovedLeave.days_count}
						dni)
					</p>
					<button
						on:click={() => toggleLeaveDetails(closestApprovedLeave)}
						class="flex gap-1 items-center text-main-gray"
					>
						<Eye />
						Pokaż szczegóły
					</button>
				</div>
			</div>
		{/if}
		{#if closestCompanyHoliday}
			<div>
				<p class="font-bold text-main-gray">NAJBLIŻSZY WOLNY DZIEŃ</p>
				<p class="font-semibold">
					{new Date(closestCompanyHoliday.date).toLocaleDateString()} ({closestCompanyHoliday.name})
				</p>
			</div>
		{/if}
	</div>
</div>
<div class="rounded border shadow col-span-12 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<CalendarMultiselect size="1.5rem" />
		<p class="text-xl font-semibold">Moje wnioski urlopowe</p>
		<div class="flex-1 text-main-black">
			<Searchbar
				placeholderText="Szukaj wniosku..."
				searchData={data.me.leave_requests}
				onFilteredDataChange={handleFilteredDataChange}
				searchMapper={getSearchbarMappers('LeaveRequestList', 'view').searchMapper}
				filterableFields={getSearchbarMappers('LeaveRequestList', 'view').filterableFields}
				fieldLabels={getSearchbarMappers('LeaveRequestList', 'view').fieldLabels}
			/>
		</div>
	</div>
	<div>
		<LeaveRequestList
			leaveRequests={displayedRequests}
			onClick={onLeaveRequestClick}
			fullHeight={false}
		/>
	</div>
</div>
<div class="rounded border shadow col-span-12 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<NewspaperVariantMultiple size="1.5rem" />
		<p class="text-xl font-semibold">Aktualności</p>
	</div>
</div>
