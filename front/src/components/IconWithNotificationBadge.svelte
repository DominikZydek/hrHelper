<script>
	export let number;
</script>

<div class="relative">
	<slot name="icon" />
	<div
		class="rounded-full bg-accent-orange h-4 w-4 flex items-center justify-center text-xs absolute top-4 left-4
		{number === 0 ? 'hidden' : ''}"
	>
		<small class="text-main-white">{number}</small>
	</div>
</div>
