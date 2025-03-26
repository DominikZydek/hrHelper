<script>
	export let number;
</script>

<div class="relative">
	<slot name="icon" />
	<div
		class="rounded-full bg-accent-orange h-4 w-4 flex items-center justify-center text-xs absolute bottom-[-0.25rem] right-[-0.25rem]
		{number === 0 ? 'hidden' : ''}"
	>
		<small class="text-main-white">{number}</small>
	</div>
</div>
