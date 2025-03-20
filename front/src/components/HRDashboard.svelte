<script>
	import AccountCircle from 'svelte-material-icons/AccountCircle.svelte';
	import LeaveRequestList from './LeaveRequestList.svelte';
	import CalendarMultiselect from 'svelte-material-icons/CalendarMultiselect.svelte';
	import Searchbar from './Searchbar.svelte';
	import AccountClock from 'svelte-material-icons/AccountClock.svelte';
	import GroupBadge from './GroupBadge.svelte';
	import { MeterChart } from '@carbon/charts-svelte';
	import Eye from 'svelte-material-icons/Eye.svelte';
	import CalendarAccount from 'svelte-material-icons/CalendarAccount.svelte';
	export let data;
	export let onLeaveRequestClick;
	export let selectedLeaveRequest;
	export let toggleLeaveDetails;

	let tableRequests = data.leaveRequests;
	let displayedRequests = tableRequests;

	const handleFilteredDataChange = (filteredData) => {
		displayedRequests = filteredData;
	};

	const absentEmployees = data.absentEmployees.map((emp) => {
		const startDate = new Date(emp.leave_requests[0].date_from);
		const endDate = new Date(emp.leave_requests[0].date_to);
		const today = new Date();

		const totalDays = (endDate - startDate) / (1000 * 60 * 60 * 24) + 1;
		const progress = Math.ceil((today - startDate) / (1000 * 60 * 60 * 24));

		const chartData = [
			{
				group: 'Postęp',
				value: progress
			}
		];

		const chartOptions = {
			height: '12.5px',
			color: {
				scale: {
					Postęp: '#059669'
				}
			},
			meter: {
				proportional: {
					total: totalDays,
					unit: 'dni'
				},
				showLabels: false
			},
			toolbar: false,
			legend: {
				enabled: false,
				visible: false,
				position: 'bottom',
				clickable: false
			}
		};

		return {
			...emp,
			chartData: chartData,
			chartOptions: chartOptions
		};
	});
</script>

<div class="rounded border shadow col-span-7 p-4">
	<div>
		<div class="flex gap-2 items-center text-main-app mb-2">
			<AccountClock size="1.5rem" />
			<p class="text-xl font-semibold">Nieobecni pracownicy</p>
		</div>
		<div class="divide-y divide-main-black">
			{#each absentEmployees as absentEmployee}
				<div class="flex py-2 justify-between">
					<div class="flex items-center gap-5 w-2/3">
						<img class="h-16 w-16" src="/favicon.png" alt="" />
						<div class="flex-1">
							<div class="flex gap-10 items-start">
								<div>
									<p>
										{absentEmployee.first_name}
										{absentEmployee.last_name}
									</p>
									<p>{absentEmployee.email}</p>
								</div>
								<div class="text-right">
									<p>{absentEmployee.job_title}</p>
									<div class="flex gap-2 justify-end">
										{#each absentEmployee.groups as group}
											<GroupBadge {group} />
										{/each}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="flex flex-col gap-2 w-1/3">
						<div class="flex gap-3 items-center">
							<p>{absentEmployee.leave_requests[0].leave_type.name}</p>
							<button
								on:click={() => toggleLeaveDetails(absentEmployee.leave_requests[0])}
								class="flex gap-1 items-center text-main-gray"
							>
								<Eye />
								Pokaż szczegóły
							</button>
						</div>
						<MeterChart data={absentEmployee.chartData} options={absentEmployee.chartOptions} />
						<div class="flex justify-between">
							<p>{new Date(absentEmployee.leave_requests[0].date_from).toLocaleDateString()}</p>
							<p>{new Date(absentEmployee.leave_requests[0].date_to).toLocaleDateString()}</p>
						</div>
					</div>
				</div>
			{/each}
		</div>
	</div>
</div>
<div class="rounded border shadow col-span-5 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<CalendarAccount size="1.5rem" />
		<p class="text-xl font-semibold">Dane pracowników // informacje // ??</p>
	</div>
	<div class="max-h-[30vh] overflow-auto divide-y divide-main-black">
		<!-- TODO: this should be handled in the grid -->
		{#each data.users as employee}
			<div>
				<p>{employee.first_name}</p>
				<p>{employee.last_name}</p>
				<p>{employee.email}</p>
				<p>{employee.job_title}</p>
				<p>{employee.groups}</p>
				<p>{employee.paid_time_off_days}</p>
				<p>{employee.working_time}</p>
				<p>{employee.available_pto}</p>
				<p>{employee.pending_pto}</p>
				<p>{employee.transferred_pto}</p>
				<p>{employee.transferred_pto_expired_by}</p>
				<p>{employee.health_check_expired_by}</p>
				<p>{employee.health_and_safety_training_expired_by}</p>
				<p>{employee.working_to}</p>
				<p>{employee.type_of_employment}</p>
			</div>
		{/each}
	</div>
</div>
<div class="rounded border shadow col-span-12 p-4">
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
<div class="rounded border shadow col-span-12 p-4">
	<div class="flex gap-2 items-center text-main-app mb-2">
		<AccountCircle size="1.5rem" />
		<p class="text-xl font-semibold">Raporty i analityka HR</p>
	</div>
</div>
