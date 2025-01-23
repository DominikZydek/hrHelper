<script>
    export let data
</script>

<ul class="flex flex-col divide-y divide-main-gray">
    {#each data.employees as employee}
        <li class="flex mx-10 py-6 items-center">
            <div class="flex items-center gap-5 w-1/2">
                <img class="h-16 w-16" src="favicon.png" alt="">
                <div>
                    <p>{employee.firstName} {employee.lastName}</p>
                    <p>{employee.email}</p>
                </div>
            </div>
            <div class="w-1/2">
                <p>{employee.jobTitle}</p>
                <p>{#each employee.groups as group}{group.name} {/each}</p>
                <p>{employee.employedSince}</p>
            </div>
        </li>
    {/each}
</ul>