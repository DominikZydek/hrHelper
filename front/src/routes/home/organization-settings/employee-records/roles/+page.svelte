<script>
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import AccountGroup from 'svelte-material-icons/AccountGroup.svelte';
	import Popup from '../../../../../components/Popup.svelte';
	import Check from 'svelte-material-icons/Check.svelte';

	let { data } = $props();

	let showEditRoleModal = $state(false);
	const toggleEditRoleModal = () => {
		showEditRoleModal = !showEditRoleModal;
	};
	const handleEditRoleClick = (role) => {
		selectedRole = role;
		toggleEditRoleModal();
	};

	let showGrantRolesModal = $state(false);
	const toggleGrantRolesModal = () => {
		showGrantRolesModal = !showGrantRolesModal;
	};
	const handleGrantRolesClick = (role) => {
		selectedRole = role;
		toggleGrantRolesModal();
	};

	let selectedRole = $state(null);
	$inspect(selectedRole);
</script>

<div class="p-8">
	<div class="px-10 flex justify-between">
		<div class="flex items-start gap-8 mb-4 flex-1">
			<p class="font-semibold text-2xl text-main-app">Ustawienia ról/uprawnień</p>
			<div class="flex-1"></div>
		</div>
	</div>
	<div class="flex gap-5 flex-wrap justify-center px-10">
		{#each data.roles as role}
			<div class="p-6 border rounded-xl shadow">
				<div class="flex gap-5 items-center">
					<div>
						<div class="flex justify-between gap-5">
							<p class="font-bold text-main-app">{role.display_name}</p>
							<div>
								<button title="Edytuj rolę" onclick={() => handleEditRoleClick(role)}>
									<Pencil class="text-main-gray" size="1.25rem" />
								</button>
								<button
									title="Nadaj/usuń rolę"
									onclick={() => {
										handleGrantRolesClick(role);
									}}
								>
									<AccountGroup class="text-main-gray" size="1.25rem" />
								</button>
							</div>
						</div>
						<p class="text-main-gray">{role.users.length} pracowników</p>
					</div>
				</div>
			</div>
		{/each}
	</div>
</div>

{#if showEditRoleModal}
	<Popup title="Edytuj rolę - {selectedRole.display_name}" togglePopup={toggleEditRoleModal}>
		<form action="?/editRole" method="POST" class="flex flex-col w-[33.333vw]">
			<input type="hidden" id="role" name="role" value={selectedRole.id} />

			<p class="font-semibold mb-2">Lista uprawnień:</p>
			{#each data.permissions as permission}
				{@const granted = selectedRole.permissions.some((p) => p.id === permission.id)}
				<div class="flex gap-5">
					<input
						id="permission-{permission.id}"
						name="permission-{permission.id}"
						type="checkbox"
						checked={granted}
					/>
					<label for="permission-{permission.id}">{permission.display_name}</label>
				</div>
			{/each}
			<button
				type="submit"
				class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4 self-end mt-5"
			>
				<Check />
				Zatwierdź zmiany
			</button>
		</form>
	</Popup>
{/if}

{#if showGrantRolesModal}
	<Popup
		title="Nadaj/usuń rolę - {selectedRole.display_name}"
		togglePopup={toggleGrantRolesModal}
	></Popup>
{/if}
