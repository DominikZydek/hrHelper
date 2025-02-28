<script>
    import Calendar from '@event-calendar/core'
    import DayGrid from '@event-calendar/day-grid'
    import Popup from "../../../components/Popup.svelte";
    import ApprovalProcess from "../../../components/ApprovalProcess.svelte";
    import LeaveRequestDetails from "../../../components/LeaveRequestDetails.svelte";
    import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte'
    import Dropdown from "../../../components/Dropdown.svelte";
    import {getStatusInfo} from "../../../utils/getStatusInfo.js";
    import {icons} from "../../../stores/icons.js";
    import GroupBadge from "../../../components/GroupBadge.svelte";
    import ArrowULeftTop from 'svelte-material-icons/ArrowULeftTop.svelte'
    import History from 'svelte-material-icons/History.svelte'
    import Pencil from 'svelte-material-icons/Pencil.svelte'
    import FilePlusOutline from 'svelte-material-icons/FilePlusOutline.svelte'
    import FileDocumentOutline from 'svelte-material-icons/FileDocumentOutline.svelte'
    import CalendarMonth from 'svelte-material-icons/CalendarMonth.svelte'
    import ClockTimeFourOutline from 'svelte-material-icons/ClockTimeFourOutline.svelte'
    import Searchbar from "../../../components/Searchbar.svelte";

    export let data

    let allRequests = data.me.leave_requests
    let displayedRequests = allRequests

    const handleFilteredDataChange = (filteredData) => {
        displayedRequests = filteredData
    }

    const usedPaidTimeOffDays = data.me.leave_requests
        .filter(request =>
            request.status === 'APPROVED' &&
            request.leave_type.name === 'Urlop wypoczynkowy'
        )
        .reduce((sum, request) => sum + request.days_count, 0)

    const pendingPaidTimeOffDays = data.me.leave_requests
        .filter(request =>
            ['SENT', 'IN_PROGRESS'].includes(request.status) &&
            request.leave_type.name === 'Urlop wypoczynkowy'
        )
        .reduce((sum, request) => sum + request.days_count, 0)

    const totalPaidTimeOffDays = data.me.paid_time_off_days

    const availablePaidTimeOffDays = totalPaidTimeOffDays - (usedPaidTimeOffDays + pendingPaidTimeOffDays)

    let paidTimeOffIndicator = null
    let showIndicatorDropdown = false
    const toggleIndicatorDropdown = () => {
        showIndicatorDropdown = !showIndicatorDropdown
    }

    let plugins = [DayGrid]
    let options = {
        view: 'dayGridMonth',
        events: [],
        locale: 'pl-PL',
        headerToolbar: {
            start: 'prev today next',
            center: '',
            end: 'title'
        },
        buttonText: text => ({...text, today: 'Dziś'}),
        dayHeaderFormat: {weekday: 'long'},
        firstDay: 1
    }

    let showPopup = false
    const togglePopup = () => {
        showPopup = !showPopup
    }

    let showOptions = false
    const toggleOptions = () => {
        showOptions = !showOptions
    }

    let optionButton = null

    let selectedLeaveRequest = null

    const onClick = (leaveRequest) => {
        selectedLeaveRequest = leaveRequest
        console.log(leaveRequest)
        togglePopup()
    }

    let showLeaveRequestHistory = false
    const toggleLeaveRequestHistory = () => {
        showLeaveRequestHistory = !showLeaveRequestHistory
    }

    let views = ['new-request', 'my-requests', 'calendar', 'approvals']
    let currentView = 'my-requests'
    const changeView = (view) => {
        currentView = view
    }
</script>

