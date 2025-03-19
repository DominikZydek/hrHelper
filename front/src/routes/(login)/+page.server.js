import { API_URL, FRONTEND_URL } from '$env/static/private';
import { date, z } from 'zod';
import { message, superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { redirect, fail } from '@sveltejs/kit';

const schema = z.object({
	organization_alias: z.string(),
	email: z.string().email(),
	password: z.string()
});

export const load = async () => {
	const form = await superValidate(zod(schema));

	return { form };
};

export const actions = {
	default: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(schema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		let { organization_alias, email, password } = form.data;

		const query = `
                mutation Login($organization_alias: String!, $email: String!, $password: String!) {
                    login(
                        organization_alias: $organization_alias
                        email: $email
                        password: $password
                    ) {
                        id
                    }
                }`;

		const variables = {
			organization_alias,
			email,
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

		if (res.errors) {
			return message(form, res.errors[0].message || 'Błąd logowania');
		}

		if (res.data.login) {
			throw redirect(303, `${FRONTEND_URL}/home`);
		}

		return { form };
	}
};
