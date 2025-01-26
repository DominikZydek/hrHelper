<script>
    export let data
    export let onClick
</script>

<ul class="flex flex-col divide-y divide-main-gray">
    {#each data.users as user}
        <li class="flex mx-10 py-6 items-center cursor-pointer" on:click={() => onClick(user)}>
            <div class="flex items-center gap-5 w-1/2">
                <img class="h-16 w-16" src="favicon.png" alt="">
                <div>
                    <p>{user.first_name} {user.last_name}</p>
                    <p>{user.email}</p>
                </div>
            </div>
            <div class="w-1/2">
                <p>{user.job_title}</p>
                <p>{#each user.groups as group}{group.name + " "}{/each}</p>
                <p>{user.employed_from}</p>
            </div>
        </li>
    {/each}
</ul>