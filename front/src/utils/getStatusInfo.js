export const STATUS_MESSAGES = {
	DRAFT: 'Wersja robocza',
	SENT: 'Wysłany',
	IN_PROGRESS: 'W trakcie',
	APPROVED: 'Zatwierdzony',
	REJECTED: 'Odrzucony',
	CANCELLED: 'Anulowany'
};

export const STATUS_CLASSES = {
	DRAFT: 'text-main-gray',
	SENT: 'text-main-app',
	IN_PROGRESS: 'text-accent-orange',
	APPROVED: 'text-accent-green',
	REJECTED: 'text-accent-red',
	CANCELLED: 'text-main-gray'
};

export const STATUS_COLORS = {
	DRAFT: '#4B5563',
	SENT: '#2563EB',
	IN_PROGRESS: '#EA580C',
	APPROVED: '#059669',
	REJECTED: '#DC2626',
	CANCELLED: '#4B5563'
};

export const STATUS_ICONS = {
	DRAFT: 'PencilOutline',
	SENT: 'SendOutline',
	IN_PROGRESS: 'ProgressClock',
	APPROVED: 'CheckboxMarkedCircleOutline',
	REJECTED: 'CloseCircleOutline',
	CANCELLED: 'BlockHelper'
};

export const getStatusInfo = (status) => {
	return {
		message: STATUS_MESSAGES[status] || 'Nieznany status',
		class: STATUS_CLASSES[status] || 'text-main-gray',
		color: STATUS_COLORS[status] || '#4B5563',
		icon: STATUS_ICONS[status] || 'HelpCircleOutline'
	};
};
