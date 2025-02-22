<script>
    import Calendar from '@event-calendar/core'
    import DayGrid from '@event-calendar/day-grid'
    import Popup from "../../../components/Popup.svelte";
    import ApprovalProcess from "../../../components/ApprovalProcess.svelte";

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

    let selectedRequest = null
    const onClick = (request) => {
        selectedRequest = request
        console.log(request)
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
                    email: 'anna.nowak@company.com'
                },
                status: 'ACCEPTED',
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
                            email: 'basia.kowalska@company.com'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com'
                        }
                    },
                    {
                        order: 3,
                        approver: {
                            id: 11,
                            first_name: 'Marek',
                            last_name: 'Jankowski',
                            email: 'marek.jankowski@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 1
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
                    email: 'piotr.wisniewski@company.com'
                },
                status: 'ACCEPTED',
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
                            email: 'basia.kowalska@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 1
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
                            email: 'basia.kowalska@company.com'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 2
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
                    email: 'tomasz.kowalczyk@company.com'
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
                            email: 'basia.kowalska@company.com'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 1
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
                    email: 'katarzyna.zielinska@company.com'
                },
                status: 'PENDING',
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
                            email: 'basia.kowalska@company.com'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 1
        },
        {
            id: 6,
            leave_type: {
                id: 1,
                name: 'Urlop wypoczynkowy',
                limit_per_year: 26,
                requires_replacement: true,
                min_notice_days: 3,
                can_be_cancelled: true
            },
            date_from: '2025-07-01',
            date_to: '2025-07-21',
            days_count: 15,
            reason: 'Urlop letni',
            comment: null,
            status: 'DRAFT',
            replacement: null,
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com'
                        }
                    },
                    {
                        order: 3,
                        approver: {
                            id: 11,
                            first_name: 'Marek',
                            last_name: 'Jankowski',
                            email: 'marek.jankowski@company.com'
                        }
                    }
                ]
            },
            current_approval_step: null
        },
        {
            id: 7,
            leave_type: {
                id: 2,
                name: 'Urlop na żądanie',
                limit_per_year: 4,
                requires_replacement: true,
                min_notice_days: 0,
                can_be_cancelled: false
            },
            date_from: '2025-08-05',
            date_to: '2025-08-05',
            days_count: 1,
            reason: 'Ważne sprawy rodzinne',
            comment: 'Pilne',
            status: 'APPROVED',
            replacement: {
                user: {
                    id: 7,
                    first_name: 'Marcin',
                    last_name: 'Wojciechowski',
                    email: 'marcin.wojciechowski@company.com'
                },
                status: 'ACCEPTED',
                comment: 'Ok'
            },
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 1
        },
        {
            id: 8,
            leave_type: {
                id: 1,
                name: 'Urlop wypoczynkowy',
                limit_per_year: 26,
                requires_replacement: true,
                min_notice_days: 3,
                can_be_cancelled: true
            },
            date_from: '2025-09-15',
            date_to: '2025-09-26',
            days_count: 10,
            reason: 'Wyjazd do Włoch',
            comment: null,
            status: 'CANCELLED',
            replacement: {
                user: {
                    id: 8,
                    first_name: 'Agnieszka',
                    last_name: 'Dąbrowska',
                    email: 'agnieszka.dabrowska@company.com'
                },
                status: 'ACCEPTED',
                comment: 'Potwierdzam'
            },
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 2
        },
        {
            id: 9,
            leave_type: {
                id: 4,
                name: 'Urlop szkoleniowy',
                limit_per_year: 6,
                requires_replacement: true,
                min_notice_days: 5,
                can_be_cancelled: true
            },
            date_from: '2025-10-10',
            date_to: '2025-10-11',
            days_count: 2,
            reason: 'Konferencja JS',
            comment: 'Konferencja w Krakowie',
            status: 'APPROVED',
            replacement: {
                user: {
                    id: 9,
                    first_name: 'Kamil',
                    last_name: 'Witkowski',
                    email: 'kamil.witkowski@company.com'
                },
                status: 'ACCEPTED',
                comment: 'Zgadzam się'
            },
            approval_process: {
                steps: [
                    {
                        order: 1,
                        approver: {
                            id: 5,
                            first_name: 'Basia',
                            last_name: 'Kowalska',
                            email: 'basia.kowalska@company.com'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 2
        },
        {
            id: 10,
            leave_type: {
                id: 1,
                name: 'Urlop wypoczynkowy',
                limit_per_year: 26,
                requires_replacement: true,
                min_notice_days: 3,
                can_be_cancelled: true
            },
            date_from: '2025-12-23',
            date_to: '2025-12-31',
            days_count: 7,
            reason: 'Urlop świąteczny',
            comment: null,
            status: 'IN_PROGRESS',
            replacement: {
                user: {
                    id: 10,
                    first_name: 'Monika',
                    last_name: 'Lewandowska',
                    email: 'monika.lewandowska@company.com'
                },
                status: 'ACCEPTED',
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
                            email: 'basia.kowalska@company.com'
                        }
                    },
                    {
                        order: 2,
                        approver: {
                            id: 8,
                            first_name: 'Michał',
                            last_name: 'Kowalski',
                            email: 'michal.kowalski@company.com'
                        }
                    },
                    {
                        order: 3,
                        approver: {
                            id: 11,
                            first_name: 'Marek',
                            last_name: 'Jankowski',
                            email: 'marek.jankowski@company.com'
                        }
                    }
                ]
            },
            current_approval_step: 2
        }
    ];

    // TODO: this is for tests
    $: componentReadySelectedRequest = {
        first_name: data.user.first_name,
        last_name: data.user.last_name,
        email: data.user.email,
        groups: data.user.groups,
        approval_process: {
            ...selectedRequest?.approval_process,
            steps: selectedRequest?.approval_process?.steps?.map(step => ({
                ...step,
                approver: {
                    ...step.approver,
                    groups: data.user.groups
                }
            }))
        }
    }
</script>

<div class="w-full h-full flex">
    <div class="border px-5 py-2.5 shadow-xl overflow-auto">
        <p class="font-semibold text-2xl text-main-app">Twoje wnioski urlopowe</p>
        <ul class="flex flex-col divide-y divide-main-gray">
            {#each leaveRequests as leaveRequest}
                <li on:click={() => onClick(leaveRequest)}>
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
        <ApprovalProcess user={componentReadySelectedRequest}/>
    </Popup>
{/if}