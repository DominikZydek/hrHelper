import {API_URL} from "$env/static/private";

export const load = async ({ request, fetch }) => {
    const query = `
        {
          me {
            id
            organization {
              name,
              holidays {
                name,
                date
              }
            }
            first_name
            last_name
            sex
            email
            birth_date
            phone_number
            address {
              id
              street_name
              street_number
              postal_code
              city
            }
            roles {
              id
              name
              display_name
              description
            }
            job_title
            supervisor {
              id
              first_name
              last_name
            }
            groups {
              id
              name
              icon_name
            }
            approval_process {
              id
              steps {
                order
                approver {
                  id
                  first_name
                  last_name
                  email
                  job_title
                  groups {
                    icon_name
                    name
                  }
                }
              }
            }
            type_of_employment
            paid_time_off_days
            available_pto
            pending_pto
            transferred_pto
            transferred_pto_expired_by
            working_time
            employed_from
            employed_to
            health_check_expired_by
            health_and_safety_training_expired_by
            leave_requests {
              id
              leave_type {
                id
                name
                limit_per_year
                requires_replacement
                min_notice_days
                can_be_cancelled
              }
              date_from
              date_to
              days_count
              reason
              comment
              status
              replacement {
                user {
                  id
                  first_name
                  last_name
                  email
                  groups {
                    icon_name
                    name
                  }
                  job_title
                }
                status
                comment
              }
              approval_process {
                steps {
                  order
                  approver {
                    id
                    first_name
                    last_name
                    email
                    groups {
                      icon_name
                      name
                    }
                    job_title
                  }
                }
              }
              current_approval_step
              approval_steps_history {
                step
                status
                comment
                date
                approver {
                  id
                  first_name
                  last_name
                  email
                  groups {
                    icon_name
                    name
                  }
                  job_title
                }
              }
            }
          }
          groups {
            id
            name
            icon_name
          }
        }`

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