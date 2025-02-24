<!-- Dropdown.svelte -->
<script>
    import { clickOutside } from "../utils/clickOutside.js";
    export let toggleDropdown;
    export let position = 'default'; // 'default', 'top-left'
</script>

<div
        use:clickOutside
        on:clickoutside={() => toggleDropdown()}
        class="absolute
           {position === 'default' ? 'top-full left-0' : 'bottom-full translate-x-[-100%]'}
           mt-2 bg-white shadow-lg rounded-md p-4 max-w-[600px] z-50"
>
    <slot />
</div>