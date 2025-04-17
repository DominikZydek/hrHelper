import { API_URL } from '$env/static/private';

export const actions = {
	default: async ({ request, fetch }) => {
		const formData = await request.formData();

		const query = `
			mutation UploadFile($file: Upload!) {
				uploadFile(file: $file) {
					id
				}
			}
		`;

		// TODO: Fix, this doesn't get sent !!
		const variables = {
			file: formData.get('file')
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

		return res.data;
	}
};
