<script>
    import Circle from 'svelte-material-icons/Circle.svelte'
    import DotsVertical from 'svelte-material-icons/DotsVertical.svelte'
    import Check from 'svelte-material-icons/Check.svelte'
    import CircleOutline from 'svelte-material-icons/CircleOutline.svelte'
    import GroupBadge from "./GroupBadge.svelte";
    export let user
</script>

<div class="flex flex-col w-full">
    <!-- first step -->
    <div class="flex items-center">
        <div class="flex items-center justify-center w-1/5">
            <Circle class="text-main-black" size="2rem" />
        </div>
        <div class="flex items-center gap-5 w-2/5">
            <img class="h-16 w-16" src="favicon.png" alt="">
            <div>
                <p>{user.first_name} {user.last_name}</p>
                <p>{user.email}</p>
            </div>
        </div>
        <div class="w-2/5">
            <p>{user.job_title}</p>
            <div class="flex gap-2">
                {#each user.groups as group}
                    <GroupBadge {group} />
                {/each}
            </div>
        </div>
    </div>

    <!-- separator -->
    <div class="flex py-2">
        <div class="flex items-center justify-center w-1/5">
            <DotsVertical class="text-main-black" size="2rem" />
        </div>
        <div class="w-4/5"></div>
    </div>

    <!-- middle steps -->
    {#each user.approval_process.steps.slice(0, -1) as step, index}
        <div class="flex items-center">
            <div class="flex items-center justify-center w-1/5">
                <CircleOutline class="text-main-black" size="2rem" />
            </div>
            <div class="flex items-center gap-5 w-2/5">
                <img class="h-16 w-16" src="favicon.png" alt="">
                <div>
                    <p>{step.approver.first_name} {step.approver.last_name}</p>
                    <p>{step.approver.email}</p>
                </div>
            </div>
            <div class="w-2/5">
                <p>{step.approver.job_title}</p>
                <div class="flex gap-2">
                    {#each step.approver.groups as group}
                        <GroupBadge {group} />
                    {/each}
                </div>
            </div>
        </div>

        <!-- separator div -->
        <div class="flex py-2">
            <div class="flex items-center justify-center w-1/5">
                <DotsVertical class="text-main-black" size="2rem" />
            </div>
            <div class="w-4/5"></div>
        </div>
    {/each}

    <!-- last step -->
    {#if user.approval_process.steps.length > 0}
        <div class="flex items-center">
            <div class="flex items-center justify-center w-1/5">
                <Check class="text-main-black" size="2rem" />
            </div>
            <div class="flex items-center gap-5 w-2/5">
                <img class="h-16 w-16" src="favicon.png" alt="">
                <div>
                    <p>
                        {user.approval_process.steps[user.approval_process.steps.length - 1].approver.first_name}
                        {user.approval_process.steps[user.approval_process.steps.length - 1].approver.last_name}
                    </p>
                    <p>
                        {user.approval_process.steps[user.approval_process.steps.length - 1].approver.email}
                    </p>
                </div>
            </div>
            <div class="w-2/5">
                <p>
                    {user.approval_process.steps[user.approval_process.steps.length - 1].approver.job_title}
                </p>
                <div class="flex gap-2">
                    {#each user.approval_process.steps[user.approval_process.steps.length - 1].approver.groups as group}
                        <GroupBadge {group} />
                    {/each}
                </div>
            </div>
        </div>
    {/if}
</div>