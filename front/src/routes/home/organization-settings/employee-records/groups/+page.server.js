import { API_URL } from '$env/static/private';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';
import { z } from 'zod';

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

	return res.data;
};

const schema = z.object({
	group: z.number().int(),
	name: z.string().min(1),
	icon_name: z.string().min(1),
	selected_users: z.preprocess((val) => {
		// parse to array
		if (Array.isArray(val) && val.length === 1 && typeof val[0] === 'string') {
			return JSON.parse(val[0]);
		}
		return val;
	}, z.array(z.string())),
	mode: z.string().min(1)
});

const removeSchema = z.object({
	group: z.number().int()
});

export const actions = {
	editGroup: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(schema));

		console.log(form);

		const { mode } = form.data;

		if (!form.valid) {
			return fail(400, { form });
		}

		const query =
			mode === 'create'
				? `
				mutation CreateGroup($name: String!, $icon_name: String!, $selected_users: [String]!) {
					createGroup(name: $name, icon_name: $icon_name, selected_users: $selected_users) {
						id
					}
				}
			`
				: `
					mutation EditGroup($group: ID!, $name: String!, $icon_name: String!, $selected_users: [String]!) {
						editGroup(group: $group, name: $name, icon_name: $icon_name, selected_users: $selected_users) {
							id
						}
					}
				`;

		const { group, name, icon_name, selected_users } = form.data;

		const variables = { group, name, icon_name, selected_users };

		const res = await fetch(API_URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			credentials: 'include',
			body: JSON.stringify({ query, variables })
		}).then((res) => res.json());

		console.log(res.data ? res.data : res.errors);

		return { form };
	},
	removeGroup: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(removeSchema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		const query = `
			mutation RemoveGroup($group: ID!) {
				removeGroup(group: $group) {
					id
				}
			}
		`;

		const { group } = form.data;

		const variables = { group };

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
