<script>
	import Calendar from '@event-calendar/core';
	import DayGrid from '@event-calendar/day-grid';
	import Interaction from '@event-calendar/interaction';
	import Popup from '../../../../../components/Popup.svelte';
	import Check from 'svelte-material-icons/Check.svelte';
	import Delete from 'svelte-material-icons/Delete.svelte';

	let { data } = $props();

	let selectedHoliday = $state(null);
	let selectedDate = $state(null);

	let showEditHoliday = $state(false);
	const toggleEditHoliday = () => {
		showEditHoliday = !showEditHoliday;
	};

	let showAddNewHoliday = $state(false);
	const toggleAddNewHoliday = () => {
		showAddNewHoliday = !showAddNewHoliday;
	};

	let showRemoveHoliday = $state(false);
	const toggleRemoveHoliday = () => {
		showRemoveHoliday = !showRemoveHoliday;
	};

	const handleRemoveButtonClick = () => {
		toggleEditHoliday();
		toggleRemoveHoliday();
	};

	const handleEventClick = (info) => {
		selectedHoliday = data.me.organization.holidays.filter(
			(holiday) => info.event.id === holiday.id
		)[0];
		if (selectedHoliday) {
			toggleEditHoliday();
		}
	};

	const handleDateClick = (info) => {
		selectedHoliday = null;
		selectedDate = info.date.toISOString().split('T')[0];

		showAddNewHoliday = true;
	};

	const mapCompanyHolidaysToCalendarEvents = (holidays) => {
		return holidays.map((holiday) => ({
			id: holiday.id,
			allDay: true,
			start: holiday.date,
			end: holiday.date,
			title: holiday.name,
			backgroundColor: '#2563EB',
			editable: false
		}));
	};

	let plugins = [DayGrid, Interaction];
	let options = {
		view: 'dayGridMonth',
		events: mapCompanyHolidaysToCalendarEvents(data.me.organization.holidays),
		eventClick: (info) => handleEventClick(info),
		dateClick: (info) => handleDateClick(info),
		locale: 'pl-PL',
		headerToolbar: {
			start: 'prev today next',
			center: '',
			end: 'title'
		},
		buttonText: (text) => ({ ...text, today: 'Dziś' }),
		dayHeaderFormat: { weekday: 'long' },
		firstDay: 1
	};
</script>

<div class="p-8">
	<div class="px-10 flex justify-between">
		<div class="flex items-start gap-8 mb-4 flex-1">
			<p class="font-semibold text-2xl text-main-app">Ustawienia dni wolnych</p>
			<div class="flex-1"></div>
		</div>
	</div>
	<div class="w-3/4 max-w-5xl m-auto px-10">
		<Calendar {plugins} {options} />
	</div>
</div>

{#if showAddNewHoliday}
	<Popup
		title="Nowy dzień wolny - {new Date(selectedDate).toLocaleDateString()}"
		togglePopup={toggleAddNewHoliday}
	>
		{@render holidayForm()}
	</Popup>
{/if}

{#if showEditHoliday}
	<Popup
		title="Edycja dnia wolnego - {selectedHoliday.name} - {new Date(
			selectedHoliday.date
		).toLocaleDateString()}"
		togglePopup={toggleEditHoliday}
	>
		<svelte:fragment slot="header-right">
			<button type="button" onclick={handleRemoveButtonClick}>
				<Delete class="text-accent-red" size="2rem" />
			</button>
		</svelte:fragment>
		{@render holidayForm()}
	</Popup>
{/if}

{#if showRemoveHoliday}
	<Popup
		title="Usuwanie dnia wolnego - {selectedHoliday.name} - {new Date(
			selectedHoliday.date
		).toLocaleDateString()}"
		togglePopup={toggleRemoveHoliday}
	>
		<p>
			Czy na pewno chcesz usunąć dzień wolny: {selectedHoliday.name} - {new Date(
				selectedHoliday.date
			).toLocaleDateString()}?
		</p>
		<form action="?/removeHoliday" method="POST" class="flex flex-col">
			<input type="hidden" value={selectedHoliday?.id} id="holiday" name="holiday" />
			<button
				type="submit"
				class="flex gap-1 items-center bg-accent-red text-main-white font-semibold h-8 px-4 self-end mt-5"
			>
				<Delete />
				Usuń dzień wolny
			</button>
		</form>
	</Popup>
{/if}

{#snippet holidayForm()}
	<form action="?/editHoliday" method="POST" class="flex flex-col w-[33.333vw]">
		<input type="hidden" id="holiday" name="holiday" value={selectedHoliday?.id} />
		<input type="hidden" id="mode" name="mode" value={showAddNewHoliday ? 'create' : 'edit'} />

		<label for="name">Nazwa</label>
		<input
			class="border border-main-gray p-1 mb-2"
			type="text"
			id="name"
			name="name"
			placeholder="Nazwa"
			value={selectedHoliday?.name}
		/>

		<label for="date">Data</label>
		<input
			class="border border-main-gray p-1 mb-2"
			type="date"
			id="date"
			name="date"
			placeholder="Data"
			disabled={showAddNewHoliday ? 'disabled' : ''}
			value={selectedHoliday?.date || selectedDate}
		/>
		<div class="flex gap-2 mb-2">
			<input
				id="recurring_yearly"
				name="recurring_yearly"
				type="checkbox"
				checked={selectedHoliday?.recurring_yearly}
			/>
			<label for="recurring_yearly">Powtarza się co roku</label>
		</div>
		<button
			type="submit"
			class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4 self-end mt-5"
		>
			<Check />
			{showAddNewHoliday ? 'Dodaj dzień wolny' : 'Zatwierdź zmiany'}
		</button>
	</form>
{/snippet}
