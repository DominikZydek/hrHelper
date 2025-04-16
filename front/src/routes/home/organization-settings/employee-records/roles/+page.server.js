import { API_URL } from '$env/static/private';
import { z } from 'zod';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';

export const load = async ({ locals, request, fetch }) => {
	const query = `
		query($organization: ID!) {
			roles {
				id
				name
				display_name
				description
				permissions {
					id
					name
					display_name
				}
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
			permissions {
				id
				name
				display_name
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

	const schemaFields = {};
	res.data.permissions.forEach((permission) => {
		schemaFields[permission.name] = z.boolean().optional().default(false);
	});

	return res.data;
};

const grantSchema = z.object({
	selected_users: z.preprocess((val) => {
		// parse to array
		if (Array.isArray(val) && val.length === 1 && typeof val[0] === 'string') {
			return JSON.parse(val[0]);
		}
		return val;
	}, z.array(z.string())),
	role: z.number().int()
});

export const actions = {
	editRole: async ({ fetch, request }) => {
		const formData = await request.formData();

		let permissions = [];
		let role = formData.get('role');

		for (const entry of formData.entries()) {
			if (entry[0].startsWith('permission')) {
				permissions.push(entry[0].split('-')[1]); // push just the id part
			}
		}

		const query = `
			mutation EditRole($role: ID!, $permissions: [String]!) {
				editRole(role: $role, permissions: $permissions) {
					id
				}
			}
		`;

		const variables = { role, permissions };

		const res = await fetch(API_URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			credentials: 'include',
			body: JSON.stringify({ query, variables })
		}).then((res) => res.json());

		console.log(res.data ? res.data : res.errors);
	},
	grantRole: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(grantSchema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		const query = `
			mutation GrantRole($role: ID!, $selected_users: [String]!) {
				grantRole(role: $role, selected_users: $selected_users) {
					id
				}
			}
		`;

		const { role, selected_users } = form.data;

		const variables = { role, selected_users };

		const res = await fetch(API_URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			credentials: 'include',
			body: JSON.stringify({ query, variables })
		}).then((res) => res.json());

		console.log(res.data ? res.data : res.errors);
	}
};
