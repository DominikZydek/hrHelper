export const STATUS_MESSAGES = {
    'DRAFT': 'Wersja robocza',
    'SENT': 'Wysłany',
    'IN_PROGRESS': 'W trakcie',
    'APPROVED': 'Zatwierdzony',
    'REJECTED': 'Odrzucony',
    'CANCELLED': 'Anulowany'
};

export const STATUS_CLASSES = {
    'DRAFT': 'text-main-gray',
    'SENT': 'text-main-app',
    'IN_PROGRESS': 'text-accent-orange',
    'APPROVED': 'text-accent-green',
    'REJECTED': 'text-accent-red',
    'CANCELLED': 'text-main-gray'
};

export const STATUS_ICONS = {
    'DRAFT': 'PencilOutline',
    'SENT': 'SendOutline',
    'IN_PROGRESS': 'ProgressClock',
    'APPROVED': 'CheckboxMarkedCircleOutline',
    'REJECTED': 'CloseCircleOutline',
    'CANCELLED': 'BlockHelper'
};

export const getStatusInfo = (status) => {
    return {
        message: STATUS_MESSAGES[status] || 'Nieznany status',
        class: STATUS_CLASSES[status] || 'text-main-gray',
        icon: STATUS_ICONS[status] || 'HelpCircleOutline'
    };
};