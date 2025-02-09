<!-- TODO: analyze this code thoroughly -->
<script>
    import { clickOutside } from '../utils/clickOutside.js'
    import GroupBadge from './GroupBadge.svelte'
    import Close from 'svelte-material-icons/Close.svelte'
    export let options = []
    export let selected = []
    export let placeholder = 'Wybierz opcje'
    export let onChange = () => {}

    let isOpen = false
    let searchText = ''
    let searchInput

    function toggleDropdown() {
        isOpen = !isOpen
        if (isOpen) {
            setTimeout(() => {
                searchInput?.focus()
            }, 0)
        }
    }

    function selectOption(option) {
        const newSelected = selected.includes(option.value)
            ? selected.filter(v => v !== option.value)
            : [...selected, option.value]
        onChange(newSelected)
    }

    $: filteredOptions = options.filter(option =>
        option.name.toLowerCase().includes(searchText.toLowerCase())
    )

    $: selectedOptions = options.filter(option => selected.includes(option.value))
</script>

<div class="relative" use:clickOutside on:clickoutside={() => isOpen = false}>
    <div
            class="flex flex-wrap gap-2 min-h-[2.5rem] w-full border p-2 cursor-pointer"
            on:click={toggleDropdown}
    >
        {#if selectedOptions.length === 0}
            <span class="text-gray-400">{placeholder}</span>
        {:else}
            {#each selectedOptions as option}
                <div class="flex items-center gap-1">
                    <GroupBadge group={option} />
                    <button
                            type="button"
                            class="ml-1"
                            on:click|stopPropagation={() => selectOption(option)}>
                        <Close class="text-main-black"/>
                    </button>
                </div>
            {/each}
        {/if}
    </div>

    {#if isOpen}
        <div class="absolute z-50 w-full bg-white border mt-1 max-h-60 overflow-y-auto">
            <input
                    bind:this={searchInput}
                    bind:value={searchText}
                    class="w-full p-2 border-b"
                    placeholder="Szukaj..."
            >

            {#each filteredOptions as option}
                <button
                        type="button"
                        class="p-2 hover:bg-gray-100 w-full text-left"
                        class:bg-gray-50={selected.includes(option.value)}
                        on:click={() => selectOption(option)}
                >
                    {option.name}
                </button>
            {/each}
        </div>
    {/if}
</div>