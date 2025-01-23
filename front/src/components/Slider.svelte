<script>
    import Pencil from 'svelte-material-icons/Pencil.svelte'
    import Close from 'svelte-material-icons/Close.svelte'

    export let employee
    export let showSlider
    export let toggleSlider
</script>

{#if showSlider}
    <div class="flex flex-col gap-5 right-0 top-0 h-screen w-1/3 fixed bg-main-white border px-10 py-5 shadow-xl">
        <div class="flex justify-between">
            <div class="flex gap-2 items-center">
                <button class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4">
                    <Pencil class="" />
                    Edytuj
                </button>
                <img class="h-8 w-8" src="favicon.png" alt="">
                <p class="font-semibold">{employee.firstName} {employee.lastName}</p>
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
                        <td class="w-1/2 text-main-black font-semibold">{employee.firstName}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">NAZWISKO</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.lastName}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">PŁEĆ</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.sex}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">ADRES E-MAIL</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.email}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">DATA URODZENIA</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.birthDate}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">NUMER TELEFONU</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.phoneNumber}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">ADRES ZAMIESZKANIA</th>
                        <td class="w-1/2 text-main-black font-semibold">
                            {employee.address.streetName} {employee.address.number}
                            {employee.address.postalCode} {employee.address.city}
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
                        <td class="w-1/2 text-main-black font-semibold">{employee.jobTitle}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">PRZEŁOŻONY</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.reportsTo}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">ZESPOŁY</th>
                        <td class="w-1/2 text-main-black font-semibold">{#each employee.groups as group}{group.name + " "}{/each}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">PROCES AKCEPTACJI</th>
                        <td class="w-1/2 text-main-black font-semibold">XXX</td>
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
                        <td class="w-1/2 text-main-black font-semibold">{employee.typeOfEmployment} ({employee.paidTimeOffDays} dni)</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">WYMIAR PRACY</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.workingTime} etatu</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">DATA ROZPOCZĘCIA UMOWY</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.employedFrom}</td>
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
                        <td class="w-1/2 text-main-black font-semibold">{employee.employedTo || 'Brak'}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">DATA WAŻNOŚCI BADAŃ LEKARSKICH</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.healthCheckExpiredBy}</td>
                    </tr>
                    <tr>
                        <th class="w-1/2 font-bold text-main-gray">DATA WAŻNOŚCI SZKOLENIA BHP</th>
                        <td class="w-1/2 text-main-black font-semibold">{employee.healthAndSafetyTrainingExpiredBy}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{/if}