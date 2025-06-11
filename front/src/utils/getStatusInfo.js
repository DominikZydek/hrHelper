export const STATUS_MESSAGES = {
	DRAFT: 'Wersja robocza',
	SENT: 'Wysłany',
	IN_PROGRESS: 'W trakcie',
	APPROVED: 'Zatwierdzony',
	REJECTED: 'Odrzucony',
	CANCELLED: 'Anulowany',

	// documents
	ACTIVE: 'Ważny',
	EXPIRING_SOON: 'Zostało {days} dni',
	LAST_DAY: 'Ostatni dzień',
	EXPIRED: 'Termin minął'
};

export const STATUS_CLASSES = {
	DRAFT: 'text-main-gray',
	SENT: 'text-main-app',
	IN_PROGRESS: 'text-accent-orange',
	APPROVED: 'text-accent-green',
	REJECTED: 'text-accent-red',
	CANCELLED: 'text-main-gray',

	// documents
	ACTIVE: 'text-accent-green',
	EXPIRING_SOON: 'text-accent-orange',
	LAST_DAY: 'text-accent-red',
	EXPIRED: 'text-main-gray'
};

export const STATUS_COLORS = {
	DRAFT: '#4B5563',
	SENT: '#2563EB',
	IN_PROGRESS: '#EA580C',
	APPROVED: '#059669',
	REJECTED: '#DC2626',
	CANCELLED: '#4B5563',

	// documents
	ACTIVE: '#059669',
	EXPIRING_SOON: '#EA580C',
	LAST_DAY: '#DC2626',
	EXPIRED: '#4B5563'
};

export const STATUS_ICONS = {
	DRAFT: 'PencilOutline',
	SENT: 'SendOutline',
	IN_PROGRESS: 'ProgressClock',
	APPROVED: 'CheckboxMarkedCircleOutline',
	REJECTED: 'CloseCircleOutline',
	CANCELLED: 'BlockHelper',

	// documents
	ACTIVE: 'CheckboxMarkedCircleOutline',
	EXPIRING_SOON: 'AlertCircleOutline',
	LAST_DAY: 'AlertCircleOutline',
	EXPIRED: 'ClockAlertOutline'
};

export const getStatusInfo = (status, additionalData = {}) => {
	const baseInfo = {
		message: STATUS_MESSAGES[status] || 'Nieznany status',
		class: STATUS_CLASSES[status] || 'text-main-gray',
		color: STATUS_COLORS[status] || '#4B5563',
		icon: STATUS_ICONS[status] || 'HelpCircleOutline'
	};

	if (status === 'EXPIRING_SOON' && additionalData.days) {
		baseInfo.message = baseInfo.message.replace('{days}', additionalData.days);
	}

	return baseInfo;
};
