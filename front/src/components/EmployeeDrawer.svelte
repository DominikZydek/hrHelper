<script>
	import Drawer from './Drawer.svelte';
	import Pencil from 'svelte-material-icons/Pencil.svelte';
	import Check from 'svelte-material-icons/Check.svelte';
	import Eye from 'svelte-material-icons/Eye.svelte';
	import GroupBadge from './GroupBadge.svelte';
	import Popup from './Popup.svelte';
	import ApprovalProcess from './ApprovalProcess.svelte';
	import MultiSelect from './MultiSelect.svelte';
	import ApprovalProcessEditMode from './ApprovalProcessEditMode.svelte';

	export let user;
	export let toggleDrawer;
	export let allUsers;
	export let groups;

	let showEditMode = false;
	const toggleEditMode = () => {
		showEditMode = !showEditMode;
	};

	let showPopup = false;
	const togglePopup = () => {
		showPopup = !showPopup;
	};

	// adjusts width of an input element to its value dynamically
	const adjustWidth = (node) => {
		const setWidth = () => {
			node.style.width = node.value.length + 0.5 + 'ch';
		};

		setWidth();
		node.addEventListener('input', setWidth);

		return {
			destroy() {
				node.removeEventListener('input', setWidth);
			}
		};
	};
</script>

