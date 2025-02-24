<script>
    import Close from 'svelte-material-icons/Close.svelte'
    import { lockScroll } from "../utils/lockScroll.js";
    import { clickOutside } from "../utils/clickOutside.js";
    export let togglePopup
    export let title
</script>

<div use:lockScroll class="fixed top-0 left-0 w-screen h-screen bg-main-black/75 flex items-center justify-center p-4">
    <div use:clickOutside
         on:clickoutside={() => togglePopup()}
         class="bg-main-white max-w-5xl max-h-[90vh] rounded-lg p-6 overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <p class="text-xl font-medium">{title}</p>
            <div class="flex items-center gap-2">
                <slot name="header-right"/>
                <button
                        on:click={() => togglePopup()}>
                    <Close class="text-main-gray" size="2rem"/>
                </button>
            </div>
        </div>
        <div class="w-full">
            <slot />
        </div>
    </div>
</div>