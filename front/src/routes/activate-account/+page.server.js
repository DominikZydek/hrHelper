import { redirect } from '@sveltejs/kit';
import { API_URL, FRONTEND_URL } from '$env/static/private';

export const load = async ({ request, fetch }) => {
	const queryString = request.url.split('?')[1];
	const params = new URLSearchParams(queryString);

	const activation_token = params.get('token');
	const alias = params.get('organization');

	if (!activation_token || !alias) {
		throw redirect(303, `${FRONTEND_URL}/`);
	}

	const query = `
		query User($activation_token: String!) {
			user(activation_token: $activation_token) {
				id,
				first_name,
				last_name,
				organization {
					alias,
					name
				}
			}
		}`;

	const variables = {
		activation_token
	};

	const res = await fetch(API_URL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		credentials: 'include',
		body: JSON.stringify({ query, variables })
	}).then((res) => res.json());

	console.log(res);

	if (res.data.user.organization.alias !== alias) {
		throw redirect(303, `${FRONTEND_URL}/`);
	}

	return res.data;
};