<Drawer {toggleDrawer} title={showEditMode ? '' : `${user?.first_name} ${user?.last_name}`}>
	<svelte:fragment slot="header-left">
		{#if showEditMode}
			<button
				type="submit"
				form="update_user"
				class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4"
			>
				<Check />
				Zapisz zmiany
			</button>
		{:else}
			<button
				on:click={toggleEditMode}
				class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4"
			>
				<Pencil />
				Edytuj
			</button>
		{/if}
		<img class="h-8 w-8" src="/favicon.png" alt="" />
	</svelte:fragment>

	{#if !showEditMode}
		<div class="flex flex-col gap-5">
			<div>
				<p class="font-semibold text-xl text-main-app">Dane pracownika</p>
				<table class="text-left w-full">
					<tbody>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">IMIĘ</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">{user.first_name}</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">NAZWISKO</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">{user.last_name}</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">PŁEĆ</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{#if user.sex === 'M'}
									Mężczyzna
								{:else if user.sex === 'F'}
									Kobieta
								{:else if user.sex === 'X'}
									Inna
								{/if}
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">ADRES E-MAIL</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">{user.email}</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">DATA URODZENIA</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{new Date(user.birth_date).toLocaleDateString()}
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">NUMER TELEFONU</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">{user.phone_number}</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">ADRES ZAMIESZKANIA</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{user.address.street_name}
								{user.address.street_number}
								{user.address.postal_code}
								{user.address.city}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<p class="font-semibold text-xl text-main-app">Organizacja</p>
				<table class="text-left w-full">
					<tbody>
						<tr>
							<!-- TODO: adjust for new roles/permission system -->
							<th class="w-1/2 font-bold text-main-gray">ROLA</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{#if user.roles.some((r) => r.name === 'employee')}
									Pracownik
								{:else if user.roles.some((r) => r.name === 'supervisor')}
									Przełożony
								{:else if user.roles.some((r) => r.name === 'hr')}
									Kadry
								{:else if user.roles.some((r) => r.name === 'admin')}
									Administrator
								{/if}
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">STANOWISKO</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">{user.job_title}</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">PRZEŁOŻONY</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{#if user.supervisor}
									{user.supervisor.first_name} {user.supervisor.last_name}
								{:else}
									Brak
								{/if}
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">ZESPOŁY</th>
							<td class="w-1/2 text-main-black font-semibold flex gap-2 pl-5">
								{#each user.groups as group}
									<GroupBadge {group} />
								{/each}
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">PROCES AKCEPTACJI</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<button
									on:click={() => togglePopup()}
									class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4"
								>
									<Eye class="" />
									Zobacz
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<p class="font-semibold text-xl text-main-app">Forma zatrudnienia</p>
				<table class="text-left w-full">
					<tbody>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">RODZAJ UMOWY</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{#if user.type_of_employment === 'UOP'}
									Umowa o pracę
								{:else if user.type_of_employment === 'B2B'}
									B2B
								{/if} ({user.paid_time_off_days} dni)</td
							>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">WYMIAR PRACY</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">{user.working_time} etatu</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">DATA ROZPOCZĘCIA UMOWY</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{new Date(user.employed_from).toLocaleDateString()}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<p class="font-semibold text-xl text-main-app">Ważne daty</p>
				<table class="text-left w-full">
					<tbody>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">DATA ZAKOŃCZENIA UMOWY</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{user.employed_to ? new Date(user.employed_to).toLocaleDateString() : 'Brak'}
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">DATA WAŻNOŚCI BADAŃ LEKARSKICH</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{new Date(user.health_check_expired_by).toLocaleDateString()}
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">DATA WAŻNOŚCI SZKOLENIA BHP</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{new Date(user.health_and_safety_training_expired_by).toLocaleDateString()}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		{#if showPopup}
			<Popup {togglePopup} title="Proces akceptacji">
				<ApprovalProcess {user} />
			</Popup>
		{/if}
	{:else}
		<form id="update_user" action="?/updateUser" method="POST" class="flex flex-col gap-5">
			<input id="id" name="id" type="hidden" value={user.id} />
			<div>
				<p class="font-semibold text-xl text-main-app">Dane pracownika</p>
				<table class="text-left w-full">
					<tbody>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="first_name">IMIĘ</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="first_name"
									id="first_name"
									type="text"
									value={user.first_name}
								/>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="last_name">NAZWISKO</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="last_name"
									id="last_name"
									type="text"
									value={user.last_name}
								/>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="sex">PŁEĆ</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<select class="w-full" name="sex" id="sex">
									<option value="M" selected={user.sex === 'M'}>Mężczyzna</option>
									<option value="F" selected={user.sex === 'F'}>Kobieta</option>
									<option value="X" selected={user.sex === 'X'}>Inna</option>
								</select>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="email">ADRES E-MAIL</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input class="w-full" name="email" id="email" type="email" value={user.email} />
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="birth_date">DATA URODZENIA</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="birth_date"
									id="birth_date"
									type="date"
									value={user.birth_date}
								/>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="phone_number">NUMER TELEFONU</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="phone_number"
									id="phone_number"
									type="text"
									value={user.phone_number}
								/>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="street_name">ADRES ZAMIESZKANIA</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class=""
									name="street_name"
									id="street_name"
									type="text"
									use:adjustWidth
									value={user.address.street_name}
								/>
								<input
									class=""
									name="street_number"
									id="street_number"
									type="text"
									use:adjustWidth
									value={user.address.street_number}
								/>
								<input
									class=""
									name="postal_code"
									id="postal_code"
									type="text"
									use:adjustWidth
									value={user.address.postal_code}
								/>
								<input
									class=""
									name="city"
									id="city"
									type="text"
									use:adjustWidth
									value={user.address.city}
								/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<p class="font-semibold text-xl text-main-app">Organizacja</p>
				<table class="text-left w-full">
					<tbody>
						<tr>
							<!-- TODO: adjust for new roles/permission system -->
							<th class="w-1/2 font-bold text-main-gray">
								<label for="role">ROLA</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<select class="w-full" name="role" id="role">
									<!--                                <option value="employee" selected={user.role === 'EMPLOYEE'}>Pracownik</option>-->
									<!--                                <option value="supervisor" selected={user.role === 'SUPERVISOR'}>Przełożony</option>-->
									<!--                                <option value="hr" selected={user.role === 'HR'}>Kadry</option>-->
									<!--                                <option value="admin" selected={user.role === 'ADMIN'}>Administrator</option>-->
								</select>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="job_title">STANOWISKO</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="job_title"
									id="job_title"
									type="text"
									value={user.job_title}
								/>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="supervisor">PRZEŁOŻONY</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								{#if user.supervisor}
									<select class="w-full" name="supervisor" id="supervisor">
										{#each allUsers as newSupervisor}
											<option
												value={newSupervisor.id}
												selected={user.supervisor?.id === newSupervisor.id}
											>
												{newSupervisor.first_name}
												{newSupervisor.last_name}
											</option>
										{/each}
									</select>
								{:else}
									Brak
								{/if}
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="groups">ZESPOŁY</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									type="hidden"
									id="groups"
									name="groups"
									value={JSON.stringify(user.groups.map((g) => g.id))}
								/>
								<MultiSelect
									options={groups.map((group) => ({
										value: group.id,
										name: group.name,
										icon_name: group.icon_name
									}))}
									selected={user.groups.map((g) => g.id)}
									name="groups"
									id="groups"
									placeholder="Wybierz grupy"
									onChange={(values) => {
										user.groups = groups.filter((g) => values.includes(g.id));
									}}
								/>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="approval_process">PROCES AKCEPTACJI</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<button
									on:click={() => togglePopup()}
									type="button"
									class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4"
								>
									<Pencil class="" />
									Edytuj
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<p class="font-semibold text-xl text-main-app">Forma zatrudnienia</p>
				<table class="text-left w-full">
					<tbody>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="type_of_employment">RODZAJ UMOWY</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<select class="" name="type_of_employment" id="type_of_employment">
									<option value="UoP" selected={user.type_of_employment === 'UOP'}
										>Umowa o pracę</option
									>
									<option value="B2B" selected={user.type_of_employment === 'B2B'}>B2B</option>
								</select>
								(<input
									class=""
									name="paid_time_off_days"
									id="paid_time_off_days"
									type="text"
									use:adjustWidth
									value={user.paid_time_off_days}
								/> dni)
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="working_time">WYMIAR PRACY</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class=""
									name="working_time"
									id="working_time"
									type="text"
									use:adjustWidth
									value={user.working_time}
								/> etatu
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="employed_from">DATA ROZPOCZĘCIA UMOWY</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="employed_from"
									id="employed_from"
									type="date"
									value={user.employed_from}
								/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<p class="font-semibold text-xl text-main-app">Ważne daty</p>
				<table class="text-left w-full">
					<tbody>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="employed_to">DATA ZAKOŃCZENIA UMOWY</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="employed_to"
									id="employed_to"
									type="date"
									value={user.employed_to}
								/>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="health_check_expired_by">DATA WAŻNOŚCI BADAŃ LEKARSKICH</label>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="health_check_expired_by"
									id="health_check_expired_by"
									type="date"
									value={user.health_check_expired_by}
								/>
							</td>
						</tr>
						<tr>
							<th class="w-1/2 font-bold text-main-gray">
								<label for="health_and_safety_training_expired_by"
									>DATA WAŻNOŚCI SZKOLENIA BHP</label
								>
							</th>
							<td class="w-1/2 text-main-black font-semibold pl-5">
								<input
									class="w-full"
									name="health_and_safety_training_expired_by"
									id="health_and_safety_training_expired_by"
									type="date"
									value={user.health_and_safety_training_expired_by}
								/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
		{#if showPopup}
			<Popup {togglePopup} title="Proces akceptacji">
				<ApprovalProcessEditMode {togglePopup} {user} {allUsers} />
			</Popup>
		{/if}
	{/if}
</Drawer>
