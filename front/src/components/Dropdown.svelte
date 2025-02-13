<script>
    import { clickOutside } from "../utils/clickOutside.js";
    export let toggleDropdown
</script>

<div
        use:clickOutside on:clickoutside={() => toggleDropdown()}
        class="absolute right-0 mt-1 bg-white shadow-lg rounded-md overflow-hidden z-50 min-w-[200px]">
    <slot />
</div>