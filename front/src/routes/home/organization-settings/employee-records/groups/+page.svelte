<script>
	import Plus from 'svelte-material-icons/Plus.svelte';
	import { icons } from '../../../../../stores/icons.js';
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import Close from 'svelte-material-icons/Close.svelte';
	import Popup from '../../../../../components/Popup.svelte';
	import MultiSelect from '../../../../../components/MultiSelect.svelte';
	import Dropdown from '../../../../../components/Dropdown.svelte';
	import Check from 'svelte-material-icons/Check.svelte';

	let { data } = $props();

	let showNewGroupPopup = $state(false);
	const toggleNewGroupPopup = () => {
		selectedUsers = null;
		selectedGroup = null;
		selectedIcon = null;

		showNewGroupPopup = !showNewGroupPopup;
	};

	let showEditGroupPopup = $state(false);
	const toggleEditGroupPopup = () => {
		showEditGroupPopup = !showEditGroupPopup;
	};

	let showRemoveGroupPopup = $state(false);
	const toggleRemoveGroupPopup = () => {
		showRemoveGroupPopup = !showRemoveGroupPopup;
	};

	let selectedGroup = $state(null);
	let selectedUsers = $state([]);

	const onUserSelectChange = (values) => {
		selectedUsers = data.users.filter((user) => values.includes(user.id));
	};

	const handleEditGroupClick = (group) => {
		selectedGroup = group;
		selectedUsers = data.users.filter((u) =>
			selectedGroup.users.some((groupUser) => groupUser.id === u.id)
		);
		selectedIcon = group.icon_name;
		toggleEditGroupPopup();
	};

	const handleRemoveGroupClick = (group) => {
		selectedGroup = group;
		data.users.filter((u) => selectedGroup.users.some((groupUser) => groupUser.id === u.id));
		toggleRemoveGroupPopup();
	};

	let showIconSelect = $state(false);
	const toggleIconSelect = () => {
		showIconSelect = !showIconSelect;
	};

	let iconSelectTrigger = $state(null);

	let selectedIcon = $state(null);
	const handleIconSelect = (iconName) => {
		selectedIcon = iconName;
		toggleIconSelect();
	};
</script>

<div class="p-8">
	<div class="px-10 flex justify-between">
		<div class="flex items-start gap-8 mb-4 flex-1">
			<p class="font-semibold text-2xl text-main-app">Ustawienia zespołów</p>
			<div class="flex-1"></div>
		</div>
		<button
			type="button"
			onclick={toggleNewGroupPopup}
			class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4"
		>
			<Plus />
			Dodaj zespół
		</button>
	</div>
	<div class="flex gap-5 flex-wrap justify-center px-10">
		{#each data.groups as group}
			<div class="p-6 border rounded-xl shadow">
				<div class="flex gap-5 items-center">
					<svelte:component this={$icons[group.icon_name]} size="2.5rem" class="text-main-app" />
					<div>
						<div class="flex justify-between gap-5">
							<p class="font-bold text-main-app">{group.name}</p>
							<div>
								<button title="Edytuj zespół" onclick={() => handleEditGroupClick(group)}>
									<Pencil class="text-accent-orange" size="1.25rem" />
								</button>
								<button
									title="Usuń zespół"
									onclick={() => {
										handleRemoveGroupClick(group);
									}}
								>
									<Close class="text-accent-red" size="1.25rem" />
								</button>
							</div>
						</div>
						<p class="text-main-gray">{group.users.length} pracowników</p>
					</div>
				</div>
			</div>
		{/each}
	</div>
</div>

{#if showNewGroupPopup}
	<Popup title="Nowy zespół" togglePopup={toggleNewGroupPopup}>
		{@render groupForm()}
	</Popup>
{/if}

{#if showEditGroupPopup}
	<Popup title="Edycja zespołu - {selectedGroup?.name}" togglePopup={toggleEditGroupPopup}>
		{@render groupForm()}
	</Popup>
{/if}

{#if showRemoveGroupPopup}
	<Popup title="Usuwanie zespołu - {selectedGroup?.name}" togglePopup={toggleRemoveGroupPopup}
	></Popup>
{/if}

{#snippet groupForm()}
	<form action="?/editGroup" method="POST" class="flex flex-col w-[33.333vw]">
		<input type="hidden" id="group" name="group" value={selectedGroup?.id} />
		<input type="hidden" id="mode" name="mode" value={showNewGroupPopup ? 'create' : 'edit'} />
		<input type="hidden" id="icon_name" name="icon_name" value={selectedIcon} />
		<input
			type="hidden"
			id="selected_users"
			name="selected_users"
			value={JSON.stringify(selectedUsers?.map((g) => g.id))}
		/>

		<label for="icon">Ikona</label>
		<button
			class="h-10 w-10 border border-main-gray flex justify-center items-center mb-2"
			type="button"
			onclick={toggleIconSelect}
			bind:this={iconSelectTrigger}
			id="icon"
		>
			<svelte:component
				this={showNewGroupPopup
					? $icons[selectedIcon] || $icons['HelpCircleOutline']
					: $icons[selectedIcon] || $icons[selectedGroup?.icon_name]}
				size="2rem"
				class="text-black"
			/>
		</button>

		{#if showIconSelect}
			<Dropdown toggleDropdown={toggleIconSelect} triggerElement={iconSelectTrigger}>
				<div class="grid grid-cols-10">
					{#each Object.keys($icons) as iconName}
						<button
							class="h-10 w-10 border border-main-gray flex justify-center items-center"
							type="button"
							onclick={() => handleIconSelect(iconName)}
						>
							<svelte:component this={$icons[iconName]} size="2rem" class="text-black" />
						</button>
					{/each}
				</div>
			</Dropdown>
		{/if}

		<label for="name">Nazwa zespołu</label>
		<input
			class="border border-main-gray p-1 mb-2"
			type="text"
			id="name"
			name="name"
			placeholder="Nazwa zespołu"
			value={selectedGroup?.name}
		/>
		<label for="users">Członkowie zespołu</label>
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
			{showNewGroupPopup ? 'Dodaj zespół' : 'Zatwierdź zmiany'}
		</button>
	</form>
{/snippet}
