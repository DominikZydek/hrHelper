<script>
    import Magnify from 'svelte-material-icons/Magnify.svelte'
    import Plus from 'svelte-material-icons/Plus.svelte'

    export let placeholderText
</script>

<form class="flex items-center gap-2 px-10 h-16">
    <input class="w-1/4 border h-8 px-2 rounded border-main-gray" type="text" placeholder="{placeholderText}">
    <button type="submit">
        <Magnify class="text-main-gray" size="1.75rem"/>
    </button>
    <button class="flex gap-1 items-center text-main-app font-semibold h-8 px-4">
        <Plus class="" />
        Dodaj filtr
    </button>
    <!-- TODO: applied filters rendered here -->
</form>