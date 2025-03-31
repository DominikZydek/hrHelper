import { API_URL } from '$env/static/private';
import { z } from 'zod';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';

const schema = z.object({
	recipients: z.preprocess((val) => {
		// parse to array
		if (Array.isArray(val) && val.length === 1 && typeof val[0] === 'string') {
			return JSON.parse(val[0]);
		}
		return val;
	}, z.array(z.string())),
	subject: z.string(),
	category: z.number().int(),
	content: z.string(),
	priority: z.number().int(),
	publication_date: z
		.date()
		.transform((date) => date.toISOString().replace('T', ' ').split('.')[0]),
	date_from: z
		.date()
		.transform((date) => date.toISOString().split('T')[0])
		.nullable(),
	date_to: z
		.date()
		.transform((date) => date.toISOString().split('T')[0])
		.nullable(),
	require_confirmation: z.boolean()
});

export const actions = {
	sendMessage: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(schema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		const query = `
			mutation CreateMessage($recipients: [String]!, $subject: String!, $category: ID!, $content: String!, $priority: Int!, $publication_date: DateTime!, $date_from: Date, $date_to: Date, $require_confirmation: Boolean!) {
				createMessage(
					recipients: $recipients
					subject: $subject
					category: $category
					content: $content
					priority: $priority
					publication_date: $publication_date
					date_from: $date_from
					date_to: $date_to
					require_confirmation: $require_confirmation
				) {
					id
				}
			}
		`;

		const {
			recipients,
			subject,
			category,
			content,
			priority,
			publication_date,
			date_from,
			date_to,
			require_confirmation
		} = form.data;

		const variables = {
			recipients,
			subject,
			category,
			content,
			priority,
			publication_date,
			date_from,
			date_to,
			require_confirmation
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

		return { form };
	}
};

export const load = async ({ locals, request, fetch }) => {
	const query = `
		query($organization: ID!) {
			groups {
				id,
				name,
				icon_name
			},
			users(organization: $organization) {
				id,
				first_name,
				last_name,
				email,
				job_title,
				groups {
					id,
					name,
					icon_name
				},
				employed_from,
				employed_to
			},
			message_categories {
				id,
				name
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
