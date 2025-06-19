<script>
	import UserDashboard from '../../components/UserDashboard.svelte';
	import HRDashboard from '../../components/HRDashboard.svelte';
	import Popup from '../../components/Popup.svelte';
	import LeaveRequestDetails from '../../components/LeaveRequestDetails.svelte';
	import Logout from 'svelte-material-icons/Logout.svelte';
	import Avatar from '../../components/Avatar.svelte';

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
			<Avatar fullName={data.me.first_name + ' ' + data.me.last_name} />
			<p>{data.me.first_name} {data.me.last_name}</p>

			<form action="?/logout" method="POST">
				<button
					type="submit"
					class="flex gap-1 items-center text-main-app font-semibold h-8 px-4 text-lg"
				>
					<Logout />
					Wyloguj się
				</button>
			</form>
		</div>

		{#if data.me.roles && data.me.roles.some((role) => role.name === 'hr')}
			<div class="flex border shadow rounded text-lg">
				<button
					on:click={() => changeMode('user')}
					class="p-2 rounded-l border {mode === 'user' ? 'bg-main-app text-main-white' : ''}"
				>
					User</button
				>
				<button
					on:click={() => changeMode('hr')}
					class="p-2 rounded-r border {mode === 'hr' ? 'bg-main-app text-main-white' : ''}"
				>
					HR</button
				>
			</div>
		{/if}
	</div>

	<!-- MAIN SECTION -->
	<div class="mt-5 grid grid-cols-12 grid-auto-rows gap-5">
		{#if mode === 'user'}
			<UserDashboard {data} {selectedLeaveRequest} {toggleLeaveDetails} {onLeaveRequestClick} />
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
