import { API_URL } from '$env/static/private';
import { date, z } from 'zod';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';

export const load = async ({ request, fetch }) => {
	// TODO: make it retrieve appropriate data (belonging to the same organization as locals.user),
	const query = `
        {
          users {
            id,
            first_name,
            last_name,
            sex,
            email,
            birth_date,
            phone_number,
            address {
              id,
              street_name,
              street_number,
              postal_code,
              city
            },
            roles {
                id,
                name,
                display_name,
                description
            },
            job_title,
            supervisor {
              id,
              first_name,
              last_name
            },
            groups {
              id,
              name,
              icon_name
            },
            approval_process {
                id,
                steps {
                    order,
                    approver {
                        id,
                        first_name,
                        last_name,
                        email,
                        job_title,
                        groups {
                            icon_name,
                            name
                        }
                    }
                }
            },
            type_of_employment,
            paid_time_off_days,
            working_time,
            employed_from,
            employed_to,
            health_check_expired_by,
            health_and_safety_training_expired_by
          },
          groups {
            id,
            name,
            icon_name
          },
          roles {
                id,
                name,
                display_name,
                description
            },
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

const userSchema = z.object({
	id: z.number().int(),
	first_name: z.string(),
	last_name: z.string(),
	sex: z.string(),
	email: z.string().email(),
	birth_date: z.date().transform((date) => date.toISOString().split('T')[0]),
	phone_number: z.string(),
	street_name: z.string(),
	street_number: z.string(),
	postal_code: z.string().regex(/^\d{2}-\d{3}$/),
	city: z.string(),
	roles: z.preprocess((val) => {
		// parse to array
		if (Array.isArray(val) && val.length === 1 && typeof val[0] === 'string') {
			return JSON.parse(val[0]);
		}
		return val;
	}, z.array(z.string())),
	job_title: z.string(),
	groups: z.preprocess((val) => {
		// parse to array
		if (Array.isArray(val) && val.length === 1 && typeof val[0] === 'string') {
			return JSON.parse(val[0]);
		}
		return val;
	}, z.array(z.string())),
	supervisor: z.number().int().nullable(),
	type_of_employment: z.string(),
	paid_time_off_days: z.number().int(),
	working_time: z.number(),
	employed_from: z.date().transform((date) => date.toISOString().split('T')[0]),
	employed_to: z
		.date()
		.transform((date) => date.toISOString().split('T')[0])
		.nullable(),
	health_check_expired_by: z.date().transform((date) => date.toISOString().split('T')[0]),
	health_and_safety_training_expired_by: z
		.date()
		.transform((date) => date.toISOString().split('T')[0])
});

const approvalProcessSchema = z.object({
	id: z.number().int(),
	steps: z.array(
		z.object({
			order: z.number().int(),
			approver_id: z.number().int()
		})
	)
});

export const actions = {
	updateUser: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(userSchema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		let {
			id,
			first_name,
			last_name,
			sex,
			email,
			birth_date,
			phone_number,
			street_name,
			street_number,
			postal_code,
			city,
			roles,
			job_title,
			groups,
			supervisor,
			type_of_employment,
			paid_time_off_days,
			working_time,
			employed_from,
			employed_to,
			health_check_expired_by,
			health_and_safety_training_expired_by
		} = form.data;

		const query = `
                mutation UpdateUser($id: ID!, $first_name: String!, $last_name: String!, $sex: Sex!, 
                    $email: String!, $birth_date: Date!, $phone_number: String!, $street_name: String!, 
                    $street_number: String!, $postal_code: String!, $city: String!, $roles: [String]!,
                    $job_title: String!, $groups: [String]!, $supervisor: ID, $type_of_employment: TypeOfEmployment!,
                    $paid_time_off_days: Int!, $working_time: Float!, $employed_from: Date!, $employed_to: Date, 
                    $health_check_expired_by: Date!, $health_and_safety_training_expired_by: Date!) {
                        updateUser(
                            id: $id
                            first_name: $first_name
                            last_name: $last_name
                            sex: $sex
                            email: $email
                            birth_date: $birth_date
                            phone_number: $phone_number
                            street_name: $street_name
                            street_number: $street_number
                            postal_code: $postal_code
                            city: $city
                            roles: $roles
                            job_title: $job_title
                            groups: $groups
                            supervisor: $supervisor
                            type_of_employment: $type_of_employment
                            paid_time_off_days: $paid_time_off_days
                            working_time: $working_time
                            employed_from: $employed_from
                            employed_to: $employed_to
                            health_check_expired_by: $health_check_expired_by
                            health_and_safety_training_expired_by: $health_and_safety_training_expired_by
                        ) {
                            id
                        }
                    }`;

		const variables = {
			id,
			first_name,
			last_name,
			sex,
			email,
			birth_date,
			phone_number,
			street_name,
			street_number,
			postal_code,
			city,
			roles,
			job_title,
			groups,
			supervisor,
			type_of_employment,
			paid_time_off_days,
			working_time,
			employed_from,
			employed_to,
			health_check_expired_by,
			health_and_safety_training_expired_by
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
	},
	updateApprovalProcess: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(approvalProcessSchema));

		console.dir(form, { depth: null });

		if (!form.valid) {
			return fail(400, { form });
		}

		let { id, steps } = form.data;

		const query = `
        mutation UpdateApprovalProcess($id: ID!, $steps: [ApprovalStepInput!]!) {
            updateApprovalProcess(
                id: $id
                steps: $steps
            ) {
                id
            }
        }`;

		const variables = { id, steps };

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
	},
	createUser: async ({ request, fetch }) => {
		const form = await superValidate(request, zod(userSchema));

		console.dir(form, { depth: null });

		if (!form.valid) {
			return fail(400, { form });
		}

		// TODO: send data for approval process creation
		let {
			first_name,
			last_name,
			sex,
			email,
			birth_date,
			phone_number,
			street_name,
			street_number,
			postal_code,
			city,
			roles,
			job_title,
			groups,
			supervisor,
			type_of_employment,
			paid_time_off_days,
			working_time,
			employed_from,
			employed_to,
			health_check_expired_by,
			health_and_safety_training_expired_by
		} = form.data;

		const query = `
				mutation CreateUser($first_name: String!, $last_name: String!, $sex: Sex!, $email: String!, $birth_date: Date!, $phone_number: String!, $street_name: String!, $street_number: String!, $postal_code: String!, $city: String!, $roles: [String]!, $job_title: String!, $groups: [String]!, $supervisor: ID, $type_of_employment: TypeOfEmployment!, $paid_time_off_days: Int!, $working_time: Float!, $employed_from: Date!, $employed_to: Date, $health_check_expired_by: Date!, $health_and_safety_training_expired_by: Date!) {
					createUser(
						first_name: $first_name,
						last_name: $last_name,
						sex: $sex,
						email: $email,
						birth_date: $birth_date,
						phone_number: $phone_number,
						street_name: $street_name,
						street_number: $street_number,
						postal_code: $postal_code,
						city: $city,
						roles: $roles,
						job_title: $job_title,
						groups: $groups,
						supervisor: $supervisor,
						type_of_employment: $type_of_employment,
						paid_time_off_days: $paid_time_off_days,
						working_time: $working_time,
						employed_from: $employed_from,
						employed_to: $employed_to,
						health_check_expired_by: $health_check_expired_by,
						health_and_safety_training_expired_by: $health_and_safety_training_expired_by
					) {
						id
					}
				}`;

		const variables = {
			first_name,
			last_name,
			sex,
			email,
			birth_date,
			phone_number,
			street_name,
			street_number,
			postal_code,
			city,
			roles,
			job_title,
			groups,
			supervisor,
			type_of_employment,
			paid_time_off_days,
			working_time,
			employed_from,
			employed_to,
			health_check_expired_by,
			health_and_safety_training_expired_by
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
