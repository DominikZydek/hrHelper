import { API_URL } from '$env/static/private';
import { z } from 'zod';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';

export const load = async ({ locals, fetch }) => {
	const query = `
		{
			leaveTypes {
				id
				name
				limit_per_year
				requires_replacement
				min_notice_days
				can_be_cancelled
				leave_requests {
					id
					status
					date_from
					date_to
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
	leave_type: z.number().int(),
	mode: z.string(),
	name: z.string(),
	limit_per_year: z.number().int(),
	requires_replacement: z.boolean(),
	min_notice_days: z.number().int(),
	can_be_cancelled: z.boolean()
});

const removeSchema = z.object({
	leave_type: z.number().int()
});

export const actions = {
	editLeaveType: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(schema));

		console.log(form);

		const { mode } = form.data;

		if (!form.valid) {
			return fail(400, { form });
		}

		const query =
			mode === 'create'
				? `
						mutation CreateLeaveType(
							$leave_type: ID!
							$name: String!
							$limit_per_year: Int!
							$requires_replacement: Boolean!
							$min_notice_days: Int!
							$can_be_cancelled: Boolean!
						) {
							createLeaveType(
								leave_type: $leave_type
								name: $name
								limit_per_year: $limit_per_year
								requires_replacement: $requires_replacement
								min_notice_days: $min_notice_days
								can_be_cancelled: $can_be_cancelled
							) {
								id
							}
						}
			`
				: `
					mutation EditLeaveType(
							$leave_type: ID!
							$name: String!
							$limit_per_year: Int!
							$requires_replacement: Boolean!
							$min_notice_days: Int!
							$can_be_cancelled: Boolean!
						) {
							editLeaveType(
								leave_type: $leave_type
								name: $name
								limit_per_year: $limit_per_year
								requires_replacement: $requires_replacement
								min_notice_days: $min_notice_days
								can_be_cancelled: $can_be_cancelled
							) {
								id
							}
						}
				`;

		const {
			leave_type,
			name,
			limit_per_year,
			requires_replacement,
			min_notice_days,
			can_be_cancelled
		} = form.data;

		const variables = {
			leave_type,
			name,
			limit_per_year,
			requires_replacement,
			min_notice_days,
			can_be_cancelled
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
	},
	removeLeaveType: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(removeSchema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		const query = `
			mutation RemoveLeaveType($leave_type: ID!) {
				removeLeaveType(leave_type: $leave_type) {
					id
				}
			}
		`;

		const { leave_type } = form.data;

		const variables = { leave_type };

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
