<script>
    import GroupBadge from "../../components/GroupBadge.svelte";
    import AccountCircle from 'svelte-material-icons/AccountCircle.svelte'
    import Target from 'svelte-material-icons/Target.svelte'
    import CalendarMonth from 'svelte-material-icons/CalendarMonth.svelte'
    import CalendarMultiselect from 'svelte-material-icons/CalendarMultiselect.svelte'
    import NewspaperVariantMultiple from 'svelte-material-icons/NewspaperVariantMultipleOutline.svelte'
    import TriangleSmallDown from 'svelte-material-icons/TriangleSmallDown.svelte'
    import TriangleSmallUp from 'svelte-material-icons/TriangleSmallUp.svelte'
    import Dropdown from "../../components/Dropdown.svelte";

    export let data

    let mode = 'user'
    const changeMode = (newMode) => {
        mode = newMode
    }

    let expandedTargets = new Set()

    const toggleTarget = (target) => {
        if (expandedTargets.has(target)) {
            expandedTargets.delete(target)
        } else {
            expandedTargets.add(target)
        }
        expandedTargets = expandedTargets
    }

    const targets = [
        {
            id: 1,
            name: 'Przykładowy target 1',
            completed: false,
            due_date: '2025-06-01',
            subtargets: [
                {
                    id: 2,
                    name: 'Przykładowy subtarget 1 targetu 1',
                    completed: true,
                    due_date: '2025-06-01',
                    subtargets: null
                },
                {
                    id: 3,
                    name: 'Przykładowy subtarget 2 targetu 1',
                    completed: false,
                    due_date: '2025-04-05',
                    subtargets: null
                }
            ],
        },
        {
            id: 4,
            name: 'Przykładowy target 2',
            completed: true,
            due_date: null,
            subtargets: null
        },
        {
            id: 5,
            name: 'Przykładowy target 3',
            completed: false,
            due_date: '2025-07-09',
            subtargets: [
                {
                    id: 6,
                    name: "Przykładowy subtarget 1 targetu 3",
                    completed: false,
                    due_date: '2025-07-09',
                    subtargets: [
                        {
                            id: 7,
                            name: 'Przykładowy subtarget 1 subtargetu 1 targetu 3',
                            completed: false,
                            due_date: '2025-07-09',
                            subtargets: null,
                        }
                    ],
                },
                {
                    id: 8,
                    name: "Przykładowy subtarget 2 targetu 3",
                    completed: true,
                    due_date: '2025-07-01',
                    subtargets: null,
                }
            ],
        }
    ]

    let hoveredTarget = null
    let showTargetDetailsId = null
    let targetTriggers = {}

    const toggleTargetDetails = (id) => {
        showTargetDetailsId = showTargetDetailsId === id ? null : id
    }

    const onTargetHoverStart = (target) => {
        hoveredTarget = target
        toggleTargetDetails(target.id)
    }

    const onTargetHoverEnd = () => {
        hoveredTarget = null
        showTargetDetailsId = null
    }

    const calculateProgress = (target) => {
        // TODO: implement function for displaying progress
    }

    const calculateDueDateInDays = (target) => {
        // TODO: implement function for displaying due date in days
    }
</script>

