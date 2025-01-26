<script>
    export let group

    const iconImport = async (iconName) => {
        return (await import(`../node_modules/svelte-material-icons/${iconName}.svelte`)).default
    }

    let IconComponent
    $: iconImport(group.icon_name).then(component => {
        IconComponent = component
    })
</script>

<div>
    <svelte:component this={IconComponent} class="text-main-gray" size="2rem"/>
</div>