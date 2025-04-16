<script>
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import AccountGroup from 'svelte-material-icons/AccountGroup.svelte';
	import Popup from '../../../../../components/Popup.svelte';
	import Check from 'svelte-material-icons/Check.svelte';
	import MultiSelect from '../../../../../components/MultiSelect.svelte';

	let { data } = $props();

	let showEditRoleModal = $state(false);
	const toggleEditRoleModal = () => {
		showEditRoleModal = !showEditRoleModal;
	};
	const handleEditRoleClick = (role) => {
		selectedRole = role;
		toggleEditRoleModal();
	};

	let showGrantRoleModal = $state(false);
	const toggleGrantRoleModal = () => {
		showGrantRoleModal = !showGrantRoleModal;
	};

	let showErrorPopup = $state(false);
	const toggleErrorPopup = () => {
		showErrorPopup = !showErrorPopup;
	};
	const handleGrantRolesClick = (role) => {
		selectedRole = role;

		if (role.name === 'employee') {
			toggleErrorPopup();
			return;
		}

		selectedUsers = data.users.filter((u) =>
			selectedRole.users.some((roleUser) => roleUser.id === u.id)
		);
		toggleGrantRoleModal();
	};

	let selectedRole = $state(null);

	let selectedUsers = $state([]);

	const onUserSelectChange = (values) => {
		selectedUsers = data.users.filter((user) => values.includes(user.id));
	};
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

{#if showGrantRoleModal}
	<Popup title="Nadaj/usuń rolę - {selectedRole.display_name}" togglePopup={toggleGrantRoleModal}>
		<form action="?/grantRole" method="POST" class="flex flex-col w-[33.333vw]">
			<input type="hidden" id="role" name="role" value={selectedRole?.id} />
			<input
				type="hidden"
				id="selected_users"
				name="selected_users"
				value={JSON.stringify(selectedUsers?.map((g) => g.id))}
			/>

			<label for="users">Pracownicy z rolą {selectedRole.display_name}</label>
			<MultiSelect
				options={data.users.map((user) => ({
					value: user.id,
					name: user.first_name + ' ' + user.last_name,
					icon_name: 'Account'
				}))}
				selected={selectedUsers?.map((u) => u.id)}
				name="users"
				id="users"
				placeholder="Wybierz pracowników"
				onChange={onUserSelectChange}
			/>
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

{#if showErrorPopup}
	<Popup title="Ostrzeżenie" togglePopup={toggleErrorPopup}>
		<p>Roli Pracownik nie można nadać/usunąć!</p>
	</Popup>
{/if}
