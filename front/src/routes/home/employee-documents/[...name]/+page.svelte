<script>
	import Searchbar from '../../../../components/Searchbar.svelte';
	import { page } from '$app/state';
	import { icons } from '../../../../stores/icons.js';
	import GroupBadge from '../../../../components/GroupBadge.svelte';
	import Plus from 'svelte-material-icons/Plus.svelte';
	import Popup from '../../../../components/Popup.svelte';
	import ContentSave from 'svelte-material-icons/ContentSave.svelte';
	import { getDocumentStatus, getDaysUntilExpiration } from '../../../../utils/timeCalculation.js';
	import { getStatusInfo } from '../../../../utils/getStatusInfo.js';
	import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte';
	import Dropdown from '../../../../components/Dropdown.svelte';
	import Eye from 'svelte-material-icons/Eye.svelte';
	import Delete from 'svelte-material-icons/Delete.svelte';
	import Download from 'svelte-material-icons/Download.svelte';
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import Archive from 'svelte-material-icons/Archive.svelte';
	import Avatar from '../../../../components/Avatar.svelte';

	let { data } = $props();
	let path = $derived(page.url.pathname.split('/')[3]);
	$inspect(data.files);

	let optionButton = $state(null);
	let showOptions = $state(false);

	const toggleOptions = () => {
		showOptions = !showOptions;
	};

	let selectedDocument = $state(null);

	let showUploadDocument = $state(false);
	const toggleUploadDocument = () => {
		showUploadDocument = !showUploadDocument;
	};

	const onClick = (document) => {
		selectedDocument ? (selectedDocument = null) : (selectedDocument = document);
		toggleDocumentDetails();
	};

	let showDocumentDetails = $state(false);
	const toggleDocumentDetails = () => {
		showDocumentDetails = !showDocumentDetails;
	};

	const calculateArchiveDate = (e) => {
		let dateTo = e.target.date_to.value;
		let archivePeriod = Number(e.target.archive_period.value);

		let archiveDate = new Date(dateTo);
		archiveDate.setMonth(11);
		archiveDate.setDate(31);
		archiveDate.setFullYear(archiveDate.getFullYear() + archivePeriod);

		e.target.date_archive.value = archiveDate.toISOString();
	};

	const showDocument = (document) => {
		window.open(document.url, '_blank');
	};

	const editDocument = () => {
		toggleDocumentDetails();
		toggleUploadDocument();
	};

	let displayedFiles = $state(data.files);

	const handleFilteredDataChange = (filteredData) => {
		displayedFiles = filteredData;
	};

	const searchMapper = (file) => {
		let groups = [];

		file.user.groups.forEach((g) => {
			groups.push(g.name);
		});

		return {
			first_name: file.user.first_name,
			last_name: file.user.last_name,
			full_name: file.user.first_name + ' ' + file.user.last_name,
			email: file.user.email,
			job_title: file.user.job_title,
			groups: groups,
			name: file.name,
			created_at: file.created_at,
			date_to: JSON.parse(file.custom_properties).date_to
		};
	};
</script>

