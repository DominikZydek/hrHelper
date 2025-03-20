import { parse } from 'cookie';
import { redirect } from '@sveltejs/kit';
import { API_URL, FRONTEND_URL } from '$env/static/private';

export const handleFetch = async ({ event, request, fetch }) => {
	const isApiRequest = true; //request.url.startsWith('http://localhost');

	if (isApiRequest) {
		request = new Request(request.url, request);

		let eventCookies = [];
		event.cookies.getAll().forEach((v) => {
			eventCookies.push(`${v.name}=${encodeURIComponent(v.value)}`);
		});
		request.headers.set('cookie', eventCookies.join('; '));

		// add xsrf token
		const xsrfToken = decodeURIComponent(event.cookies.get('XSRF-TOKEN'));
		request.headers.set('X-XSRF-TOKEN', xsrfToken);
	}

	const fetchResponse = await fetch(request);

	if (isApiRequest) {
		const setCookie = fetchResponse.headers.getSetCookie();

		setCookie.forEach((cookieString) => {
			const parsed = parse(cookieString);
			const name = Object.keys(parsed)[0];

			const { [name]: value, ...params } = parsed;

			try {
				event.cookies.set(name, value, {
					expires: new Date(params['expires']),
					maxAge: parseInt(params['Max-Age']),
					path: params['path'],
					sameSite: params['samesite'],
					secure: false
				});
			} catch (e) {}
		});
	}
	return fetchResponse;
};

export const handle = async ({ event, resolve }) => {
	if (event.url.pathname.startsWith('/graphql')) {
		return resolve(event);
	}

	// check if we have necessary cookies
	// TODO: activate-account route is giving 419 back, fix that
	const xsrfToken = event.cookies.get('XSRF-TOKEN');
	if (!xsrfToken && event.url.pathname === '/') {
		return resolve(event);
	}

	const query = `{
        me {
            id,
            organization {
            		id,
                name
            },
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
            type_of_employment
            paid_time_off_days
            available_pto
            pending_pto
            transferred_pto
            transferred_pto_expired_by
            working_time
            employed_from,
            employed_to,
            health_check_expired_by,
            health_and_safety_training_expired_by,
            activation_token
          },
          groups {
            id,
            name,
            icon_name
          }
        }`;

	const request = new Request(API_URL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify({ query })
	});

	const fetchResponse = await handleFetch({
		event,
		request,
		fetch: event.fetch.bind(event)
	});

	let authenticatedUser = null;

	if (fetchResponse.ok) {
		const res = await fetchResponse.json();
		if (res.data && res.data.me) {
			authenticatedUser = res.data.me;
			event.locals.user = res.data.me;
		}
	}

	// handle routing based on auth status
	if (authenticatedUser) {
		if (event.url.pathname === '/') {
			throw redirect(303, `${FRONTEND_URL}/home`);
		}
	} else if (event.url.pathname !== '/' && !event.url.pathname.startsWith('/activate-account')) {
		throw redirect(303, `${FRONTEND_URL}/`);
	}

	return resolve(event);
};
