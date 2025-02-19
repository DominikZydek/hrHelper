import { API_URL } from '$env/static/private'
import {date, z} from 'zod'
import {superValidate} from "sveltekit-superforms";
import {zod} from "sveltekit-superforms/adapters";
import { fail } from "sveltekit-superforms";

const schema = z.object({
    organization_alias: z.string(),
    email: z.string().email(),
    password: z.string()
})

export const actions = {
    default: async ({ request, fetch }) => {
        const form = await superValidate(request, zod(schema))

        console.log(form)

        if (!form.valid) {
            return fail(400, {form})
        }

        let { organization_alias, email, password } = form.data

        const query = `
                mutation Login($organization_alias: String!, $email: String!, $password: String!) {
                    login(
                        organization_alias: $organization_alias
                        email: $email
                        password: $password
                    ) {
                        id
                    }
                }`

        const variables = {
            organization_alias, email, password
        }

        const res = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include',
            body: JSON.stringify({ query, variables })
        }).then(res => res.json())

        console.log(res)

        return { form }
    }
}