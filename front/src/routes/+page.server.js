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
    login: async ({ request, fetch }) => {
        const form = await superValidate(request, zod(schema))

        console.log(form)

        if (!form.valid) {
            return fail(400, {form})
        }
    }
}