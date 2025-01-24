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
            <li class="px-4 py-6 w-full relative {path === 'employee-records' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col items-center justify-center h-8 group" href="/employee-records">
                    <AccountGroup class="text-main-white absolute group-hover:-translate-y-3 transition-transform" size="2rem" />
                    <p class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity">Pracownicy</p>
                </a>
             </li> <!-- employee records -->
             <li class="px-4 py-6 w-full relative {path === 'employee-documents' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col items-center justify-center h-8 group" href="/employee-documents">
                    <FileDocumentMultiple class="text-main-white absolute group-hover:-translate-y-3 transition-transform" size="2rem" />
                    <p class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity">Dokumentacja</p>
                </a>
             </li> <!-- employee documents -->
             <li class="px-4 py-6 w-full relative {path === 'leave-management' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col items-center justify-center h-8 group" href="/leave-management">
                    <CalendarMultiselect class="text-main-white absolute group-hover:-translate-y-3 transition-transform" size="2rem" />
                    <p class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity">Nieobecności</p>
                </a>
             </li> <!-- leave management -->
             <li class="px-4 py-6 w-full relative {path === 'recruitment' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col items-center justify-center h-8 group" href="/recruitment">
                    <AccountMultiplePlus class="text-main-white absolute group-hover:-translate-y-3 transition-transform" size="2rem" />
                    <p class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity">Rekrutacje</p>
                </a>
             </li> <!-- recruitment -->
             <li class="px-4 py-6 w-full relative {path === 'information' ? 'bg-auxiliary-darkblue' : ''}">
                <a class="flex flex-col items-center justify-center h-8 group" href="/information">
                    <NewspaperVariantMultiple class="text-main-white absolute group-hover:-translate-y-3 transition-transform" size="2rem" />
                    <p class="text-white text-xs absolute translate-y-3 opacity-0 group-hover:opacity-100 transition-opacity">Informacje</p>
                </a>
             </li> <!-- information -->
        </ul>
    </nav>
    <div class="ml-20 relative">
        <slot />
    </div>
</div>