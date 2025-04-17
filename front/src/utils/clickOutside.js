export function clickOutside(node) {
	const handleClick = (event) => {
		if (!node.contains(event.target)) {
			node.dispatchEvent(new CustomEvent('clickoutside'));
		}
	};

	let timeoutId = setTimeout(() => {
		document.addEventListener('click', handleClick, true);
	}, 0);

	return {
		destroy() {
			clearTimeout(timeoutId);
			document.removeEventListener('click', handleClick, true);
		}
	};
}
