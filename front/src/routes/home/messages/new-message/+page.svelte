<script>
	import MultiSelect from '../../../../components/MultiSelect.svelte';
	import SendOutline from 'svelte-material-icons/SendOutline.svelte';
	import Eye from 'svelte-material-icons/Eye.svelte';
	import Popup from '../../../../components/Popup.svelte';
	import EmployeeList from '../../../../components/EmployeeList.svelte';
	import { onDestroy, onMount } from 'svelte';
	import { getMessagePriorityInfo } from '../../../../utils/getMessagePriorityInfo.js';

	let { data } = $props();

	let selectedGroups = $state([]);
	let selectedUsers = $state([]);
	let recipients = $state([]);

	let selectedTemplate = $state(null);
	const handleTemplateSelect = (e) => {
		selectedTemplate = data.message_templates.find((t) => t.id === e.target.value);
		messagePriority = selectedTemplate.priority?.toString();
	};

	let chooseMode = $state('groups'); // 'employees'
	const handleChooseModeChange = (e) => {
		chooseMode = e.target.value;

		selectedUsers = [];
		selectedGroups = [];
		recipients = [];
	};

	let groupJoinMode = $state('sum'); // 'intersection'
	const handleGroupJoinModeChange = (e) => {
		groupJoinMode = e.target.value;
		updateRecipients();
	};

	let showRecipients = $state(false);
	const toggleRecipients = () => {
		showRecipients = !showRecipients;
	};

	const updateRecipients = () => {
		if (chooseMode === 'groups') {
			if (groupJoinMode === 'sum') {
				// get all users from all selectedGroups
				recipients = data.users.filter((user) =>
					selectedGroups.some((selectedGroup) =>
						user.groups.some((userGroup) => userGroup.id === selectedGroup.id)
					)
				);
			} else {
				// get all users belonging to all selectedGroups at the same time
				recipients = data.users.filter(
					(user) =>
						selectedGroups.length > 0 &&
						selectedGroups.every((selectedGroup) =>
							user.groups.some((userGroup) => userGroup.id === selectedGroup.id)
						)
				);
			}
		} else {
			recipients = selectedUsers;
		}
	};

	const onGroupSelectChange = (values) => {
		selectedGroups = data.groups.filter((g) => values.includes(g.id));
		updateRecipients();
	};

	const onUserSelectChange = (values) => {
		selectedUsers = data.users.filter((user) => values.includes(user.id));
		updateRecipients();
	};

	let messagePriority = $state('2'); // 1 - low, 2 - medium, 3 - high

	let currentDateTime = $state(new Date());
	let interval;

	onMount(() => {
		interval = setInterval(() => {
			currentDateTime = new Date();
		}, 5000);
	});

	onDestroy(() => {
		if (interval) clearInterval(interval);
	});

	const clearIntervalOnUserInput = () => {
		// if user chooses date manually, don't update current date anymore
		clearInterval(interval);
		interval = null;
	};
</script>

