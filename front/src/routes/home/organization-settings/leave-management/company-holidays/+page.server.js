import { API_URL } from '$env/static/private';
import { z } from 'zod';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';

export const load = async ({ request, fetch }) => {
	const query = `
		{
			me {
				organization {
					holidays {
						id
						name
						date
						recurring_yearly
					}
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

	return res.data;
};

const schema = z.object({
	holiday: z.number().int(),
	mode: z.string(),
	name: z.string(),
	date: z.date().transform((date) => date.toISOString().split('T')[0]),
	recurring_yearly: z.boolean()
});

const removeSchema = z.object({
	holiday: z.number().int()
});

export const actions = {
	editHoliday: async ({ fetch, request }) => {
		const form = await superValidate(request, zod(schema));

		console.log(form);

		const { mode } = form.data;

		if (!form.valid) {
			return fail(400, { form });
		}

		const query =
			mode === 'create'
				? `
						mutation CreateCompanyHoliday(
							$name: String!
							$date: Date!
							$recurring_yearly: Boolean!
						) {
							createCompanyHoliday(
								name: $name
								date: $date
								recurring_yearly: $recurring_yearly
							) {
								id
							}
						}
			`
				: `
					mutation EditCompanyHoliday(
						$holiday: ID!
						$name: String!
						$date: Date!
						$recurring_yearly: Boolean!
					) {
						editCompanyHoliday(
							holiday: $holiday
							name: $name
							date: $date
							recurring_yearly: $recurring_yearly
						) {
							id
						}
					}
				`;

		const { holiday, name, date, recurring_yearly } = form.data;

		const variables = { holiday, name, date, recurring_yearly };

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
	removeHoliday: async ({ fetch, request }) => {
		const form = await superValidate(request, zod(removeSchema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		const query = `
			mutation RemoveCompanyHoliday($holiday: ID!) {
				removeCompanyHoliday(holiday: $holiday) {
					id
				}
			}
		`;

		const { holiday } = form.data;

		const variables = { holiday };

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
