import {z} from "zod";
import {superValidate} from "sveltekit-superforms";
import {zod} from "sveltekit-superforms/adapters";
import {fail} from "@sveltejs/kit";
import {API_URL} from "$env/static/private";

const schema = z.object({
    leave_type: z.number().int(),
    date_from: z.date().transform(date => date.toISOString().split('T')[0]),
    date_to: z.date().transform(date => date.toISOString().split('T')[0]),
    reason: z.string(),
    comment: z.string().nullable(),
    replacement: z.number().int().nullable(),
    save_as_draft: z.boolean()
})

export const actions = {
    createLeaveRequest: async ({ fetch, request }) => {
        const form = await superValidate(request, zod(schema))

        console.log(form)

        if (!form.valid) {
            return fail(400, { form })
        }

        let { leave_type, date_from, date_to, reason, comment, replacement, save_as_draft } = form.data

        const query = `
        mutation CreateLeaveRequest($leave_type: ID!, $date_from: Date!, $date_to: Date!, $reason: String!, $comment: String, $replacement: ID, $save_as_draft: Boolean!) {
              createLeaveRequest(
                leave_type: $leave_type,
                date_from: $date_from,
                date_to: $date_to,
                reason: $reason,
                comment: $comment,
                replacement: $replacement,
                save_as_draft: $save_as_draft
              ) {
                id
              }
            }
        `

        const variables = {
            leave_type, date_from, date_to, reason, comment, replacement, save_as_draft
        }

        const res = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include',
            body: JSON.stringify({ query, variables })
        }).then(res => res.json())

        console.log(res.data ? res.data : res.errors)

        return { form }
    }
}