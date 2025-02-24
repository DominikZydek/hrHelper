<script>
    import {icons} from "../stores/icons.js";
    import Circle from 'svelte-material-icons/Circle.svelte'
    import CircleOutline from 'svelte-material-icons/CircleOutline.svelte'
    import ChevronDown from 'svelte-material-icons/ChevronDown.svelte'
    import ChevronUp from 'svelte-material-icons/ChevronUp.svelte'
    import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte'
    import EmployeeList from "./EmployeeList.svelte";
    import GroupBadge from "./GroupBadge.svelte";
    import Dropdown from "./Dropdown.svelte";
    export let leaveRequest
    export let user

    let openDropdownId = null
    const toggleDropdown = (id) => {
        openDropdownId = openDropdownId === id ? null : id
    }

    let rejectionTrigger = null
    let replacementTrigger = null

    $: rejectionStep = leaveRequest.status === 'REJECTED'
        ? leaveRequest.approval_steps_history.find(step => step.status === 'REJECTED')
        : null

    $: statusMessages = {
        'DRAFT': 'Wersja robocza',
        'IN_PROGRESS': 'W trakcie',
        'APPROVED': 'Zatwierdzony',
        'REJECTED': 'Odrzucony',
        'CANCELLED': 'Anulowany'
    }

    const statusClasses = {
        'DRAFT': 'text-main-gray',
        'IN_PROGRESS': 'text-accent-orange',
        'APPROVED': 'text-accent-green',
        'REJECTED': 'text-accent-red',
        'CANCELLED': 'text-main-gray'
    }

    const statusIcons = {
        'DRAFT': 'PencilOutline',
        'IN_PROGRESS': 'ProgressClock',
        'APPROVED': 'CheckboxMarkedCircleOutline',
        'REJECTED': 'CloseCircleOutline',
        'CANCELLED': 'BlockHelper'
    }
</script>

<div>
   <div class="relative w-full">
       <div class="{statusClasses[leaveRequest.status]} flex gap-2 items-center">
           <p class="font-semibold text-lg">
               {statusMessages[leaveRequest.status]}
           </p>
           <svelte:component size="1.75rem" this={$icons[statusIcons[leaveRequest.status]]} />
           {#if leaveRequest.status === 'REJECTED' && rejectionStep.comment}
               <div class="text-main-black">
                   <button type="button" bind:this={rejectionTrigger} class="flex items-center"
                           on:click={() => toggleDropdown('rejection')}>
                       {#if openDropdownId !== 'rejection'}
                           <ChevronDown class="text-main-gray" size="1.75rem"/>
                       {:else}
                           <ChevronUp class="text-main-gray" size="1.75rem" />
                       {/if}
                   </button>
                   {#if openDropdownId === 'rejection'}
                       <Dropdown triggerElement={rejectionTrigger} toggleDropdown={() => toggleDropdown('rejection')}>
                           <div class="p-4">
                               <p class="font-semibold">Wniosek odrzucony przez:</p>
                               <div class="flex items-center gap-5 flex-1">
                                   <img class="h-16 w-16" src="/favicon.png" alt="">
                                   <div class="flex-1">
                                       <div class="flex gap-10 items-start">
                                           <div>
                                               <p>{rejectionStep.approver.first_name} {rejectionStep.approver.last_name}</p>
                                               <p>{rejectionStep.approver.email}</p>
                                           </div>
                                           <div class="text-right">
                                               <p>{rejectionStep.approver.job_title}</p>
                                               <div class="flex gap-2 justify-end">
                                                   {#each rejectionStep.approver.groups as group}
                                                       <GroupBadge {group} />
                                                   {/each}
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <p class="font-semibold">Powód odrzucenia: </p>
                               <p>{rejectionStep.comment}</p>
                           </div>
                       </Dropdown>
                   {/if}
               </div>
           {/if}
       </div>
   </div>
    <div>
        <p>{leaveRequest.leave_type.name}</p>
        <p>{leaveRequest.reason}</p>
        <p>{new Date(leaveRequest.date_from).toLocaleDateString()} - {new Date(leaveRequest.date_to).toLocaleDateString()} ({leaveRequest.days_count} dni)</p>
        {#if leaveRequest.leave_type.requires_replacement && leaveRequest.replacement}
            <p class="inline-block">Zastępstwo: </p>
            <div class="relative inline-block">
                <div class="{statusClasses[leaveRequest.replacement.status]} flex gap-2 items-center">
                    <p class="font-semibold">
                        {statusMessages[leaveRequest.replacement.status]}
                    </p>
                    <svelte:component size="1.5rem" this={$icons[statusIcons[leaveRequest.replacement.status]]} />
                    <div class="text-main-black">
                        <button type="button" bind:this={replacementTrigger} class="flex items-center"
                                on:click={() => toggleDropdown('replacement')}>
                            {#if openDropdownId !== 'replacement'}
                                <ChevronDown class="text-main-gray" size="1.5rem"/>
                            {:else}
                                <ChevronUp class="text-main-gray" size="1.5rem" />
                            {/if}
                        </button>
                        {#if openDropdownId === 'replacement'}
                            <Dropdown triggerElement={replacementTrigger} toggleDropdown={() => toggleDropdown('replacement')}>
                                <div class="p-4">
                                    <p class="font-semibold">Osoba wyznaczona do zastępstwa:</p>
                                    <div class="flex items-center gap-5 flex-1">
                                        <img class="h-16 w-16" src="/favicon.png" alt="">
                                        <div class="flex-1">
                                            <div class="flex gap-10 items-start">
                                                <div>
                                                    <p>{leaveRequest.replacement.user.first_name} {leaveRequest.replacement.user.last_name}</p>
                                                    <p>{leaveRequest.replacement.user.email}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p>{leaveRequest.replacement.user.job_title}</p>
                                                    <div class="flex gap-2 justify-end">
                                                        {#each leaveRequest.replacement.user.groups as group}
                                                            <GroupBadge {group} />
                                                        {/each}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {#if leaveRequest.replacement.comment}
                                        <p class="font-semibold">Komentarz: </p>
                                        <p>{leaveRequest.replacement.comment}</p>
                                    {/if}
                                </div>
                            </Dropdown>
                        {/if}
                    </div>
                </div>
            </div>
        {/if}
    </div>
    <div class="flex">
        <div class="flex flex-col items-center w-48">
            <img class="h-10 w-10" src="/favicon.png" alt="">
            <p>{user.first_name} {user.last_name}</p>
        </div>
        {#each leaveRequest.approval_process.steps as step}
            <div class="flex flex-col items-center w-48">
                <img class="h-10 w-10" src="/favicon.png" alt="">
                <p>{step.approver.first_name} {step.approver.last_name}</p>
            </div>
        {/each}
    </div>
    <div class="flex">
        <div class="flex flex-col items-center w-48">
            <CircleOutline />
        </div>
        {#each leaveRequest.approval_process.steps as step}
            <div class="flex flex-col items-center w-48">
                <CircleOutline />
            </div>
        {/each}
    </div>
</div>