<!-- lib/components/Dropdown.svelte -->
<script>
    import { clickOutside } from "../utils/clickOutside.js";
    import { getDropdownPosition } from '../utils/getDropdownPosition.js'
    import {onDestroy} from "svelte";

    export let toggleDropdown
    export let triggerElement

    let dropdownElement
    let position = { top: 0, left: 0 }

    $: if (dropdownElement && triggerElement) {
        position = getDropdownPosition(triggerElement, dropdownElement)
    }

    onDestroy(() => {
        toggleDropdown()
    })
</script>

<div class="fixed inset-0 z-40 pointer-events-none">
    <div
            bind:this={dropdownElement}
            use:clickOutside
            on:clickoutside={toggleDropdown}
            class="fixed bg-white border shadow-2xl rounded-lg max-w-[600px] z-50 pointer-events-auto"
            style="top: {position.top}px; left: {position.left}px;"
    >
        <slot />
    </div>
</div>