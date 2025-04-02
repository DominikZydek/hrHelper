<script>
	import AccountGroup from 'svelte-material-icons/AccountGroup.svelte';
	import FileDocumentMultiple from 'svelte-material-icons/FileDocumentMultiple.svelte';
	import CalendarMultiselect from 'svelte-material-icons/CalendarMultiselect.svelte';
	import AccountMultiplePlus from 'svelte-material-icons/AccountMultiplePlus.svelte';
	import NewspaperVariantMultiple from 'svelte-material-icons/NewspaperVariantMultiple.svelte';
</script>

<div class="flex-1 p-4 overflow-auto">
	<div class="flex items-start gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Ustawienia organizacji</p>
	</div>

	<div class="w-full h-full flex justify-center items-center">
		<div class="flex gap-5 flex-wrap justify-center">
			<div class="p-6 border rounded-xl shadow">
				<div class="flex gap-2 items-center text-main-app mb-2">
					<AccountGroup size="1.5rem" />
					<p class="text-xl font-semibold">Pracownicy</p>
				</div>
			</div>

			<div class="p-6 border rounded-xl shadow">
				<div class="flex gap-2 items-center text-main-app mb-2">
					<FileDocumentMultiple size="1.5rem" />
					<p class="text-xl font-semibold">Dokumentacja</p>
				</div>
			</div>

			<div class="p-6 border rounded-xl shadow">
				<div class="flex gap-2 items-center text-main-app mb-2">
					<CalendarMultiselect size="1.5rem" />
					<p class="text-xl font-semibold">Nieobecności</p>
				</div>
			</div>

			<div class="p-6 border rounded-xl shadow">
				<div class="flex gap-2 items-center text-main-app mb-2">
					<AccountMultiplePlus size="1.5rem" />
					<p class="text-xl font-semibold">Rekrutacje</p>
				</div>
			</div>

			<div class="p-6 border rounded-xl shadow">
				<div class="flex gap-2 items-center text-main-app mb-2">
					<NewspaperVariantMultiple size="1.5rem" />
					<p class="text-xl font-semibold">Wiadomości</p>
				</div>
			</div>
		</div>
	</div>
</div>
