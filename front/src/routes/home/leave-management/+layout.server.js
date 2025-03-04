import {API_URL} from "$env/static/private";

export const load = async({ request, fetch }) => {
    const query = `
        {
          me {
            id,
            paid_time_off_days,
            working_time,
            organization {
                holidays {
                    date,
                    name,
                }
            },  
            groups {
                name,
                users {
                    id,
                    first_name,
                    last_name,
                    email,
                    groups {
                        icon_name,
                        name
                    },
                    job_title,
                    leave_requests {
                        id,
                        date_from,
                        date_to,
                        leave_type {
                            id,
                            name,
                        },
                        user {
                            id,
                            first_name,
                            last_name
                        }
                    }
                }
            },
            leave_requests {
              id,
              leave_type {
                id,
                name,
                limit_per_year,
                requires_replacement,
                min_notice_days,
                can_be_cancelled
              },
              date_from,
              date_to,
              days_count,
              reason,
              comment,
              status,
              replacement {
                user {
                  id,
                  first_name,
                  last_name,
                  email,
                  groups {
                    icon_name,
                    name
                  },
                  job_title
                },
                status,
                comment
              },
              approval_process {
                steps {
                  order,
                  approver {
                    id,
                    first_name,
                    last_name,
                    email,
                    groups {
                      icon_name,
                      name
                    },
                    job_title
                  }
                }
              },
              current_approval_step,
              approval_steps_history {
                step,
                status,
                comment,
                date,
                approver {
                  id,
                  first_name,
                  last_name,
                  email,
                  groups {
                    icon_name,
                    name
                  },
                  job_title
                }
              }
            }
          },
          leaveRequestsAwaitingApproval {
              id,
              user {
                  id,
                  first_name,
                  last_name,
                  email,
                  groups {
                    icon_name,
                    name
                  },
                  job_title
                },
              leave_type {
                id,
                name,
                limit_per_year,
                requires_replacement,
                min_notice_days,
                can_be_cancelled
              },
              date_from,
              date_to,
              days_count,
              reason,
              comment,
              status,
              replacement {
                user {
                  id,
                  first_name,
                  last_name,
                  email,
                  groups {
                    icon_name,
                    name
                  },
                  job_title
                },
                status,
                comment
              },
              approval_process {
                steps {
                  order,
                  approver {
                    id,
                    first_name,
                    last_name,
                    email,
                    groups {
                      icon_name,
                      name
                    },
                    job_title
                  }
                }
              },
              current_approval_step,
              approval_steps_history {
                step,
                status,
                comment,
                date,
                approver {
                  id,
                  first_name,
                  last_name,
                  email,
                  groups {
                    icon_name,
                    name
                  },
                  job_title
                }
              }
            },
            leaveTypes {
                id,
                name,
                limit_per_year,
                requires_replacement,
                min_notice_days,
                can_be_cancelled
              },
              users {
                id,
                    first_name,
                    last_name,
                    email,
                    groups {
                      icon_name,
                      name
                    },
                    job_title,
                    employed_from
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

    console.log(res.data.me)

    return res.data
}