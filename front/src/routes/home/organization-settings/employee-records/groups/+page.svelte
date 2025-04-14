<script>
	import Plus from 'svelte-material-icons/Plus.svelte';
	import { icons } from '../../../../../stores/icons.js';
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import Close from 'svelte-material-icons/Close.svelte';
	import Popup from '../../../../../components/Popup.svelte';

	let { data } = $props();

	let showNewGroupPopup = $state(false);
	const toggleNewGroupPopup = () => {
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

	const handleEditGroupClick = (group) => {
		selectedGroup = group;
		toggleEditGroupPopup();
	};

	const handleRemoveGroupClick = (group) => {
		selectedGroup = group;
		toggleRemoveGroupPopup();
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
	<Popup title="Nowy zespół" togglePopup={toggleNewGroupPopup}></Popup>
{/if}

{#if showEditGroupPopup}
	<Popup title="Edycja zespołu - {selectedGroup?.name}" togglePopup={toggleEditGroupPopup}></Popup>
{/if}

{#if showRemoveGroupPopup}
	<Popup
		title="Usuwanie zespołu - {selectedGroup?.name}"
		togglePopup={toggleRemoveGroupPopup}
	></Popup>
{/if}
