// returns object with mappers for the Searchbar component <br>
// component - 'EmployeeList' or 'LeaveRequestList'
// mode - for LeaveRequestList - 'view' or 'manage'
import { getStatusInfo } from './getStatusInfo.js';
import { getMessagePriorityInfo } from './getMessagePriorityInfo.js';

export const getSearchbarMappers = (component, mode) => {
	switch (component) {
		case 'LeaveRequestList': {
			if (mode === 'view') {
				return {
					searchMapper: (leave_request) => {
						return {
							leave_type: leave_request.leave_type.name,
							date_from: new Date(leave_request.date_from).toLocaleDateString(),
							date_to: new Date(leave_request.date_to).toLocaleDateString(),
							date_full:
								new Date(leave_request.date_from).toLocaleDateString() +
								' - ' +
								new Date(leave_request.date_to).toLocaleDateString(),
							days_count: leave_request.days_count,
							status: getStatusInfo(leave_request.status).message
						};
					},
					filterableFields: ['leave_type', 'status'],
					fieldLabels: {
						leave_type: 'Typ urlopu',
						status: 'Status'
					}
				};
			} else if (mode === 'manage') {
				return {
					searchMapper: (leave_request) => {
						let groups = [];

						leave_request.user.groups.forEach((g) => {
							groups.push(g.name);
						});

						return {
							first_name: leave_request.user.first_name,
							last_name: leave_request.user.last_name,
							full_name: leave_request.user.first_name + ' ' + leave_request.user.last_name,
							email: leave_request.user.email,
							job_title: leave_request.user.job_title,
							groups: groups,
							leave_type: leave_request.leave_type.name,
							date_from: new Date(leave_request.date_from).toLocaleDateString(),
							date_to: new Date(leave_request.date_to).toLocaleDateString(),
							date_full:
								new Date(leave_request.date_from).toLocaleDateString() +
								' - ' +
								new Date(leave_request.date_to).toLocaleDateString(),
							days_count: leave_request.days_count,
							status: getStatusInfo(leave_request.status).message
						};
					},
					filterableFields: ['full_name', 'job_title', 'groups', 'leave_type', 'status'],
					fieldLabels: {
						full_name: 'Imię i nazwisko',
						job_title: 'Stanowisko',
						groups: 'Zespół',
						leave_type: 'Typ urlopu',
						status: 'Status'
					}
				};
			}
			return {};
		}
		case 'EmployeeList': {
			return {
				searchMapper: (employee) => {
					let groups = [];

					employee.groups.forEach((g) => {
						groups.push(g.name);
					});

					return {
						first_name: employee.first_name,
						last_name: employee.last_name,
						full_name: employee.first_name + ' ' + employee.last_name,
						email: employee.email,
						job_title: employee.job_title,
						groups: groups,
						employed_from: new Date(employee.employed_from).toLocaleDateString()
					};
				},
				filterableFields: ['job_title', 'groups'],
				fieldLabels: {
					job_title: 'Stanowisko',
					groups: 'Zespół'
				}
			};
		}
		case 'MessageList': {
			return {
				searchMapper: (message) => {
					let groups = [];

					message.author.groups.forEach((g) => {
						groups.push(g.name);
					});

					return {
						first_name: message.author.first_name,
						last_name: message.author.last_name,
						full_name: message.author.first_name + ' ' + message.author.last_name,
						email: message.author.email,
						job_title: message.author.job_title,
						groups: groups,
						category: message.category.name,
						priority: getMessagePriorityInfo(message.priority).message,
						subject: message.subject,
						publication_date_locale_date: new Date(message.publication_date).toLocaleDateString(),
						publication_date_locale_time: new Date(message.publication_date).toLocaleTimeString()
					};
				},
				filterableFields: [
					'full_name',
					'email',
					'job_title',
					'category',
					'priority',
					'subject',
					'publication_date_locale_date'
				],
				fieldLabels: {
					full_name: 'Imię i nazwisko',
					email: 'Email',
					job_title: 'Stanowisko',
					category: 'Kategoria',
					priority: 'Priorytet',
					subject: 'Temat',
					publication_date_locale_date: 'Data publikacji'
				}
			};
		}
	}

	return {};
};
