export function getDropdownPosition(trigger, dropdown) {
	const triggerRect = trigger.getBoundingClientRect();
	const dropdownRect = dropdown.getBoundingClientRect();

	let top = triggerRect.bottom + window.scrollY;
	let left = triggerRect.left + window.scrollX;

	// if there is no space below, render above
	const spaceBelow = window.innerHeight - triggerRect.bottom;
	if (spaceBelow < dropdownRect.height) {
		top = triggerRect.top - dropdownRect.height + window.scrollY;
	}

	// prevent overflow
	const rightOverflow = left + dropdownRect.width - window.innerWidth;
	if (rightOverflow > 0) {
		left = Math.max(0, left - rightOverflow);
	}

	return { top, left };
}
