import { fail, redirect } from '@sveltejs/kit';
import { API_URL, FRONTEND_URL } from '$env/static/private';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { z } from 'zod';

const schema = z.object({
	password: z
		.string()
		.regex(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d@$!%*?&.-]{8,}$/, {
			message:
				'Hasło powinno zawierać minimum 8 znaków, w tym co najmniej 1 wielką literę, 1 małą literę i 1 cyfrę'
		}),
	confirm_password: z.string().min(1, { message: 'Potwierdź hasło' })
});

export const load = async ({ request, fetch }) => {
	const form = await superValidate(zod(schema));

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

	return {
		user: res.data.user,
		form
	};
};

export const actions = {
	default: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(schema));

		const queryString = request.url.split('?')[1];
		const params = new URLSearchParams(queryString);

		const activation_token = params.get('token');
		const alias = params.get('organization');

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		let { password, confirm_password } = form.data;

		if (password !== confirm_password) {
			form.errors['confirm_password'] = ['Hasła nie są takie same'];
			return fail(400, { form });
		}

		const query = `
		mutation ActivateUserAccount($activation_token: String!, $password: String!) {
			activateUserAccount(activation_token: $activation_token, password: $password) {
				id
			}
		}`;

		const variables = {
			activation_token,
			password
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

		if (res.data.user.id) {
			throw redirect(303, `${FRONTEND_URL}/`);
		}

		return { form };
	}
};
