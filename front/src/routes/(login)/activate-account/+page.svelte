<script>
	import { superForm } from 'sveltekit-superforms';
	import { onMount } from 'svelte';
	import { PUBLIC_API_URL } from '$env/static/public';
	export let data;
	const { form, errors, constraints, message, enhance } = superForm(data.form, {
		resetForm: false,
		onResult: ({ result }) => {
			// clear messages on submit
			message.set('');
		}
	});

	onMount(async () => {
		await fetch(`${PUBLIC_API_URL}/sanctum/csrf-cookie`, {
			credentials: 'include'
		});
	});
</script>

<!-- TODO: style it better -->
<p class="font-semibold text-lg">
	Witaj {data.user.first_name}
	{data.user.last_name},<br />aktywuj swoje konto w firmie {data.user.organization.name}
</p>
<form method="POST" class="flex flex-col w-1/2" use:enhance>
	<div class="flex gap-2 items-center">
		<img class="h-12 w-12" src="/favicon.png" alt="logo" />
		<p class="text-4xl font-poppins">hrHelper</p>
	</div>
	<input
		class="px-1 {$errors.password ? 'outline-accent-red border border-accent-red' : ''}"
		aria-invalid={$errors.password ? 'true' : ''}
		id="password"
		name="password"
		type="password"
		placeholder="Hasło"
		bind:value={$form.password}
	/>
	{#if $errors.password}
		<small class="text-accent-red">{$errors.password[0]}</small>
	{/if}
	<input
		class="px-1 {$errors.confirm_password ? 'outline-accent-red border-accent-red' : ''}"
		aria-invalid={$errors.confirm_password ? 'true' : ''}
		id="confirm_password"
		name="confirm_password"
		type="password"
		placeholder="Potwierdź hasło"
		bind:value={$form.email}
	/>
	{#if $errors.confirm_password}
		<small class="text-accent-red">{$errors.confirm_password[0]}</small>
	{/if}
	<div class="flex">
		<button
			type="submit"
			class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4"
		>
			Aktywuj konto
		</button>
	</div>
</form>
