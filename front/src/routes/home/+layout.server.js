export const load = async({ locals, request, fetch }) => {
    return {
        user: locals.user
    }
}