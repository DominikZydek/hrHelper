<script>
    import Calendar from "@event-calendar/core";
    import Dropdown from "../../../../components/Dropdown.svelte";
    import EmployeeList from "../../../../components/EmployeeList.svelte";
    import Popup from "../../../../components/Popup.svelte";
    import SendOutline from 'svelte-material-icons/SendOutline.svelte'
    import {getStatusInfo} from "../../../../utils/getStatusInfo.js";
    import DayGrid from "@event-calendar/day-grid";
    import Interaction from '@event-calendar/interaction'
    import {getContext} from "svelte";

    export let data
    let { handleEventClick } = getContext('leave-management')

    let allRequests = [...data.me.leave_requests]
    data.me.groups.forEach(group => {
        group.users.forEach(user => {
            if (user.id !== data.me.id && user.leave_requests) {
                allRequests = [...allRequests, ...user.leave_requests];
            }
        });
    });
    // remove duplicates
    let calendarDisplayedRequests = [...new Map(allRequests.map(request =>
        [request.id, request]
    )).values()];

    let companyHolidays = data.me.organization.holidays

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

    const mapLeaveRequestsToCalendarEvents = (requests) => {
        return requests.map(request => ({
            id: request.id,
            allDay: true,
            start: new Date(request.date_from),
            end: new Date(request.date_to),
            title: `${request.user // if user is defined, it's not my request
                ? `${request.user.first_name} ${request.user.last_name} - ${request.leave_type.name}`
                : `${request.leave_type.name} - ${request.reason}`}`,
            backgroundColor: getStatusInfo(request.status).color,
            editable: false
        }))
    }

    // TODO: These are not rendered when choosing options (only mine, only approved)
    const mapCompanyHolidaysToCalendarEvents = (holidays) => {
        return holidays.map(holiday => ({
            id: holiday.id,
            allDay: true,
            start: holiday.date,
            end: holiday.date,
            title: holiday.name,
            backgroundColor: '#2563EB',
            editable: false
        }))
    }

    const handleDataCellClick = (info) => {
        const clickedDate = info.date.toLocaleDateString('en-CA');

        const dateFromInput = document.getElementById('date_from')
        const dateToInput = document.getElementById('date_to')

        if (dateFromInput.value && dateFromInput.value <= clickedDate) {
            dateToInput.value = clickedDate
        } else {
            dateFromInput.value = clickedDate
        }
    }

    const handleNewEventSelection = (info) => {
        const dateFrom = info.start.toLocaleDateString('en-CA')
        const dateTo = info.end.toISOString().split('T')[0] // this has to be this way since the calendar is a day ahead

        const dateFromInput = document.getElementById('date_from')
        const dateToInput = document.getElementById('date_to')

        dateFromInput.value = dateFrom
        dateToInput.value = dateTo
    }

    let showOnlyMyRequestsButtonActive = false
    let showOnlyApprovedRequestsButtonActive = false

    let plugins = [DayGrid, Interaction]
    let options = {
        view: 'dayGridMonth',
        events: [...mapLeaveRequestsToCalendarEvents(calendarDisplayedRequests), ...mapCompanyHolidaysToCalendarEvents(companyHolidays)],
        eventClick: (info) => handleEventClick(info),
        dateClick: (info) => handleDataCellClick(info),
        selectable: true,
        unselectAuto: false,
        select: (info) => handleNewEventSelection(info),
        selectBackgroundColor: '#2563EB',
        locale: 'pl-PL',
        headerToolbar: {
            start: 'prev today next',
            center: 'showOnlyMyRequests showOnlyApprovedRequests',
            end: 'title'
        },
        customButtons: {
            showOnlyMyRequests: {
                text: {html: `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem; vertical-align: middle; margin-right: 5px; display: inline;"><title>eye-outline</title><path d="M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M12,4.5C17,4.5 21.27,7.61 23,12C21.27,16.39 17,19.5 12,19.5C7,19.5 2.73,16.39 1,12C2.73,7.61 7,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C15.76,17.5 19.17,15.36 20.82,12C19.17,8.64 15.76,6.5 12,6.5C8.24,6.5 4.83,8.64 3.18,12Z" /></svg>
                    <span style="vertical-align: middle">Pokaż tylko moje</span>
                `},
                click: () => {
                    if (!showOnlyMyRequestsButtonActive) {
                        calendarDisplayedRequests = calendarDisplayedRequests.filter(request => !request.user)
                    } else {
                        calendarDisplayedRequests = [...new Map(allRequests.map(request =>
                            [request.id, request]
                        )).values()];
                    }

                    showOnlyMyRequestsButtonActive = !showOnlyMyRequestsButtonActive

                    options = {
                        ...options,
                        events: mapLeaveRequestsToCalendarEvents(calendarDisplayedRequests),
                        customButtons: {
                            ...options.customButtons,
                            showOnlyMyRequests: {
                                ...options.customButtons.showOnlyMyRequests,
                                active: showOnlyMyRequestsButtonActive
                            }
                        }
                    }
                }
            },
            showOnlyApprovedRequests: {
                text: {html: `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem; vertical-align: middle; margin-right: 5px; display: inline;"><title>eye-outline</title><path d="M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M12,4.5C17,4.5 21.27,7.61 23,12C21.27,16.39 17,19.5 12,19.5C7,19.5 2.73,16.39 1,12C2.73,7.61 7,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C15.76,17.5 19.17,15.36 20.82,12C19.17,8.64 15.76,6.5 12,6.5C8.24,6.5 4.83,8.64 3.18,12Z" /></svg>
                    <span style="vertical-align: middle">Pokaż tylko zatwierdzone</span>
                `},
                click: () => {
                    if (!showOnlyApprovedRequestsButtonActive) {
                        calendarDisplayedRequests = calendarDisplayedRequests.filter(request => !request.user && request.status === 'APPROVED')
                    } else {
                        calendarDisplayedRequests = [...new Map(allRequests.map(request =>
                            [request.id, request]
                        )).values()];
                    }

                    showOnlyApprovedRequestsButtonActive = !showOnlyApprovedRequestsButtonActive

                    options = {
                        ...options,
                        events: mapLeaveRequestsToCalendarEvents(calendarDisplayedRequests),
                        customButtons: {
                            ...options.customButtons,
                            showOnlyApprovedRequests: {
                                ...options.customButtons.showOnlyApprovedRequests,
                                active: showOnlyApprovedRequestsButtonActive
                            }
                        }
                    }
                }
            }
        },
        buttonText: text => ({...text, today: 'Dziś'}),
        dayHeaderFormat: {weekday: 'long'},
        firstDay: 1
    }

    let showEmployeeList = false
    const toggleEmployeeList = () => {
        showEmployeeList = !showEmployeeList
    }
    let selectedReplacement = null
    const onSelectReplacement = (replacement) => {
        selectedReplacement = replacement
        toggleEmployeeList()
    }

    let selectedLeaveTypeId = data.leaveTypes[0]?.id || null
    $: selectedLeaveType = data.leaveTypes.find(type => type.id === selectedLeaveTypeId)
    $: showReplacementSelect = selectedLeaveType?.requires_replacement === true
