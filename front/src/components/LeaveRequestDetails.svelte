<script>
    import {icons} from "../stores/icons.js";
    import Circle from 'svelte-material-icons/Circle.svelte'
    import CircleOutline from 'svelte-material-icons/CircleOutline.svelte'
    import DotsHorizontal from 'svelte-material-icons/DotsHorizontal.svelte'
    export let leaveRequest
    export let user

    $: rejectionStep = leaveRequest.status === 'REJECTED'
        ? leaveRequest.approval_steps_history.find(step => step.status === 'REJECTED')
        : null

    $: statusMessages = {
        'DRAFT': 'Wersja robocza',
        'IN_PROGRESS': 'W trakcie',
        'APPROVED': 'Zatwierdzony',
        'REJECTED': `Odrzucony przez ${rejectionStep?.approver.first_name} ${rejectionStep?.approver.last_name}`,
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
    <div>
        <p>{leaveRequest.leave_type.name}</p>
        <p>{leaveRequest.reason}</p>
        <p>{new Date(leaveRequest.date_from).toLocaleDateString()} - {new Date(leaveRequest.date_to).toLocaleDateString()} ({leaveRequest.days_count} dni)</p>
        <div class="flex gap-2 items-center {statusClasses[leaveRequest.status]}">
            <p class="font-semibold text-lg">
                {statusMessages[leaveRequest.status]}
            </p>
            <svelte:component size="1.75rem" this={$icons[statusIcons[leaveRequest.status]]} />
        </div>
        {#if leaveRequest.status === 'REJECTED' && rejectionStep.comment}
            <p>Powód odrzucenia:</p>
            <p>{rejectionStep.comment}</p>
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