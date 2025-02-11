<script>
    import Close from 'svelte-material-icons/Close.svelte'
    import { lockScroll } from "../utils/lockScroll.js";
    import { clickOutside } from "../utils/clickOutside.js";
    export let togglePopup
    export let title
</script>

<div use:lockScroll class="fixed top-0 left-0 w-screen h-screen bg-main-black/75 flex items-center justify-center">
    <div use:clickOutside
         on:clickoutside={() => togglePopup()}
         class="bg-main-white w-[1080px] h-[720px] p-2.5">
        <div class="flex justify-between">
            <p class="text-xl">{title}</p>
            <button on:click={() => togglePopup()}>
                <Close class="text-main-gray" size="2rem"/>
            </button>
        </div>
        <slot />
    </div>
</div>