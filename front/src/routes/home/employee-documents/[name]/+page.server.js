import { API_URL } from '$env/static/private';
import { z } from 'zod';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';

const schema = z.object({
	file: z.any(),
	user: z.number().int(),
	file_name: z.string(),
	date_from: z.date().transform((date) => date.toISOString().split('T')[0]),
	date_to: z.date().transform((date) => date.toISOString().split('T')[0]),
	date_archive: z.date().transform((date) => date.toISOString().split('T')[0]),
	collection: z.number().int()
});

export const actions = {
	default: async ({ request, fetch }) => {
		const formData = await request.formData();

		const form = await superValidate(formData, zod(schema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		const file = formData.get('file');

		const query = `
      mutation UploadFile(
        $file: Upload!
        $user: ID!
        $file_name: String!
        $date_from: Date!
        $date_to: Date!
        $date_archive: Date!
        $collection: ID!
      ) {
        uploadFile(
          file: $file
          user: $user
          file_name: $file_name
          date_from: $date_from
          date_to: $date_to
          date_archive: $date_archive
          collection: $collection
        ) {
          id
        }
      }
    `;

		const { user, collection, file_name, date_from, date_to, date_archive } = form.data;

		const variables = {
			file: null,
			user,
			collection,
			file_name,
			date_from,
			date_to,
			date_archive
		};

		const operations = JSON.stringify({
			query,
			variables
		});

		const map = JSON.stringify({
			0: ['variables.file']
		});

		const uploadFormData = new FormData();
		uploadFormData.append('operations', operations);
		uploadFormData.append('map', map);
		uploadFormData.append('0', file);

		const res = await fetch(`${API_URL}`, {
			method: 'POST',
			credentials: 'include',
			body: uploadFormData
		}).then((res) => res.json());

		return res.data;
	}
};
