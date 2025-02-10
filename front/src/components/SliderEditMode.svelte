<script>
    import Check from 'svelte-material-icons/Check.svelte'
    import Close from 'svelte-material-icons/Close.svelte'
    import GroupBadge from "./GroupBadge.svelte";
    import MultiSelect from './MultiSelect.svelte'

    export let user
    export let showEditMode
    export let toggleEditMode
    export let onSave
    export let allUsers
    export let groups

    // adjusts width of an input element to its value dynamically
    const adjustWidth = (node) => {
        const setWidth = () => {
            node.style.width = (node.value.length + 0.5) + 'ch'
        }

        setWidth()
        node.addEventListener('input', setWidth)

        return {
            destroy() {
                node.removeEventListener('input', setWidth)
            }
        }
    }
</script>

{#if showEditMode}
    <div class="flex flex-col gap-5 right-0 top-0 h-screen w-1/3 fixed bg-main-white border px-10 py-5 shadow-xl">
        <div class="flex justify-between">
            <div class="flex gap-2 items-center">
                <button type="submit" form="update_user"
                        class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4">
                    <Check class="" />
                    Zapisz zmiany
                </button>
                <img class="h-8 w-8" src="favicon.png" alt="">
                <p class="font-semibold">{user.first_name} {user.last_name}</p>
            </div>
            <button on:click={() => toggleEditMode()}>
                <Close class="text-main-gray" size="2rem"/>
            </button>
        </div>
        <form id="update_user" action="?/updateUser" method="POST" class="flex flex-col gap-5">
            <input id="id" name="id" type="hidden" value={user.id}>
            <div>
                <p class="font-semibold text-xl text-main-app">Dane pracownika</p>
                <table class="text-left w-full">
                    <tbody>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="first_name">IMIĘ</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class="w-full"
                                   name="first_name"
                                   id="first_name"
                                   type="text"
                                   value={user.first_name}>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="last_name">NAZWISKO</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class="w-full"
                                   name="last_name"
                                   id="last_name"
                                   type="text"
                                   value={user.last_name}>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="sex">PŁEĆ</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <select class="w-full"
                                    name="sex"
                                    id="sex">
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
                            <input class="w-full"
                                   name="email"
                                   id="email"
                                   type="email"
                                   value={user.email}>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="birth_date">DATA URODZENIA</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class="w-full"
                                   name="birth_date"
                                   id="birth_date"
                                   type="date"
                                   value={user.birth_date}>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="phone_number">NUMER TELEFONU</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class="w-full"
                                   name="phone_number"
                                   id="phone_number"
                                   type="text"
                                   value={user.phone_number}>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="street_name">ADRES ZAMIESZKANIA</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class=""
                                   name="street_name"
                                   id="street_name"
                                   type="text"
                                   use:adjustWidth
                                   value={user.address.street_name}>
                            <input class=""
                                   name="street_number"
                                   id="street_number"
                                   type="text"
                                   use:adjustWidth
                                   value={user.address.street_number}>
                            <input class=""
                                   name="postal_code"
                                   id="postal_code"
                                   type="text"
                                   use:adjustWidth
                                   value={user.address.postal_code}>
                            <input class=""
                                   name="city"
                                   id="city"
                                   type="text"
                                   use:adjustWidth
                                   value={user.address.city}>
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
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="role">ROLA</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <select class="w-full"
                                    name="role"
                                    id="role">
                                <option value="employee" selected={user.role === 'EMPLOYEE'}>Pracownik</option>
                                <option value="supervisor" selected={user.role === 'SUPERVISOR'}>Przełożony</option>
                                <option value="hr" selected={user.role === 'HR'}>Kadry</option>
                                <option value="admin" selected={user.role === 'ADMIN'}>Administrator</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="job_title">STANOWISKO</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class="w-full"
                                   name="job_title"
                                   id="job_title"
                                   type="text"
                                   value={user.job_title}>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="supervisor">PRZEŁOŻONY</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            {#if user.supervisor}
                                <select
                                        class="w-full"
                                        name="supervisor"
                                        id="supervisor">
                                    {#each allUsers as newSupervisor}
                                        <option
                                                value={newSupervisor.id}
                                                selected={user.supervisor?.id === newSupervisor.id}>
                                            {newSupervisor.first_name} {newSupervisor.last_name}
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
                                    value={JSON.stringify(user.groups.map(g => g.id))}
                            />
                            <MultiSelect
                                    options={groups.map(group => ({
                                                value: group.id,
                                                name: group.name,
                                                icon_name: group.icon_name
                                            }))}
                                    selected={user.groups.map(g => g.id)}
                                    name="groups"
                                    id="groups"
                                    placeholder="Wybierz grupy"
                                    onChange={(values) => {
                                                user.groups = groups.filter(g => values.includes(g.id))
                                             }}
                            />
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="approval_process">PROCES AKCEPTACJI</label>
                        </th>
                        <!-- TODO: implement actual approval process -->
                        <td class="w-1/2 text-main-black font-semibold pl-5">{user.approval_process.dummy}</td>
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
                            <select class=""
                                    name="type_of_employment"
                                    id="type_of_employment">
                                <option value="UoP" selected={user.type_of_employment === 'UOP'}>Umowa o pracę</option>
                                <option value="B2B" selected={user.type_of_employment === 'B2B'}>B2B</option>
                            </select>
                            (<input class=""
                                   name="paid_time_off_days"
                                   id="paid_time_off_days"
                                   type="text"
                                   use:adjustWidth
                                   value={user.paid_time_off_days}> dni)
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="working_time">WYMIAR PRACY</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class=""
                                   name="working_time"
                                   id="working_time"
                                   type="text"
                                   use:adjustWidth
                                   value={user.working_time}> etatu
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="employed_from">DATA ROZPOCZĘCIA UMOWY</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class="w-full"
                                   name="employed_from"
                                   id="employed_from"
                                   type="date"
                                   value={user.employed_from}>
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
                            <input class="w-full"
                                   name="employed_to"
                                   id="employed_to"
                                   type="date"
                                   value={user.employed_to}>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="health_check_expired_by">DATA WAŻNOŚCI BADAŃ LEKARSKICH</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class="w-full"
                                   name="health_check_expired_by"
                                   id="health_check_expired_by"
                                   type="date"
                                   value={user.health_check_expired_by}>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">
                            <label for="health_and_safety_training_expired_by">DATA WAŻNOŚCI SZKOLENIA BHP</label>
                        </th>
                        <td class="w-1/2 text-main-black font-semibold pl-5">
                            <input class="w-full"
                                   name="health_and_safety_training_expired_by"
                                   id="health_and_safety_training_expired_by"
                                   type="date"
                                   value={user.health_and_safety_training_expired_by}>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
{/if}