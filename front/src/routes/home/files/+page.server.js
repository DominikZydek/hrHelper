import { API_URL } from '$env/static/private';

export const actions = {
	default: async ({ request, fetch }) => {
		const formData = await request.formData();
		const file = formData.get('file');

		const operations = JSON.stringify({
			query: `
        mutation UploadFile($file: Upload!, $user: ID!, $collection: String!) {
          uploadFile(file: $file, user: $user, collection: $collection) {
            id
          }
        }
      `,
			variables: {
				file: null,
				user: formData.get('user'),
				collection: formData.get('collection')
			}
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

		console.log(res);

		return res.data;
	}
};
