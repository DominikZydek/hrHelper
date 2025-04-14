import { API_URL } from '$env/static/private';

export const load = async ({ locals, request, fetch }) => {
	const query = `
		query($organization: ID!) {
			groups {
				id
				name
				icon_name
				users {
					id
				}
			}
			users(organization: $organization) {
				id
				first_name
				last_name
				email
			}
		}
	`;

	const { user } = locals;

	const variables = {
		organization: user.organization.id
	};

	const res = await fetch(API_URL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		credentials: 'include',
		body: JSON.stringify({ query, variables })
	}).then((res) => res.json());

	console.log(res.data);

	return res.data;
};