<div class="flex-1 p-4">
	<div class="flex items-start gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">
			{data.collections.find((c) => c.name === path)?.display_name || 'Wszystkie pliki'}
		</p>
		<div class="flex-1">
			<Searchbar
				placeholderText="Szukaj dokumentów..."
				searchData={data.files}
				onFilteredDataChange={handleFilteredDataChange}
				{searchMapper}
				filterableFields={['full_name', 'job_title', 'groups']}
				fieldLabels={{
					full_name: 'Imię i nazwisko',
					job_title: 'Stanowisko',
					groups: 'Zespół'
				}}
			/>
		</div>
		<button
			type="button"
			onclick={toggleUploadDocument}
			class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4"
		>
			<Plus />
			Dodaj dokument
		</button>
	</div>
	<div class="w-full overflow-auto rounded-lg shadow-xl">
		<table class="w-full text-left border">
			<thead class="sticky top-0 z-10">
				<tr class="bg-blue-100 text-main-gray">
					<th class="px-4 py-3">Pracownik</th>
					<th class="px-4 py-3">Nazwa dokumentu</th>
					<th class="px-4 py-3">Kategoria</th>
					<th class="px-4 py-3">Data dodania</th>
					<th class="px-4 py-3">Data ważności</th>
					<th class="px-4 py-3 text-center">Status</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-main-gray">
				{#each displayedFiles as file}
					{@const custom_properties = JSON.parse(file.custom_properties)}
					{@const statusInfo = getStatusInfo(getDocumentStatus(custom_properties.date_to), {
						days: getDaysUntilExpiration(custom_properties.date_to)
					})}
					<tr class="cursor-pointer hover:bg-auxiliary-gray" onclick={() => onClick(file)}>
						<td class="px-4 py-3">
							<div class="flex items-center gap-5">
								<Avatar fullName="{file.user.first_name} {file.user.last_name}" variant="large" />
								<div class="flex-1">
									<div class="flex gap-5 items-start">
										<div>
											<p>{file.user.first_name} {file.user.last_name}</p>
											<p>{file.user.email}</p>
										</div>
										<div class="text-right">
											<p>{file.user.job_title}</p>
											<div class="flex gap-2 justify-end">
												{#each file.user.groups as group}
													<GroupBadge {group} />
												{/each}
											</div>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td class="px-4 py-3">{file.name}</td>
						<td class="px-4 py-3">{file.collection.display_name}</td>
						<td class="px-4 py-3">
							{new Date(file.created_at).toLocaleDateString()}
						</td>
						<td class="px-4 py-3">
							{new Date(custom_properties.date_to).toLocaleDateString()}
						</td>
						<td class="px-4 py-3">
							<div class="flex items-center justify-center">
								<div class="flex gap-2 items-center px-3 py-1 rounded-full {statusInfo.class}">
									<p class="font-semibold">{statusInfo.message}</p>
									<svelte:component this={$icons[statusInfo.icon]} size="1.5rem" />
								</div>
							</div>
						</td>
					</tr>
				{/each}
			</tbody>
		</table>
	</div>
</div>

{#if showUploadDocument}
	{@const customProperties = selectedDocument
		? JSON.parse(selectedDocument.custom_properties)
		: null}
	<Popup
		title={selectedDocument ? 'Edytuj dokument' : 'Dodaj dokument'}
		togglePopup={toggleUploadDocument}
	>
		<form
			class="flex flex-col"
			method="POST"
			action="?/upload"
			enctype="multipart/form-data"
			onsubmit={(e) => calculateArchiveDate(e)}
		>
			<input type="hidden" id="mode" name="mode" value={selectedDocument ? 'edit' : 'create'} />

			<input
				type="hidden"
				id="date_archive"
				name="date_archive"
				value={customProperties?.date_archive || ''}
			/>
			{#if selectedDocument}
				<input type="hidden" name="document_id" value={selectedDocument.id} />
			{/if}

			<label class="font-bold text-main-gray" for="file">
				{selectedDocument ? 'ZMIEŃ PLIK (opcjonalne)' : 'WYBIERZ PLIK'}
			</label>
			<input class="w-full mb-2" type="file" id="file" name="file" required={!selectedDocument} />

			<label class="font-bold text-main-gray" for="user">WYBIERZ PRACOWNIKA</label>
			<select class="w-full border border-main-gray px-1 mb-2" name="user" id="user">
				<option disabled>Wybierz pracownika</option>
				{#each data.users as user}
					<option
						value={user.id}
						selected={selectedDocument && selectedDocument.user.id === user.id}
					>
						{user.first_name}
						{user.last_name}
					</option>
				{/each}
			</select>

			<label class="font-bold text-main-gray" for="file_name">NAZWA PLIKU</label>
			<input
				class="w-full border border-main-gray px-1 mb-2"
				type="text"
				id="file_name"
				name="file_name"
				placeholder="Nazwa pliku"
				value={selectedDocument?.name || ''}
			/>

			<label class="font-bold text-main-gray" for="date_from">DATA ROZPOCZĘCIA OBOWIĄZYWANIA</label>
			<input
				class="w-full border border-main-gray px-1 mb-2"
				type="date"
				id="date_from"
				name="date_from"
				value={customProperties?.date_from
					? new Date(customProperties.date_from).toISOString().split('T')[0]
					: ''}
			/>

			<label class="font-bold text-main-gray" for="date_to">DATA WAŻNOŚCI</label>
			<input
				class="w-full border border-main-gray px-1 mb-2"
				type="date"
				id="date_to"
				name="date_to"
				value={customProperties?.date_to
					? new Date(customProperties.date_to).toISOString().split('T')[0]
					: ''}
			/>

			<label class="font-bold text-main-gray" for="archive_period">OKRES ARCHIWIZACJI</label>
			<div class="flex gap-2 w-full mb-2">
				<input
					class="border border-main-gray px-1 w-12"
					type="text"
					id="archive_period"
					value={customProperties
						? (() => {
								const archiveDate = new Date(customProperties.date_archive);
								const dateTo = new Date(customProperties.date_to);
								return archiveDate.getFullYear() - dateTo.getFullYear();
							})()
						: ''}
				/>
				<p>lat(a) od zakończenia roku kalendarzowego, w którym mija data ważności</p>
			</div>

			<label class="font-bold text-main-gray" for="collection">FOLDER ZAPISU</label>
			<select class="w-full border border-main-gray px-1 mb-5" name="collection" id="collection">
				{#each data.collections as collection}
					{#if collection.children && collection.children.length > 0}
						<option
							value={collection.id}
							selected={selectedDocument && selectedDocument.collection.id === collection.id}
						>
							{collection.display_name || collection.name}
						</option>
						{#each collection.children as childCollection}
							<option
								value={childCollection.id}
								selected={selectedDocument && selectedDocument.collection.id === childCollection.id}
							>
								&nbsp;&nbsp;— {childCollection.display_name || childCollection.name}
							</option>
						{/each}
					{:else}
						<option
							value={collection.id}
							selected={selectedDocument && selectedDocument.collection.id === collection.id}
						>
							{collection.display_name || collection.name}
						</option>
					{/if}
				{/each}
			</select>
			<button
				type="submit"
				class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4 self-end"
			>
				<ContentSave />
				{selectedDocument ? 'Zapisz zmiany' : 'Zapisz dokument'}
			</button>
		</form>
	</Popup>
{/if}

{#if showDocumentDetails}
	<Popup
		title="{selectedDocument.user.first_name} {selectedDocument.user
			.last_name} - {selectedDocument.name}"
		togglePopup={() => onClick(selectedDocument)}
	>
		<svelte:fragment slot="header-right">
			<button type="button" bind:this={optionButton} onclick={() => toggleOptions()}>
				<DotsHorizontal class="text-main-gray" size="2rem" />
			</button>
		</svelte:fragment>

		<div class="w-full h-full flex items-center justify-center">
			<img src={selectedDocument.thumbnail} alt="preview" />
		</div>

		{#if showOptions}
			<Dropdown triggerElement={optionButton} toggleDropdown={toggleOptions}>
				<div class="flex flex-col py-2">
					<button
						onclick={() => showDocument(selectedDocument)}
						type="button"
						class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-app"
					>
						<Eye size="1.25rem" />
						<span>Zobacz dokument</span>
					</button>
					<button
						onclick={() => editDocument()}
						type="button"
						class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-accent-orange"
					>
						<Pencil size="1.25rem" />
						<span>Edytuj dokument</span>
					</button>
					<form method="POST" action="?/archive">
						<input type="hidden" name="document_id" value={selectedDocument.id} />
						<button
							type="submit"
							class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-accent-red"
						>
							<Archive size="1.25rem" />
							<span>Archiwizuj dokument</span>
						</button>
					</form>

					<form
						method="POST"
						action="?/delete"
						onsubmit={(e) => {
							if (!confirm(`Czy na pewno chcesz usunąć dokument "${selectedDocument.name}"?`)) {
								e.preventDefault();
							}
						}}
					>
						<input type="hidden" name="document_id" value={selectedDocument.id} />
						<button
							type="submit"
							class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-accent-red"
						>
							<Delete size="1.25rem" />
							<span>Usuń dokument</span>
						</button>
					</form>
				</div>
			</Dropdown>
		{/if}
	</Popup>
{/if}
