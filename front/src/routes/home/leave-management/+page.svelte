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

    export let data

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
</script>

<div class="w-full h-full flex">
    <div class="border px-5 py-2.5 shadow-xl overflow-auto">
        <p class="font-semibold text-2xl text-main-app">Twoje wnioski urlopowe</p>
        <ul class="flex flex-col divide-y divide-main-gray">
            {#each data.me.leave_requests as leaveRequest}
                <li class="cursor-pointer" on:click={() => onClick(leaveRequest)}>
                    <p>{leaveRequest.leave_type.name}</p>
                    <p>{leaveRequest.reason}</p>
                    <p>{new Date(leaveRequest.date_from).toLocaleDateString()} - {new Date(leaveRequest.date_to).toLocaleDateString()}</p>
                </li>
            {/each}
        </ul>
    </div>
    <div class="flex items-center justify-center flex-1">
        <div class="w-1/2 max-w-5xl">
            <Calendar {plugins} {options} />
        </div>
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