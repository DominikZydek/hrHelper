export const convertUTCtoLocalTime = (utcDateTime) => {
	// make sure the date is in ISO format
	let dateStr = utcDateTime;
	if (typeof dateStr === 'string' && !dateStr.endsWith('Z') && !dateStr.includes('+')) {
		dateStr = dateStr + 'Z';
	}

	const date = new Date(dateStr);
	return date;
};

export const calculateTimeAgo = (dateTime) => {
	const publicationDate = convertUTCtoLocalTime(dateTime);
	const now = new Date();

	const diffMs = now - publicationDate;

	const diffSec = Math.floor(diffMs / 1000);
	const diffMin = Math.floor(diffSec / 60);
	const diffHour = Math.floor(diffMin / 60);
	const diffDay = Math.floor(diffHour / 24);
	const diffMonth = Math.floor(diffDay / 30);
	const diffYear = Math.floor(diffDay / 365);

	if (diffYear > 0) {
		return diffYear === 1 ? '1 rok temu' : `${diffYear} lat${diffYear < 5 ? 'a' : ''} temu`;
	} else if (diffMonth > 0) {
		return diffMonth === 1
			? '1 miesiąc temu'
			: `${diffMonth} miesiąc${diffMonth < 5 && diffMonth !== 1 ? 'e' : diffMonth >= 5 ? 'y' : ''} temu`;
	} else if (diffDay > 0) {
		return diffDay === 1 ? '1 dzień temu' : `${diffDay} dni temu`;
	} else if (diffHour > 0) {
		return diffHour === 1
			? '1 godzinę temu'
			: `${diffHour} godzin${diffHour < 5 && diffHour !== 1 ? 'y' : ''} temu`;
	} else if (diffMin > 0) {
		return diffMin === 1
			? '1 minutę temu'
			: `${diffMin} minut${diffMin < 5 && diffMin !== 1 ? 'y' : ''} temu`;
	} else {
		return 'mniej niż minutę temu';
	}
};

export const formatLocalDateTime = (dateTime) => {
	const date = convertUTCtoLocalTime(dateTime);

	const options = {
		day: '2-digit',
		month: '2-digit',
		year: 'numeric',
		hour: '2-digit',
		minute: '2-digit',
		hour12: false
	};

	return new Intl.DateTimeFormat('pl-PL', options).format(date).replace(',', ' o');
};
