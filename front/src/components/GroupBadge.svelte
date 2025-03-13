<script>
	export let group;
	import { icons } from '../stores/icons.js';
</script>

<div class="flex items-center gap-1 rounded-3xl border border-main-black text-sm py-1 px-2">
	<svelte:component this={$icons[group.icon_name]} />
	<p>{group.name}</p>
</div>
