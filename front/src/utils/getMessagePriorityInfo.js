export const getMessagePriorityInfo = (priorityNumber) => {
	if (priorityNumber === 1 || priorityNumber === '1')
		return { message: 'Niski', colorClass: 'accent-green' };
	if (priorityNumber === 2 || priorityNumber === '2')
		return { message: 'Średni', colorClass: 'accent-orange' };
	if (priorityNumber === 3 || priorityNumber === '3')
		return { message: 'Wysoki', colorClass: 'accent-red' };
};
