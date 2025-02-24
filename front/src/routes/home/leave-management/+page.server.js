import {API_URL} from "$env/static/private";

export const load = async({ request, fetch }) => {
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
            role,
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
          }
        }
    `

    const res = await fetch(API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        credentials: 'include',
        body: JSON.stringify({ query })
    }).then(res => res.json())

    return res.data
}