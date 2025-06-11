import { API_URL } from '$env/static/private';
import { redirect } from '@sveltejs/kit';

export const load = async ({ locals, request, fetch }) => {
	const query = `
        query ($organization: ID!) {
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
					leaveRequests(organization: $organization) {
						id
						user {
							id
							first_name
							last_name
							email
							job_title
							groups {
              id
              name
              icon_name
            }
						}
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
					absentEmployees(organization: $organization) {
						id
						first_name
						last_name
						email
						groups {
							icon_name
							name
						}
						job_title
						leave_requests {
							id
						user {
							id
							first_name
							last_name
							email
							job_title
							groups {
              id
              name
              icon_name
            }
						}
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
					},
					users(organization: $organization) {
						id
						first_name
						last_name
						email
						groups {
							icon_name
							name
						}
						job_title
						type_of_employment
						paid_time_off_days
						working_time
						employed_from
						employed_to
						available_pto
						pending_pto
						transferred_pto
						transferred_pto_expired_by
						health_check_expired_by
						health_and_safety_training_expired_by
					}
        }`;

	const { user } = locals;

	const variables = {
		organization: user.organization.id
	};

	const res = await fetch(API_URL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		credentials: 'include',
		body: JSON.stringify({ query, variables })
	}).then((res) => res.json());

	return res.data;
};

export const actions = {
	logout: async ({ request, fetch, cookies }) => {
		const query = `
      mutation {
        logout {
          id
        }
      }
    `;

		const res = await fetch(API_URL, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			credentials: 'include',
			body: JSON.stringify({ query })
		}).then((res) => res.json());

		console.log(res);

		if (res.data && res.data.logout) {
			cookies.delete('laravel_session', { path: '/' });
			cookies.delete('XSRF-TOKEN', { path: '/' });

			throw redirect(302, '/');
		}
	}
};
