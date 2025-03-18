<script>
	import Close from 'svelte-material-icons/Close.svelte';
	import { clickOutside } from '../utils/clickOutside.js';

	export let toggleDrawer;
	export let title = '';
</script>

<div
	class="flex flex-col gap-5 right-0 top-0 h-screen w-1/3 fixed bg-main-white border px-10 py-5 shadow-xl overflow-auto"
>
	<div class="flex justify-between sticky top-0 bg-main-white">
		<div class="flex gap-2 items-center">
			<slot name="header-left" />
			{#if title}
				<p class="font-semibold">{title}</p>
			{/if}
		</div>
		<button on:click={() => toggleDrawer()}>
			<Close class="text-main-gray" size="2rem" />
		</button>
	</div>
	<slot />
</div>
