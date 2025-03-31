<script>
	import EmailPlusOutline from 'svelte-material-icons/EmailPlusOutline.svelte';
	import EmailMultipleOutline from 'svelte-material-icons/EmailMultipleOutline.svelte';
	import { page } from '$app/state';

	let path = $derived(page.url.pathname.split('/')[3]);
</script>

<div class="w-full h-full flex">
	<div class="flex flex-col gap-2 border py-4 shadow-xl overflow-auto">
		<p class="text-2xl font-semibold text-main-app mb-2 px-4">Wiadomości</p>
		<a
			href="/home/messages/new-message"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                  {path === 'new-message' ? 'bg-auxiliary-gray' : ''}"
		>
			<EmailPlusOutline size="1.75rem" />
			<span>Nowa wiadomość</span>
		</a>
		<a
			href="/home/messages/view-messages"
			class="flex items-center gap-2 px-4 py-2 hover:bg-auxiliary-gray w-full text-left text-main-gray text-xl
                  {path === 'view-messages' ? 'bg-auxiliary-gray' : ''}"
		>
			<EmailMultipleOutline size="1.75rem" />
			<span>Wiadomości</span>
		</a>
	</div>
	<slot />
</div>
