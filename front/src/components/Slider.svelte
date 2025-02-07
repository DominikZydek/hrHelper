<script>
    import Pencil from 'svelte-material-icons/Pencil.svelte'
    import Close from 'svelte-material-icons/Close.svelte'
    import GroupBadge from "./GroupBadge.svelte";
    import SliderEditMode from "./SliderEditMode.svelte";

    export let user
    export let showSlider
    export let toggleSlider
    export let allUsers
    export let groups

    let showEditMode = false
    const toggleEditMode = () => {
        showEditMode = !showEditMode
    }

    const onSave = (updatedUser) => {
        user = updatedUser
        // api call
    }
</script>

{#if showSlider}
    {#if !showEditMode}
        <div class="flex flex-col gap-5 right-0 top-0 h-screen w-1/3 fixed bg-main-white border px-10 py-5 shadow-xl">
            <div class="flex justify-between">
                <div class="flex gap-2 items-center">
                    <button on:click={() => toggleEditMode()}
                            class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4">
                        <Pencil class="" />
                        Edytuj
                    </button>
                    <img class="h-8 w-8" src="favicon.png" alt="">
                    <p class="font-semibold">{user.first_name} {user.last_name}</p>
                </div>
                <button on:click={() => toggleSlider()}>
                    <Close class="text-main-gray" size="2rem"/>
                </button>
            </div>
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
                                {user.address.street_name} {user.address.street_number}
                                {user.address.postal_code} {user.address.city}
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
                            <th class="w-1/2 font-bold text-main-gray">RODZAJ UMOWY</th>
                            <td class="w-1/2 text-main-black font-semibold pl-5">{user.type_of_employment} ({user.paid_time_off_days} dni)</td>
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
        </div>
    {:else}
        <SliderEditMode {user} {showEditMode} {toggleEditMode} {onSave} {allUsers} {groups}/>
    {/if}
{/if}