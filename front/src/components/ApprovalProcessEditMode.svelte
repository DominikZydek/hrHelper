<script>
    import Circle from 'svelte-material-icons/Circle.svelte'
    import DotsVertical from 'svelte-material-icons/DotsVertical.svelte'
    import Check from 'svelte-material-icons/Check.svelte'
    import CircleOutline from 'svelte-material-icons/CircleOutline.svelte'
    import Plus from 'svelte-material-icons/Plus.svelte'
    import Delete from 'svelte-material-icons/Delete.svelte'
    import GroupBadge from "./GroupBadge.svelte";
    import Popup from "./Popup.svelte";
    import EmployeeList from "./EmployeeList.svelte";
    import {superForm} from "sveltekit-superforms";

    export let user
    export let allUsers

    let showEmployeeList = false
    let newStepPosition = null
    const toggleEmployeeList = () => {
        showEmployeeList = !showEmployeeList
    }
    const onAddStepClick = (position) => {
        newStepPosition = position
        toggleEmployeeList()
    }

    const onSelectUser = (selectedUser) => {
        const newSteps = [...user.approval_process.steps]

        newSteps.splice(newStepPosition, 0, {
            order: newStepPosition + 1,
            approver: selectedUser
        })

        // update next steps' order
        for (let i = newStepPosition + 1; i < newSteps.length; i++) {
            newSteps[i].order = i + 1
        }

        user.approval_process.steps = newSteps
        user = user

        // close popup
        toggleEmployeeList()
        newStepPosition = null
    }

    const removeStep = (orderToRemove) => {
        const newSteps = user.approval_process.steps
            .filter(step => step.order !== orderToRemove)
            .map((step, newIndex) => ({
                ...step,
                order: newIndex + 1
            }));

        user.approval_process.steps = newSteps
        user = user
    }

    // declare expected data structure
    const { form, enhance } = superForm({
        data: {
            approval_process: Number(user.approval_process.id),
            steps: user.approval_process.steps.map(step => ({
                order: step.order,
                approver: Number(step.approver.id)
            }))
        }
    }, {
        dataType: 'json'
    })

    // reactive form data
    $: $form = {
        approval_process: Number(user.approval_process.id),
            steps: user.approval_process.steps.map(step => ({
            order: step.order,
            approver: Number(step.approver.id)
        }))
    }

</script>

<form method="POST" action="?/updateApprovalProcess" use:enhance
      class="flex flex-col w-full">
    <!-- first step -->
    <div class="flex items-center">
        <div class="flex items-center justify-center w-16">
            <Circle class="text-main-black" size="2rem" />
        </div>
        <div class="flex items-center gap-5 flex-1">
            <img class="h-16 w-16" src="favicon.png" alt="">
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p>{user.first_name} {user.last_name}</p>
                        <p>{user.email}</p>
                    </div>
                    <div class="text-right">
                        <p>{user.job_title}</p>
                        <div class="flex gap-2 justify-end">
                            {#each user.groups as group}
                                <GroupBadge {group} />
                            {/each}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- separator -->
    <div class="flex py-2">
        <div class="flex items-center justify-center w-16">
            <DotsVertical class="text-main-black" size="2rem" />
        </div>
        <div class="flex-1 flex items-center">
            <button class="text-main-app flex items-center gap-2" type="button"
                    on:click={() => onAddStepClick(0)}>
                <Plus size="1.25rem" />
                Dodaj krok
            </button>
        </div>
    </div>

    <!-- middle steps -->
    {#each user.approval_process.steps.slice(0, -1) as step, index}
        <div class="flex items-center">
            <div class="flex items-center justify-center w-16">
                <CircleOutline class="text-main-black" size="2rem" />
            </div>
            <div class="flex items-center gap-5 flex-1">
                <img class="h-16 w-16" src="favicon.png" alt="">
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <p>{step.approver.first_name} {step.approver.last_name}</p>
                            <p>{step.approver.email}</p>
                        </div>
                        <div class="flex items-center">
                            <button on:click={() => removeStep(step.order)} type="button"
                                    class="flex gap-1 items-center bg-accent-red text-main-white font-semibold h-8 px-4">
                                <Delete class="" />
                                Usuń krok
                            </button>
                        </div>
                        <div class="text-right">
                            <p>{step.approver.job_title}</p>
                            <div class="flex gap-2 justify-end">
                                {#each step.approver.groups as group}
                                    <GroupBadge {group} />
                                {/each}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- separator -->
        <div class="flex py-2">
            <div class="flex items-center justify-center w-16">
                <DotsVertical class="text-main-black" size="2rem" />
            </div>
            <div class="flex-1 flex items-center">
                <button class="text-main-app flex items-center gap-2" type="button"
                        on:click={() => onAddStepClick(index + 1)}>
                    <Plus size="1.25rem" />
                    Dodaj krok
                </button>
            </div>
        </div>
    {/each}

    <!-- last step -->
    {#if user.approval_process.steps.length > 0}
        <div class="flex items-center">
            <div class="flex items-center justify-center w-16">
                <Check class="text-main-black" size="2rem" />
            </div>
            <div class="flex items-center gap-5 flex-1">
                <img class="h-16 w-16" src="favicon.png" alt="">
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <p>
                                {user.approval_process.steps[user.approval_process.steps.length - 1].approver.first_name}
                                {user.approval_process.steps[user.approval_process.steps.length - 1].approver.last_name}
                            </p>
                            <p>
                                {user.approval_process.steps[user.approval_process.steps.length - 1].approver.email}
                            </p>
                        </div>
                        <div class="flex items-center">
                            <button on:click={() => removeStep(user.approval_process.steps[user.approval_process.steps.length - 1].order)} type="button"
                                    class="flex gap-1 items-center bg-accent-red text-main-white font-semibold h-8 px-4">
                                <Delete class="" />
                                Usuń krok
                            </button>
                        </div>
                        <div class="text-right">
                            <p>
                                {user.approval_process.steps[user.approval_process.steps.length - 1].approver.job_title}
                            </p>
                            <div class="flex gap-2 justify-end">
                                {#each user.approval_process.steps[user.approval_process.steps.length - 1].approver.groups as group}
                                    <GroupBadge {group} />
                                {/each}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
    <div class="flex self-end">
        <button type="submit"
                class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4 mt-4">
            <Check class="" />
            Zapisz zmiany
        </button>
    </div>
</form>

{#if showEmployeeList}
    <Popup title="Wybierz pracownika" togglePopup={() => toggleEmployeeList()}>
        <EmployeeList users={allUsers} onClick={onSelectUser}/>
    </Popup>
{/if}