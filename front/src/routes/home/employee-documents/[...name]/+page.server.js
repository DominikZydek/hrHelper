import { API_URL } from '$env/static/private';
import { z } from 'zod';
import { superValidate } from 'sveltekit-superforms';
import { zod } from 'sveltekit-superforms/adapters';
import { fail } from '@sveltejs/kit';

const schema = z.object({
	mode: z.string(),
	document_id: z.string().optional(),
	file: z.any().optional(),
	user: z.number().int(),
	file_name: z.string(),
	date_from: z.date().transform((date) => date.toISOString().split('T')[0]),
	date_to: z.date().transform((date) => date.toISOString().split('T')[0]),
	date_archive: z.date().transform((date) => date.toISOString().split('T')[0]),
	collection: z.number().int()
});

export const actions = {
	upload: async ({ request, fetch }) => {
		const formData = await request.formData();

		const form = await superValidate(formData, zod(schema));

		console.log(form);

		if (!form.valid) {
			return fail(400, { form });
		}

		const file = formData.get('file');
		const { mode, document_id, user, collection, file_name, date_from, date_to, date_archive } =
			form.data;

		// determine if we're editing or creating
		const isEdit = mode === 'edit' && document_id;

		let query, variables;

		if (isEdit) {
			// edit mutation
			if (file && file.size > 0) {
				// update with new file
				query = `
       mutation UpdateFileWithNewFile(
         $id: ID!
         $file: Upload!
         $user: ID!
         $file_name: String!
         $date_from: Date!
         $date_to: Date!
         $date_archive: Date!
         $collection: ID!
       ) {
         updateFileWithNewFile(
           id: $id
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

				variables = {
					id: document_id,
					file: null,
					user,
					collection,
					file_name,
					date_from,
					date_to,
					date_archive
				};
			} else {
				// update without new file
				query = `
       mutation UpdateFile(
         $id: ID!
         $user: ID!
         $file_name: String!
         $date_from: Date!
         $date_to: Date!
         $date_archive: Date!
         $collection: ID!
       ) {
         updateFile(
           id: $id
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

				variables = {
					id: document_id,
					user,
					collection,
					file_name,
					date_from,
					date_to,
					date_archive
				};

				// simple JSON request for update without file
				const res = await fetch(`${API_URL}`, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					credentials: 'include',
					body: JSON.stringify({ query, variables })
				}).then((res) => res.json());

				return res.data;
			}
		} else {
			// create mutation (original)
			query = `
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

			variables = {
				file: null,
				user,
				collection,
				file_name,
				date_from,
				date_to,
				date_archive
			};
		}

		// multipart upload for create or edit with new file
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
	},
	archive: async ({ request, fetch }) => {
		const formData = await request.formData();
		const documentId = formData.get('document_id');

		const archiveMutation = `
    mutation ArchiveFile($id: ID!) {
     archiveFile(id: $id) {
      id
      collection {
       name
      }
     }
    }
   `;

		const response = await fetch(API_URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			credentials: 'include',
			body: JSON.stringify({
				query: archiveMutation,
				variables: { id: documentId }
			})
		});

		const result = await response.json();

		if (result.errors) {
			return fail(400, { error: result.errors[0].message });
		}

		return { success: true };
	},

	delete: async ({ request, fetch }) => {
		const formData = await request.formData();
		const documentId = formData.get('document_id');

		const deleteMutation = `
    mutation DeleteFile($id: ID!) {
     deleteFile(id: $id)
    }
   `;

		const response = await fetch(API_URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			credentials: 'include',
			body: JSON.stringify({
				query: deleteMutation,
				variables: { id: documentId }
			})
		});

		const result = await response.json();

		if (result.errors) {
			return fail(400, { error: result.errors[0].message });
		}

		return { success: true };
	}
};
