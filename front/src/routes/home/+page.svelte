<script>
    export let data
</script>

<div>
    <p>Zalogowano jako {data.user.first_name} {data.user.last_name} ({data.user.email}) w firmie {data.user.organization.name} z rolą {data.user.role}</p>
</div>