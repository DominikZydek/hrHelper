import { API_URL } from '$env/static/private';
import { z } from 'zod';
import { fail } from '@sveltejs/kit';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';

const schema = z.object({
	message: z.number().int()
});

export const actions = {
	markMessageAsSeen: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(schema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		let { message } = form.data;

		const query = `
        mutation MarkMessageAsRead($message: ID!) {
              markMessageAsRead(
                message: $message
              ) {
                id
              }
            }
        `;

		const variables = {
			message
		};

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
	}
};

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