</script>

<div class="flex-1 p-4">
    <div class="flex items-center gap-8 mb-4">
        <p class="font-semibold text-2xl text-main-app">Nowy wniosek</p>
    </div>
    <div class="w-3/4 max-w-5xl m-auto">
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
</div>

<div class="flex flex-col gap-2 border py-4 shadow-xl overflow-auto">
    <form id="" action="" method="POST" class="flex flex-col gap-5 px-4">
        <table class="text-left w-full">
            <tbody>
            <tr class="flex flex-col">
                <th class="font-bold text-main-gray">
                    <label for="leave_type">TYP NIEOBECNOŚCI</label>
                </th>
                <td class="text-main-black font-semibold">
                    <select bind:value={selectedLeaveTypeId}
                            class="w-full border border-main-gray rounded"
                            name="leave_type"
                            id="leave_type"
                            type="text">
                        {#each data.leaveTypes as leave_type}
                            <option value={leave_type.id}>{leave_type.name}</option>
                        {/each}
                    </select>
                </td>
            </tr>
            <tr class="flex flex-col">
                <th class="font-bold text-main-gray">
                    <label for="date_from">DATA ROZPOCZĘCIA NIEOBECNOŚCI</label>
                </th>
                <td class="text-main-black font-semibold">
                    <input class="w-full border border-main-gray rounded"
                           name="date_from"
                           id="date_from"
                           type="date">
                </td>
            </tr>
            <tr class="flex flex-col">
                <th class="font-bold text-main-gray">
                    <label for="date_to">DATA ZAKOŃCZENIA NIEOBECNOŚCI</label>
                </th>
                <td class="text-main-black font-semibold">
                    <input class="w-full border border-main-gray rounded"
                           name="date_to"
                           id="date_to"
                           type="date">
                </td>
            </tr>
            <tr class="flex flex-col">
                <th class="font-bold text-main-gray">
                    <label for="reason">POWÓD NIEOBECNOŚCI</label>
                </th>
                <td class="text-main-black font-semibold">
                                <textarea class="border border-main-gray rounded resize-none"
                                          cols="35"
                                          rows="3"
                                          name="reason"
                                          id="reason"></textarea>
                </td>
            </tr>
            <tr class="flex flex-col">
                <th class="font-bold text-main-gray">
                    <label for="comment">KOMENTARZ</label>
                </th>
                <td class="text-main-black font-semibold">
                                <textarea class="border border-main-gray rounded resize-none"
                                          cols="35"
                                          rows="3"
                                          name="comment"
                                          id="comment"></textarea>
                </td>
            </tr>
            {#if showReplacementSelect}
                <tr class="flex flex-col">
                    <th class="font-bold text-main-gray">
                        <label for="replacement_select">OSOBA ZASTĘPUJĄCA</label>
                    </th>
                    <td class="text-main-black font-semibold">
                        <input on:click={() => toggleEmployeeList()}
                               class="w-full border border-main-gray rounded"
                               type="text"
                               id="replacement_select"
                               placeholder={selectedReplacement ? '' : 'Wybierz zastępstwo'}
                               value={selectedReplacement
                                                ? `${selectedReplacement?.first_name} ${selectedReplacement?.last_name}`
                                                : null}>
                        <input name="replacement"
                               id="replacement"
                               type="hidden"
                               value={selectedReplacement?.id}>
                    </td>
                    {#if showEmployeeList}
                        <Popup title="Wybierz zastępstwo" togglePopup={toggleEmployeeList}>
                            <EmployeeList users={data.users} onClick={onSelectReplacement} />
                        </Popup>
                    {/if}
                </tr>
            {/if}
            </tbody>
        </table>
        <button type="submit" form=""
                class="flex gap-1 items-center bg-main-app text-main-white font-semibold h-8 px-4 self-start">
            <SendOutline />
            Wyślij wniosek
        </button>
    </form>
</div>