<div class="flex-1 p-4">
	<div class="flex items-start gap-8 mb-4">
		<p class="font-semibold text-2xl text-main-app">Nowa wiadomość</p>
	</div>

	<form
		action="?/sendMessage"
		id="new-message"
		name="new-message"
		method="POST"
		class="grid grid-cols-12 gap-4"
	>
		<div class="p-6 border rounded-xl shadow col-span-9">
			<input
				type="hidden"
				id="recipients"
				name="recipients"
				value={JSON.stringify(recipients.map((r) => r.id))}
			/>
			<div>
				<p class="text-lg font-bold mb-2">Wybierz odbiorców</p>
				<!-- TODO: make a toggle component for this -->
				<div class="flex items-center gap-4">
					<div>
						<input
							type="radio"
							id="choose-mode-groups"
							name="choose-mode"
							value="groups"
							checked={chooseMode === 'groups'}
							onchange={handleChooseModeChange}
						/>
						<label for="choose-mode-groups">Wybierz zespoły</label>
					</div>
					<div>
						<input
							type="radio"
							id="choose-mode-employees"
							name="choose-mode"
							value="employees"
							checked={chooseMode === 'employees'}
							onchange={handleChooseModeChange}
						/>
						<label for="choose-mode-employees">Wybierz pracowników</label>
					</div>
				</div>
			</div>
			{#if chooseMode === 'groups'}
				<div class="flex gap-4">
					<div class="flex-1">
						<MultiSelect
							options={data.groups.map((group) => ({
								value: group.id,
								name: group.name,
								icon_name: group.icon_name
							}))}
							selected={selectedGroups.map((g) => g.id)}
							name="groups"
							id="groups"
							placeholder="Wybierz zespoły"
							onChange={onGroupSelectChange}
						/>
					</div>
					<!-- TODO: these should be styled better -->
					<div>
						<div>
							<input
								type="radio"
								id="groups-join-sum"
								name="groups-join-mode"
								value="sum"
								checked={groupJoinMode === 'sum'}
								onchange={handleGroupJoinModeChange}
							/>
							<label for="groups-join-sum">Pracownicy we wszystkich wybranych zespołach</label>
						</div>
						<div>
							<input
								type="radio"
								id="groups-join-intersection"
								name="groups-join-mode"
								value="intersection"
								checked={groupJoinMode === 'intersection'}
								onchange={handleGroupJoinModeChange}
							/>
							<label for="groups-join-intersection"
								>Pracownicy przynależący do każdego z wybranych zespołów</label
							>
						</div>
					</div>
				</div>
			{:else}
				<MultiSelect
					options={data.users.map((user) => ({
						value: user.id,
						name: user.first_name + ' ' + user.last_name,
						icon_name: 'Account'
					}))}
					selected={selectedUsers.map((u) => u.id)}
					name="users"
					id="users"
					placeholder="Wybierz pracowników"
					onChange={onUserSelectChange}
				/>
			{/if}
		</div>

		<div class="p-6 border rounded-xl shadow col-span-3 row-span-2 flex flex-col gap-2">
			<p class="text-lg font-bold mb-2">Wybierz opcje</p>
			<div class="flex flex-col">
				<label class="font-semibold" for="priority">Wybierz priorytet wiadomości</label>
				<div class="flex gap-4">
					<input
						class="flex-1"
						id="priority"
						name="priority"
						type="range"
						min="1"
						max="3"
						value={selectedTemplate?.priority || '2'}
						step="1"
						onchange={(e) => {
							messagePriority = e.target.value;
						}}
					/>
					<p
						class="w-1/6 text-center font-semibold text-{getMessagePriorityInfo(messagePriority)
							.colorClass}"
					>
						{getMessagePriorityInfo(messagePriority).message}
					</p>
				</div>
			</div>
			<div class="flex flex-col">
				<label class="font-semibold" for="publication_date">Określ datę publikacji wiadomości</label
				>
				<input
					type="datetime-local"
					id="publication_date"
					name="publication_date"
					onchange={clearIntervalOnUserInput}
					value={new Date(currentDateTime.getTime() - currentDateTime.getTimezoneOffset() * 60000)
						.toISOString()
						.slice(0, 16)}
				/>
			</div>
			<div class="flex flex-col">
				<label class="font-semibold" for="date_from">Określ okres obowiązywania wiadomości</label>
				<div>
					<label for="date_from">Od:</label>
					<input type="date" id="date_from" name="date_from" />

					<label for="date_to">Do:</label>
					<input type="date" id="date_to" name="date_to" />
				</div>
			</div>
			<div>
				<input
					id="require_confirmation"
					name="require_confirmation"
					type="checkbox"
					checked={selectedTemplate?.require_confirmation}
				/>
				<label class="font-semibold" for="require_confirmation">Wymagaj potwierdzenia odbioru</label
				>
			</div>
		</div>

		<div class="p-6 border rounded-xl shadow col-span-9">
			<p class="font-bold text-lg mb-2">Wybierz szablon</p>
			<select
				class="w-full border border-main-gray p-2"
				name="template"
				id="template"
				onchange={(e) => handleTemplateSelect(e)}
			>
				<option selected>Wybierz szablon</option>
				{#each data.message_templates as template}
					<option value={template.id}>{template.name}</option>
				{/each}
			</select>
		</div>

		<div class="p-6 border rounded-xl shadow col-span-12">
			<p class="font-bold text-lg mb-2">Napisz wiadomość</p>
			<div class="flex flex-col gap-4">
				<div class="flex gap-2">
					<input
						class="flex-1 border border-main-gray p-2"
						type="text"
						id="subject"
						name="subject"
						placeholder="Temat wiadomości"
						value={selectedTemplate?.subject}
					/>
					<select class="w-max border border-main-gray p-2" name="category" id="category">
						<option disabled selected>Wybierz kategorię</option>
						{#each data.message_categories as category}
							<option
								selected={selectedTemplate?.category?.id === category.id ? 'selected' : ''}
								value={category.id}>{category.name}</option
							>
						{/each}
					</select>
				</div>
				<textarea
					class="w-full border border-main-gray p-2 resize-none"
					id="content"
					name="content"
					rows="10"
					placeholder="Treść wiadomości">{selectedTemplate?.content}</textarea
				>
				<div class="flex justify-between">
					<div>
						<p>Dodaj załącznik(i)</p>
						<input type="file" />
					</div>
					<div class="flex flex-col">
						<button
							type="submit"
							class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4 self-end
										{recipients.length === 0 ? 'bg-main-gray opacity-50' : ''}"
							disabled={recipients.length === 0}
						>
							<SendOutline />
							Wyślij wiadomość
						</button>
						{#if recipients.length > 0}
							<p>Wiadomość zostanie wysłana do <b>{recipients.length}</b> pracowników</p>
							<button
								type="button"
								class="flex gap-1 items-center text-main-gray self-end"
								onclick={() => toggleRecipients()}
							>
								<Eye />
								Pokaż szczegóły
							</button>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

{#if showRecipients}
	<Popup togglePopup={toggleRecipients} title="Adresaci wiadomości">
		<EmployeeList users={recipients} />
	</Popup>
{/if}
