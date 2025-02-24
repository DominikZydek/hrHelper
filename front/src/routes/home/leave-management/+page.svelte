<script>
    import Calendar from '@event-calendar/core'
    import DayGrid from '@event-calendar/day-grid'
    import Popup from "../../../components/Popup.svelte";
    import ApprovalProcess from "../../../components/ApprovalProcess.svelte";
    import LeaveRequestDetails from "../../../components/LeaveRequestDetails.svelte";
    import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte'
    import Dropdown from "../../../components/Dropdown.svelte";

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

    // TODO: this is for tests
    const leaveRequests = [
        {
            id: 1,
            leave_type: {
                id: 1,
                name: 'Urlop wypoczynkowy',
                limit_per_year: 26,
                requires_replacement: true,
                min_notice_days: 3,
                can_be_cancelled: true
            },
            date_from: '2025-02-10',
            date_to: '2025-02-17',
            days_count: 6,
            reason: 'Wyjazd do Egiptu',
            comment: null,
            status: 'IN_PROGRESS',
            replacement: {
                user: {
                    id: 2,
                    first_name: 'Anna',
                    last_name: 'Nowak',
                    email: 'anna.nowak@company.com',
                    groups: [
                        { icon_name: 'ChartGantt', name: 'Management' },
                        { icon_name: 'Briefcase', name: 'Board' }
                    ],
                    job_title: 'HR Manager'
                },
                status: 'APPROVED',
                comment: 'Ok, zastąpię'
            },
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    },
                    {
                        order: 3,
                        approver: {
                            id: 11,
                            first_name: 'Marek',
                            last_name: 'Jankowski',
                            email: 'marek.jankowski@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    }
                ]
            },
            current_approval_step: 1,
            approval_steps_history: []
        },
        {
            id: 2,
            leave_type: {
                id: 2,
                name: 'Urlop na żądanie',
                limit_per_year: 4,
                requires_replacement: true,
                min_notice_days: 0,
                can_be_cancelled: false
            },
            date_from: '2025-02-23',
            date_to: '2025-02-23',
            days_count: 1,
            reason: 'Sprawy osobiste',
            comment: 'Pilne',
            status: 'APPROVED',
            replacement: {
                user: {
                    id: 3,
                    first_name: 'Piotr',
                    last_name: 'Wiśniewski',
                    email: 'piotr.wisniewski@company.com',
                    groups: [
                        { icon_name: 'ChartGantt', name: 'Management' },
                        { icon_name: 'Briefcase', name: 'Board' }
                    ],
                    job_title: 'HR Manager'
                },
                status: 'APPROVED',
                comment: 'Potwierdzam zastępstwo'
            },
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    }
                ]
            },
            current_approval_step: 1,
            approval_steps_history: [
                {
                    step: 1,
                    status: 'APPROVED',
                    comment: 'Zatwierdzam urlop na żądanie',
                    date: '2025-02-23T08:15:00Z',
                    approver: {
                        id: 5,
                        first_name: 'Basia',
                        last_name: 'Kowalska',
                        email: 'basia.kowalska@company.com',
                        groups: [
                            { icon_name: 'ChartGantt', name: 'Management' },
                            { icon_name: 'Briefcase', name: 'Board' }
                        ],
                        job_title: 'HR Manager'
                    }
                }
            ]
        },
        {
            id: 3,
            leave_type: {
                id: 3,
                name: 'Urlop okolicznościowy',
                limit_per_year: 2,
                requires_replacement: false,
                min_notice_days: 1,
                can_be_cancelled: false
            },
            date_from: '2025-03-15',
            date_to: '2025-03-16',
            days_count: 2,
            reason: 'Ślub',
            comment: null,
            status: 'IN_PROGRESS',
            replacement: null,
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    }
                ]
            },
            current_approval_step: 2,
            approval_steps_history: [
                {
                    step: 1,
                    status: 'APPROVED',
                    comment: 'Zatwierdzam urlop okolicznościowy',
                    date: '2025-03-10T11:20:00Z',
                    approver: {
                        id: 5,
                        first_name: 'Basia',
                        last_name: 'Kowalska',
                        email: 'basia.kowalska@company.com',
                        groups: [
                            { icon_name: 'ChartGantt', name: 'Management' },
                            { icon_name: 'Briefcase', name: 'Board' }
                        ],
                        job_title: 'HR Manager'
                    }
                }
            ]
        },
        {
            id: 4,
            leave_type: {
                id: 1,
                name: 'Urlop wypoczynkowy',
                limit_per_year: 26,
                requires_replacement: true,
                min_notice_days: 3,
                can_be_cancelled: true
            },
            date_from: '2025-04-01',
            date_to: '2025-04-14',
            days_count: 10,
            reason: 'Wakacje w górach',
            comment: null,
            status: 'REJECTED',
            replacement: {
                user: {
                    id: 4,
                    first_name: 'Tomasz',
                    last_name: 'Kowalczyk',
                    email: 'tomasz.kowalczyk@company.com',
                    groups: [
                        { icon_name: 'ChartGantt', name: 'Management' },
                        { icon_name: 'Briefcase', name: 'Board' }
                    ],
                    job_title: 'HR Manager'
                },
                status: 'REJECTED',
                comment: 'Nie mogę w tym terminie'
            },
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    }
                ]
            },
            current_approval_step: 1,
            approval_steps_history: [
                {
                    step: 1,
                    status: 'REJECTED',
                    comment: 'Brak dostępnego zastępstwa - zastępująca osoba odrzuciła prośbę',
                    date: '2025-03-28T10:15:00Z',
                    approver: {
                        id: 5,
                        first_name: 'Basia',
                        last_name: 'Kowalska',
                        email: 'basia.kowalska@company.com',
                        groups: [
                            { icon_name: 'ChartGantt', name: 'Management' },
                            { icon_name: 'Briefcase', name: 'Board' }
                        ],
                        job_title: 'HR Manager'
                    }
                }
            ]
        },
        {
            id: 5,
            leave_type: {
                id: 4,
                name: 'Urlop szkoleniowy',
                limit_per_year: 6,
                requires_replacement: true,
                min_notice_days: 5,
                can_be_cancelled: true
            },
            date_from: '2025-05-20',
            date_to: '2025-05-21',
            days_count: 2,
            reason: 'Szkolenie React',
            comment: 'Szkolenie online',
            status: 'IN_PROGRESS',
            replacement: {
                user: {
                    id: 6,
                    first_name: 'Katarzyna',
                    last_name: 'Zielińska',
                    email: 'katarzyna.zielinska@company.com',
                    groups: [
                        { icon_name: 'ChartGantt', name: 'Management' },
                        { icon_name: 'Briefcase', name: 'Board' }
                    ],
                    job_title: 'HR Manager'
                },
                status: 'IN_PROGRESS',
                comment: null
            },
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com',
                            groups: [
                                { icon_name: 'ChartGantt', name: 'Management' },
                                { icon_name: 'Briefcase', name: 'Board' }
                            ],
                            job_title: 'HR Manager'
                        }
                    }
                ]
            },
            current_approval_step: 1,
            approval_steps_history: []
        }
    ];
</script>

<div class="w-full h-full flex">
    <div class="border px-5 py-2.5 shadow-xl overflow-auto">
        <p class="font-semibold text-2xl text-main-app">Twoje wnioski urlopowe</p>
        <ul class="flex flex-col divide-y divide-main-gray">
            {#each leaveRequests as leaveRequest}
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
                    <button
                            type="button"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-app">
                        <DotsHorizontal size="1.25rem" />
                        <span>Pokaż historię wniosku</span>
                    </button>
                    <button
                            type="button"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-accent-orange">
                        <DotsHorizontal size="1.25rem" />
                        <span>Edytuj wniosek</span>
                    </button>
                    <button
                            type="button"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray">
                        <DotsHorizontal size="1.25rem" />
                        <span>Wycofaj wniosek</span>
                    </button>
                </div>
            </Dropdown>
        {/if}
        <LeaveRequestDetails leaveRequest={selectedLeaveRequest} user={data.user} allUsers={data.users}/>
    </Popup>
{/if}