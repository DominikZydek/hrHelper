<script>
    import {getStatusInfo} from "../utils/getStatusInfo.js";
    import {icons} from "../stores/icons.js";
    export let leaveRequests
    export let onClick
</script>

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
    {#each leaveRequests as leaveRequest}
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