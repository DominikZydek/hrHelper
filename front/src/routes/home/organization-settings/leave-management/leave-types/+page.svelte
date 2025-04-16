<script>
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import Delete from 'svelte-material-icons/Delete.svelte';
	import Plus from 'svelte-material-icons/Plus.svelte';
	import Popup from '../../../../../components/Popup.svelte';
	import Check from 'svelte-material-icons/Check.svelte';

	let { data } = $props();

	let selectedLeaveType = $state(null);
	let showLimitPerYearInput = $state(false);
	let showMinNoticeDaysInput = $state(false);

	$effect(() => {
		if (selectedLeaveType) {
			showLimitPerYearInput = selectedLeaveType?.limit_per_year > 0;
			showMinNoticeDaysInput = selectedLeaveType?.min_notice_days > 0;
		}
	});

	let showNewLeaveType = $state(false);
	const toggleNewLeaveType = () => {
		selectedLeaveType = null;

		showNewLeaveType = !showNewLeaveType;
	};

	let showEditLeaveType = $state(false);
	const toggleEditLeaveType = () => {
		showEditLeaveType = !showEditLeaveType;
	};

	let showRemoveLeaveType = $state(false);
	const toggleRemoveLeaveType = () => {
		showRemoveLeaveType = !showRemoveLeaveType;
	};

	const handleEditLeaveTypeClick = (leaveType) => {
		selectedLeaveType = leaveType;
		toggleEditLeaveType();
	};

	const handleRemoveLeaveTypeClick = (leaveType) => {
		selectedLeaveType = leaveType;
		toggleRemoveLeaveType();
	};
</script>

<div class="p-8">
	<div class="px-10 flex justify-between">
		<div class="flex items-start gap-8 mb-4 flex-1">
			<p class="font-semibold text-2xl text-main-app">Ustawienia typów urlopu</p>
			<div class="flex-1"></div>
		</div>
		<button
			type="button"
			onclick={toggleNewLeaveType}
			class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4"
		>
			<Plus />
			Dodaj typ urlopu
		</button>
	</div>
	<div class="flex gap-5 flex-wrap justify-center px-10">
		{#each data.leaveTypes as leaveType}
			<div class="p-6 border rounded-xl shadow">
				<div class="flex gap-5 items-center">
					<div>
						<div class="flex justify-between gap-5">
							<p class="font-bold text-main-app">{leaveType.name}</p>
							<div>
								<button
									title="Edytuj typ urlopu"
									onclick={() => handleEditLeaveTypeClick(leaveType)}
								>
									<Pencil class="text-accent-orange" size="1.25rem" />
								</button>
								<button
									title="Usuń typ urlopu"
									onclick={() => handleRemoveLeaveTypeClick(leaveType)}
								>
									<Delete class="text-accent-red" size="1.25rem" />
								</button>
							</div>
						</div>
						<p class="text-main-gray">
							{leaveType.leave_requests.filter(
								(r) =>
									r.status === 'APPROVED' &&
									new Date(r.date_from) <= new Date() &&
									new Date(r.date_to) >= new Date()
							).length} obecnie w trakcie
						</p>
					</div>
				</div>
			</div>
		{/each}
	</div>
</div>

{#if showNewLeaveType}
	<Popup title="Nowy typ urlopu" togglePopup={toggleNewLeaveType}>
		{@render leaveTypeForm()}
	</Popup>
{/if}

{#if showEditLeaveType}
	<Popup title="Edycja - {selectedLeaveType?.name}" togglePopup={toggleEditLeaveType}>
		{@render leaveTypeForm()}
	</Popup>
{/if}

{#if showRemoveLeaveType}
	<Popup title="Usuwanie - {selectedLeaveType?.name}" togglePopup={toggleRemoveLeaveType}>
		<p>Czy na pewno chcesz usunąć typ urlopu: {selectedLeaveType?.name}?</p>
		<form action="?/removeLeaveType" method="POST" class="flex flex-col">
			<input type="hidden" value={selectedLeaveType?.id} id="leave_type" name="leave_type" />
			<button
				type="submit"
				class="flex gap-1 items-center bg-accent-red text-main-white font-semibold h-8 px-4 self-end mt-5"
			>
				<Delete />
				Usuń typ urlopu
			</button>
		</form>
	</Popup>
{/if}

{#snippet leaveTypeForm()}
	<form action="?/editLeaveType" method="POST" class="flex flex-col w-[33.333vw]">
		<input type="hidden" id="leave_type" name="leave_type" value={selectedLeaveType?.id} />
		<input type="hidden" id="mode" name="mode" value={showNewLeaveType ? 'create' : 'edit'} />

		<label for="name">Nazwa typu urlopu</label>
		<input
			class="border border-main-gray p-1 mb-2"
			type="text"
			id="name"
			name="name"
			placeholder="Nazwa typu urlopu"
			value={selectedLeaveType?.name}
		/>

		<div class="flex gap-2 mb-2">
			<input
				id="unlimited"
				type="checkbox"
				checked={!showLimitPerYearInput}
				onchange={(e) => (showLimitPerYearInput = !e.target.checked)}
			/>
			<label for="unlimited">Nielimitowana liczba wykorzystanych dni w ciągu roku</label>
		</div>
		{#if showLimitPerYearInput}
			<label for="limit_per_year">Maksymalna możliwa liczba wykorzystanych dni w ciągu roku</label>
			<input
				class="border border-main-gray p-1 mb-2"
				type="text"
				id="limit_per_year"
				name="limit_per_year"
				placeholder="Maksymalna możliwa liczba wykorzystanych dni w ciągu roku"
				value={selectedLeaveType?.limit_per_year}
			/>
		{/if}

		<div class="flex gap-2 mb-2">
			<input
				id="requires_replacement"
				name="requires_replacement"
				type="checkbox"
				checked={selectedLeaveType?.requires_replacement}
			/>
			<label for="requires_replacement">Wymaga wyznaczenia osoby zastępującej</label>
		</div>

		<div class="flex gap-2 mb-2">
			<input
				id="no_notice"
				type="checkbox"
				checked={!showMinNoticeDaysInput}
				onchange={(e) => (showMinNoticeDaysInput = !e.target.checked)}
			/>
			<label for="no_notice">Nie wymaga zgłaszania z wyprzedzeniem</label>
		</div>
		{#if showMinNoticeDaysInput}
			<label for="min_notice_days"
				>Minimalna liczba dni do zgłoszenia z wyprzedzeniem (roboczo)</label
			>
			<input
				class="border border-main-gray p-1 mb-2"
				type="text"
				id="min_notice_days"
				name="min_notice_days"
				placeholder="Minimalna liczba dni do zgłoszenia z wyprzedzeniem (roboczo)"
				value={selectedLeaveType?.min_notice_days}
			/>
		{/if}

		<div class="flex gap-2 mb-2">
			<input id="can_be_cancelled" type="checkbox" checked={selectedLeaveType?.can_be_cancelled} />
			<label for="can_be_cancelled">Może zostać anulowany</label>
		</div>

		<button
			type="submit"
			class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4 self-end mt-5"
		>
			<Check />
			{showNewLeaveType ? 'Dodaj typ urlopu' : 'Zatwierdź zmiany'}
		</button>
	</form>
{/snippet}
