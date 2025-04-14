import { API_URL } from '$env/static/private';

export const load = async ({ request, fetch }) => {
	const query = `
		{
			groups {
				id
				name
				icon_name
				users {
					id
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
