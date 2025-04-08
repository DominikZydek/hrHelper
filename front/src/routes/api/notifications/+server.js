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
	});

	const data = await res.json();

	return new Response(JSON.stringify(data), {
		status: res.status,
		headers: {
			'Content-Type': 'application/json'
		}
	});
};
