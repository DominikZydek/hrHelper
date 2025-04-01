import { API_URL } from '$env/static/private';

export const load = async ({ request, fetch }) => {
	const query = `
			{
			me {
				visibleMessages {
					id
					author {
						id
						first_name
						last_name
						email
						job_title
						employed_from
						employed_to
						groups {
							id
							name
							icon_name
						}
					}
					subject
					category {
						id
						name
					}
					content
					priority
					publication_date
					date_from
					date_to
					require_confirmation
					seen
				}
			}
		}
	`;

	const res = await fetch(API_URL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		credentials: 'include',
		body: JSON.stringify({ query })
	}).then((res) => res.json());

	console.log(res.data);

	return res.data;
};
