<script>
    export let data
</script>

<div>
    <p>Zalogowano jako {data.user.first_name} {data.user.last_name} ({data.user.email}) w firmie {data.user.organization.name} z rolami:
        {#each data.user.roles as role, i}
            {role.display_name}{i < data.user.roles.length - 1 ? ', ' : ''}
        {/each}
    </p>
</div>