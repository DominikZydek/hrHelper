<script>
	let { fullName, variant = 'medium' } = $props();

	const getInitials = (fullName) => {
		const names = fullName.split(' ');
		return names.map((name) => name.charAt(0).toUpperCase()).join('');
	};

	const getSizeClasses = (variant) => {
		switch (variant) {
			case 'large':
				return 'h-12 w-12 text-2xl';
			case 'medium':
				return 'h-10 w-10 text-xl';
			case 'small':
				return 'h-8 w-8 text-base';
			default:
				return 'h-10 w-10 text-xl';
		}
	};
</script>

<div
	class="{getSizeClasses(
		variant
	)} rounded-full bg-auxiliary-blue text-auxiliary-darkblue font-bold flex justify-center items-center"
>
	<span>{getInitials(fullName)}</span>
</div>
