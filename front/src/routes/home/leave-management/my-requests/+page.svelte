<script>
    import {getStatusInfo} from "../../../../utils/getStatusInfo.js";
    import Searchbar from "../../../../components/Searchbar.svelte";
    import {icons} from "../../../../stores/icons.js";
    import {getContext} from "svelte";

    export let data
    let { onClick } = getContext('leave-management')

    let tableRequests = data.me.leave_requests
    let displayedRequests = tableRequests

    const handleFilteredDataChange = (filteredData) => {
        displayedRequests = filteredData
    }
</script>

<div class="flex-1 p-4">
    <div class="flex items-center gap-8 mb-4">
        <p class="font-semibold text-2xl text-main-app">Moje wnioski</p>
        <div class="flex-1">
            <Searchbar placeholderText="Szukaj wniosku..." searchData={data.me.leave_requests} onFilteredDataChange={handleFilteredDataChange}/>
        </div>
    </div>
    <table class="w-full text-left border shadow-xl rounded-lg overflow-hidden">
        <thead>
        <tr class="bg-blue-100 text-main-gray">
            <th class="px-4 py-3">Typ urlopu</th>
            <th class="px-4 py-3">Termin urlopu</th>
            <th class="px-4 py-3 text-center">Dni</th>
            <th class="px-4 py-3 text-center">Status</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-main-gray">
        {#each displayedRequests as leaveRequest}
            {@const statusInfo = getStatusInfo(leaveRequest.status)}
            <tr class="cursor-pointer hover:bg-auxiliary-gray" on:click={() => onClick(leaveRequest)}>
                <td class="px-4 py-3">{leaveRequest.leave_type.name}</td>
                <td class="px-4 py-3">{new Date(leaveRequest.date_from).toLocaleDateString()} - {new Date(leaveRequest.date_to).toLocaleDateString()}</td>
                <td class="px-4 py-3 text-center">
                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full font-medium bg-blue-100 text-main-app">
                        {leaveRequest.days_count}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center">
                        <div class="flex gap-2 items-center px-3 py-1 rounded-full {statusInfo.class}">
                            <p class="font-semibold">{statusInfo.message}</p>
                            <svelte:component size="1.5rem" this={$icons[statusInfo.icon]} />
                        </div>
                    </div>
                </td>
            </tr>
        {/each}
        </tbody>
    </table>
</div>