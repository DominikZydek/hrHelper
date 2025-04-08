// routes/api/broadcasting/auth/+server.js
import { API_URL } from '$env/static/private';
import { PUBLIC_API_URL } from '$env/static/public';

export const POST = async ({ request, fetch, cookies }) => {
	const formData = await request.formData();

	// Create a new request to Laravel
	const req = new Request(`${PUBLIC_API_URL}/broadcasting/auth`, {
		method: 'POST',
		body: formData
	});

	// Forward all the cookies from the original request
	const allCookies = [];
	cookies.getAll().forEach((cookie) => {
		allCookies.push(`${cookie.name}=${encodeURIComponent(cookie.value)}`);
	});
	req.headers.set('cookie', allCookies.join('; '));

	// Add CSRF token if you have it
	const xsrfToken = cookies.get('XSRF-TOKEN');
	if (xsrfToken) {
		req.headers.set('X-XSRF-TOKEN', decodeURIComponent(xsrfToken));
	}

	// Make the request to Laravel
	const response = await fetch(req);

	// Return the response
	return new Response(await response.text(), {
		status: response.status,
		headers: {
			'Content-Type': response.headers.get('Content-Type') || 'application/json'
		}
	});
};
