<script>
	let { group, colorClass } = $props();
	import { icons } from '../stores/icons.js';
</script>

<div
	class="flex items-center gap-1 rounded-3xl border text-sm py-1 px-2
						{colorClass ? `border-${colorClass} text-${colorClass}` : 'border-main-black text-main-black'}"
>
	<svelte:component this={$icons[group.icon_name]} />
	<p>{group.name}</p>
</div>
