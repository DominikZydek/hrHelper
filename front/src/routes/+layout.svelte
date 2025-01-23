<script>
	import '../app.css';
    import AccountGroup from 'svelte-material-icons/AccountGroup.svelte'
    import FileDocumentMultiple from 'svelte-material-icons/FileDocumentMultiple.svelte'
    import CalendarMultiselect from 'svelte-material-icons/CalendarMultiselect.svelte'
    import AccountMultiplePlus from 'svelte-material-icons/AccountMultiplePlus.svelte'
    import NewspaperVariantMultiple from 'svelte-material-icons/NewspaperVariantMultiple.svelte'
    import { page } from '$app/state'

    // current path
    let path = $derived(page.url.pathname.split('/')[1])
</script>

<div class="h-screen">
    <nav class="fixed h-full w-20 bg-main-app flex flex-col items-center py-5">
        <img class="h-10 w-10" src="favicon.png" alt="logo">
        <ul class="flex flex-col items-center justify-end h-full w-full">
            <li class="p-4 w-full {path === 'employee-records' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col gap-1 items-center text-center group" href="/employee-records">
                    <AccountGroup class="text-main-white" size="2rem" />
                    <p class="text-white text-xs hidden group-hover:block">Pracownicy</p>
                </a>

            </li> <!-- employee records -->
            <li class="p-4 w-full {path === 'employee-documents' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col gap-1 items-center text-center group" href="/employee-documents">
                    <FileDocumentMultiple class="text-main-white" size="2rem" />
                    <p class="text-white text-xs hidden group-hover:block">Dokumentacja</p>
                </a>
            </li> <!-- employee documents -->
            <li class="p-4 w-full {path === 'leave-management' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col gap-1 items-center text-center group" href="/leave-management">
                    <CalendarMultiselect class="text-main-white" size="2rem" />
                    <p class="text-white text-xs hidden group-hover:block">Nieobecności</p>
                </a>
            </li> <!-- leave management -->
            <li class="p-4 w-full {path === 'recruitment' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col gap-1 items-center text-center group" href="/recruitment">
                    <AccountMultiplePlus class="text-main-white" size="2rem" />
                    <p class="text-white text-xs hidden group-hover:block">Rekrutacje</p>
                </a>
            </li> <!-- recruitment -->
            <li class="p-4 w-full {path === 'information' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col gap-1 items-center text-center group" href="/information">
                    <NewspaperVariantMultiple class="text-main-white" size="2rem" />
                    <p class="text-white text-xs hidden group-hover:block">Informacje</p>
                </a>
            </li> <!-- information -->
        </ul>
    </nav>
    <div class="ml-20 relative">
        <slot />
    </div>
</div>