<div class="p-8">
    <div class="flex justify-between">
        <div class="flex gap-1 items-center text-3xl">
            <p>Witaj,</p>
            <img class="h-10 w-10" src="/favicon.png" alt="">
            <p>{data.user.first_name} {data.user.last_name}</p>
        </div>
        <div class="flex border shadow rounded text-lg">
            <button
                    on:click={() => changeMode('user')}
                    class="p-2 rounded-l border {mode === 'user' ? 'bg-main-app text-main-white' : ''}">
                User</button>
            <button
                    on:click={() => changeMode('supervisor')}
                    class="p-2 border {mode === 'supervisor' ? 'bg-main-app text-main-white' : ''}">
                Supervisor</button>
            <button
                    on:click={() => changeMode('hr')}
                    class="p-2 rounded-r border {mode === 'hr' ? 'bg-main-app text-main-white' : ''}">
                HR</button>
        </div>
    </div>

    <!-- MAIN SECTION -->
    <div class="mt-5 grid grid-cols-6 grid-rows-3 gap-5">
        {#if mode === 'user'}
            <div class="rounded border shadow col-span-2 p-4">
                <div class="flex gap-2 items-center text-main-app mb-2">
                    <AccountCircle size="1.5rem"/>
                    <p class="text-xl font-semibold">Moje dane</p>
                </div>
                <table class="text-left w-full">
                    <tbody>
                    <tr>
                        <th class="font-bold text-main-gray w-1/2">IMIĘ</th>
                        <td class="font-semibold">{data.user.first_name}</td>
                    </tr>
                    <tr>
                        <th class="font-bold text-main-gray w-1/2">NAZWISKO</th>
                        <td class="font-semibold">{data.user.last_name}</td>
                    </tr>
                    <tr>
                        <th class="font-bold text-main-gray w-1/2">STANOWISKO</th>
                        <td class="font-semibold">{data.user.job_title}</td>
                    </tr>
                    <tr>
                        <th class="font-bold text-main-gray w-1/2">E-MAIL</th>
                        <td class="font-semibold">{data.user.email}</td>
                    </tr>
                    <tr>
                        <th class="font-bold text-main-gray w-1/2">NUMER TELEFONU</th>
                        <td class="font-semibold">{data.user.phone_number}</td>
                    </tr>
                    <tr>
                        <th class="font-bold text-main-gray w-1/2">ZESPOŁY</th>
                        <td class="w-1/2 text-main-black font-semibold flex gap-2">
                            {#each data.user.groups as group}
                                <GroupBadge {group} />
                            {/each}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rounded border shadow col-span-2 p-4">
                <div class="flex gap-2 items-center text-main-app mb-2">
                    <Target size="1.5rem"/>
                    <p class="text-xl font-semibold">Cele</p>
                </div>
                <!-- TODO: these are hard coded values -->
                <div>
                    {#each targets as target}
                        <div class="flex items-center">
                            <div class="w-6">
                                {#if target.subtargets}
                                    <button class="flex items-center" on:click={() => toggleTarget(target)}>
                                        {#if expandedTargets.has(target)}
                                            <TriangleSmallUp size="1.5rem"/>
                                        {:else}
                                            <TriangleSmallDown size="1.5rem"/>
                                        {/if}
                                    </button>
                                {/if}
                            </div>
                            <p
                                    bind:this={targetTriggers[target.id]}
                                    on:pointerenter={() => onTargetHoverStart(target)}
                                    on:pointerleave={() => onTargetHoverEnd()}>{target.name}</p>
                            <input class="ml-2" type="checkbox" checked={target.completed}>
                        </div>

                        {#if target.subtargets && expandedTargets.has(target)}
                            {#each target.subtargets as subtarget}
                                <div class="flex items-center pl-4">
                                    <div class="w-6">
                                        {#if subtarget.subtargets}
                                            <button class="flex items-center" on:click={() => toggleTarget(subtarget)}>
                                                {#if expandedTargets.has(subtarget)}
                                                    <TriangleSmallUp size="1.5rem"/>
                                                {:else}
                                                    <TriangleSmallDown size="1.5rem"/>
                                                {/if}
                                            </button>
                                        {/if}
                                    </div>
                                    <p
                                            bind:this={targetTriggers[subtarget.id]}
                                            on:pointerenter={() => onTargetHoverStart(subtarget)}
                                            on:pointerleave={() => onTargetHoverEnd()}>{subtarget.name}</p>
                                    <input class="ml-2" type="checkbox" checked={subtarget.completed}>
                                </div>

                                {#if subtarget.subtargets && expandedTargets.has(subtarget)}
                                    {#each subtarget.subtargets as subsubtarget}
                                        <div class="flex items-center pl-8">
                                            <div class="w-6"></div>
                                            <p
                                                    bind:this={targetTriggers[subsubtarget.id]}
                                                    on:pointerenter={() => onTargetHoverStart(subsubtarget)}
                                                    on:pointerleave={() => onTargetHoverEnd()}>{subsubtarget.name}</p>
                                            <input class="ml-2" type="checkbox" checked={subsubtarget.completed}>
                                        </div>

                                        {#if showTargetDetailsId === subsubtarget.id}
                                            <Dropdown triggerElement={targetTriggers[subsubtarget.id]} toggleDropdown={() => toggleTargetDetails(subsubtarget.id)}>
                                                <div class="p-4">
                                                    <p>Hello {subsubtarget.id}</p>
                                                </div>
                                            </Dropdown>
                                        {/if}
                                    {/each}
                                {/if}

                                {#if showTargetDetailsId === subtarget.id}
                                    <Dropdown triggerElement={targetTriggers[subtarget.id]} toggleDropdown={() => toggleTargetDetails(subtarget.id)}>
                                        <div class="p-4">
                                            <p>Hello {subtarget.id}</p>
                                        </div>
                                    </Dropdown>
                                {/if}
                            {/each}
                        {/if}

                        {#if showTargetDetailsId === target.id}
                            <Dropdown triggerElement={targetTriggers[target.id]} toggleDropdown={() => toggleTargetDetails(target.id)}>
                                <div class="p-4">
                                    <p>Hello {target.id}</p>
                                </div>
                            </Dropdown>
                        {/if}
                    {/each}
                </div>
            </div>
            <div class="rounded border shadow col-span-2 p-4">
                <div class="flex gap-2 items-center text-main-app mb-2">
                    <CalendarMonth size="1.5rem"/>
                    <p class="text-xl font-semibold">Ważne daty</p>
                </div>
            </div>
            <div class="rounded border shadow col-span-6 p-4">
                <div class="flex gap-2 items-center text-main-app mb-2">
                    <CalendarMultiselect size="1.5rem"/>
                    <p class="text-xl font-semibold">Moje wnioski urlopowe</p>
                </div>
            </div>
            <div class="rounded border shadow col-span-6 p-4">
                <div class="flex gap-2 items-center text-main-app mb-2">
                    <NewspaperVariantMultiple size="1.5rem"/>
                    <p class="text-xl font-semibold">Aktualności</p>
                </div>
            </div>
        {/if}

        {#if mode === 'supervisor'}
            <div class="rounded border shadow col-span-2">
                <p>Wydajność zespołu</p>
            </div>
            <div class="rounded border shadow col-span-2">
                <p>???</p>
            </div>
            <div class="rounded border shadow col-span-2">
                <p>Rozwój i szkolenia</p>
            </div>
            <div class="rounded border shadow col-span-6">
                <p>Wnioski urlopowe zespołu</p>
            </div>
            <div class="rounded border shadow col-span-6">
                <p>Analiza czasu pracy</p>
            </div>
        {/if}

        {#if mode === 'hr'}
            <div class="rounded border shadow col-span-2">
                <p>Wskaźniki rekrutacyjne</p>
            </div>
            <div class="rounded border shadow col-span-2">
                <p>Analiza wynagrodzeń</p>
            </div>
            <div class="rounded border shadow col-span-2">
                <p>???</p>
            </div>
            <div class="rounded border shadow col-span-6">
                <p>Wnioski urlopowe firmy / informacje o dniach urlopowych pracowników</p>
            </div>
            <div class="rounded border shadow col-span-6">
                <p>Raporty / analityka HR</p>
            </div>
        {/if}
    </div>
</div>