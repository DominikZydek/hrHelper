import { z } from 'zod';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';
import { API_URL } from '$env/static/private';

const schema = z.object({
	leave_request: z.number().int(),
	comment: z.string().min(1, { message: 'Dodaj komentarz' }),
	status: z.string()
});

export const load = async ({ request, fetch }) => {
	const form = await superValidate(zod(schema));

	return { form };
};

export const actions = {
	setLeaveRequestStatus: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(schema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		let { leave_request, comment, status } = form.data;

		const query = `
		mutation SetLeaveRequestStatus($leave_request: ID!, $comment: String!, $status: String!) {
			setLeaveRequestStatus(leave_request: $leave_request, comment: $comment, status: $status) {
				id
			}
		}`;

		const variables = {
			leave_request,
			comment,
			status
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