<div class="w-full h-full flex">
    <div class="flex flex-col gap-2 border py-4 shadow-xl overflow-auto">
        <p class="text-2xl font-semibold text-main-app mb-2 px-4">Nieobecności</p>
        <button on:click={() => changeView('new-request')}
                type="button"
                class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl">
            <FilePlusOutline size="1.75rem" />
            <span>Nowy wniosek</span>
        </button>
        <button on:click={() => changeView('my-requests')}
                type="button"
                class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl">
            <FileDocumentOutline size="1.75rem" />
            <span>Moje wnioski</span>
        </button>
        <button on:click={() => changeView('calendar')}
                type="button"
                class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl">
            <CalendarMonth size="1.75rem" />
            <span>Kalendarz</span>
        </button>
        <button on:click={() => changeView('approvals')}
                type="button"
                class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl">
            <ClockTimeFourOutline size="1.75rem" />
            <span>Wnioski do rozpatrzenia</span>
        </button>
    </div>
    <div class="flex-1 p-4">

        {#if currentView === 'my-requests'}
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
        {/if}

        {#if currentView === 'calendar'}
            <div class="w-1/2 max-w-5xl">
                <Calendar {plugins} {options} />
                <div bind:this={paidTimeOffIndicator}
                     on:pointerenter={() => toggleIndicatorDropdown()}
                     on:pointerleave={() => toggleIndicatorDropdown()}
                     class="bg-accent-green h-8 mt-8 flex">
                    <div class="bg-accent-red h-full" style="width: {usedPaidTimeOffDays/totalPaidTimeOffDays * 100}%"></div>
                    <div class="bg-accent-yellow h-full" style="width: {pendingPaidTimeOffDays/totalPaidTimeOffDays * 100}%"></div>
                </div>

                {#if showIndicatorDropdown}
                    <Dropdown toggleDropdown={toggleIndicatorDropdown} triggerElement={paidTimeOffIndicator}>
                        <div class="p-4 font-semibold">
                            <p>Łączny wymiar urlopu rocznego: {totalPaidTimeOffDays} dni</p>
                            <p>Wykorzystano: {usedPaidTimeOffDays} dni</p>
                            <p>W trakcie rozpatrywania: {pendingPaidTimeOffDays} dni</p>
                            <p>Dostępne dni urlopowe: {availablePaidTimeOffDays} dni</p>
                        </div>
                    </Dropdown>
                {/if}
            </div>
        {/if}

    </div>
</div>
{#if showPopup}
    <Popup {togglePopup} title="Szczegóły wniosku">
        <svelte:fragment slot="header-right">
            <button type="button" bind:this={optionButton} on:click={() => toggleOptions()}>
                <DotsHorizontal class="text-main-gray" size="2rem"/>
            </button>
        </svelte:fragment>
        {#if showOptions}
            <Dropdown triggerElement={optionButton} toggleDropdown={toggleOptions}>
                <div class="flex flex-col py-2">
                    <button on:click={() => toggleLeaveRequestHistory()}
                            type="button"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-app">
                        <History size="1.25rem" />
                        <span>Pokaż historię wniosku</span>
                    </button>

                    {#if showLeaveRequestHistory}
                        <Popup togglePopup={toggleLeaveRequestHistory} title="Historia wniosku">
                            <ul>
                                {#each selectedLeaveRequest.approval_steps_history as step_history}
                                    {@const stepHistoryStatus = getStatusInfo(step_history.status)}
                                    {@const approver = step_history.approver || data.user}

                                    <li class="flex items-center gap-5 w-full">
                                        <div class="min-w-[200px]">
                                            <p>{new Date(step_history.date).toLocaleString()}</p>
                                            <div class="{stepHistoryStatus.class} flex gap-2 items-center">
                                                <p class="font-semibold">
                                                    {stepHistoryStatus.message}
                                                </p>
                                                <svelte:component size="1.5rem" this={$icons[stepHistoryStatus.icon]} />
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-5 flex-1">
                                            <img class="h-16 w-16" src="/favicon.png" alt="">
                                            <div class="flex-1">
                                                <div class="flex gap-10 items-start w-full">
                                                    <div>
                                                        <p>{approver.first_name} {approver.last_name}</p>
                                                        <p>{approver.email}</p>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <p>{approver.job_title}</p>
                                                        <div class="flex gap-2 justify-end">
                                                            {#each approver.groups as group}
                                                                <GroupBadge {group} />
                                                            {/each}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                {/each}
                            </ul>
                        </Popup>
                    {/if}

                    <button
                            type="button"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-accent-orange">
                        <Pencil size="1.25rem" />
                        <span>Edytuj wniosek</span>
                    </button>
                    <button
                            type="button"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray">
                        <ArrowULeftTop size="1.25rem" />
                        <span>Wycofaj wniosek</span>
                    </button>
                </div>
            </Dropdown>
        {/if}
        <LeaveRequestDetails leaveRequest={selectedLeaveRequest} user={data.user}/>
    </Popup>
{/if}