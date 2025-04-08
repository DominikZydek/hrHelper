import { API_URL } from '$env/static/private';

export const POST = async ({ request, fetch }) => {
	const { query, variables } = await request.json();

	if (!query) {
		return new Response(
			JSON.stringify({
				message: 'Wystąpił błąd'
			}),
			{
				status: 400
			}
		);
	}

	const res = await fetch(API_URL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		credentials: 'include',
		body: JSON.stringify({ query, variables })
	}).then((res) => res.json());

	console.log(res);

	if (res.errors) {
		return new Response(
			JSON.stringify({
				message: 'Wystąpił błąd'
			}),
			{
				status: 400
			}
		);
	}

	return new Response(
		JSON.stringify({
			message: 'Sukces'
		}),
		{
			status: 200
		}
	);
};
