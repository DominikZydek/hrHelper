<script>
	import UserDashboard from '../../components/UserDashboard.svelte';
	import ManagerDashboard from '../../components/ManagerDashboard.svelte';
	import HRDashboard from '../../components/HRDashboard.svelte';
	import Popup from '../../components/Popup.svelte';
	import LeaveRequestDetails from '../../components/LeaveRequestDetails.svelte';

	export let data;

	let mode = 'user';
	const changeMode = (newMode) => {
		mode = newMode;
	};

	let selectedLeaveRequest = null;
	const toggleLeaveDetails = (leaveRequest) => {
		selectedLeaveRequest ? (selectedLeaveRequest = null) : (selectedLeaveRequest = leaveRequest);
	};

	const onLeaveRequestClick = (leaveRequest) => {
		selectedLeaveRequest = leaveRequest;
	};
</script>

<div class="p-8">
	<div class="flex justify-between">
		<div class="flex gap-1 items-center text-3xl">
			<p>Witaj,</p>
			<img class="h-10 w-10" src="/favicon.png" alt="" />
			<p>{data.me.first_name} {data.me.last_name}</p>
		</div>
		<div class="flex border shadow rounded text-lg">
			<button
				on:click={() => changeMode('user')}
				class="p-2 rounded-l border {mode === 'user' ? 'bg-main-app text-main-white' : ''}"
			>
				User</button
			>
			<button
				on:click={() => changeMode('manager')}
				class="p-2 border {mode === 'manager' ? 'bg-main-app text-main-white' : ''}"
			>
				Manager</button
			>
			<button
				on:click={() => changeMode('hr')}
				class="p-2 rounded-r border {mode === 'hr' ? 'bg-main-app text-main-white' : ''}"
			>
				HR</button
			>
		</div>
	</div>

	<!-- MAIN SECTION -->
	<div class="mt-5 grid grid-cols-12 grid-auto-rows gap-5">
		{#if mode === 'user'}
			<UserDashboard {data} {selectedLeaveRequest} {toggleLeaveDetails} {onLeaveRequestClick} />
		{/if}

		{#if mode === 'manager'}
			<ManagerDashboard {data} />
		{/if}

		{#if mode === 'hr'}
			<HRDashboard {data} {selectedLeaveRequest} {toggleLeaveDetails} {onLeaveRequestClick} />
		{/if}
	</div>
</div>

{#if selectedLeaveRequest}
	<Popup togglePopup={toggleLeaveDetails} title="Szczegóły wniosku">
		<LeaveRequestDetails
			leaveRequest={selectedLeaveRequest}
			user={selectedLeaveRequest.user || data.user}
		/>
	</Popup>
{/if}
