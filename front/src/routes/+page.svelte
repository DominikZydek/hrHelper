<script>
	import { onMount } from 'svelte';
	import { PUBLIC_API_URL } from '$env/static/public';
	import { superForm } from 'sveltekit-superforms';

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

<div class="w-screen h-screen flex">
	<div class="w-2/3 bg-[url(/login-screen-bg.jpg)] bg-cover relative">
		<div class="absolute inset-0 bg-main-black bg-opacity-40 flex items-center justify-center">
			<div class="flex flex-col items-center justify-center gap-10">
				<p class="text-8xl text-main-white font-poppins">hrHelper</p>
				<p class="text-4xl text-main-white font-poppins">
					Wynieś dział HR Twojej firmy na najwyższy poziom.
				</p>
			</div>
		</div>
	</div>
	<div class="w-1/3 flex items-center justify-center">
		<form method="POST" class="flex flex-col" use:enhance>
			<div class="flex gap-2 items-center">
				<img class="h-12 w-12" src="/favicon.png" alt="logo" />
				<p class="text-4xl font-poppins">hrHelper</p>
			</div>
			<input
				id="organization_alias"
				name="organization_alias"
				type="text"
				placeholder="Identyfikator organizacji"
				bind:value={$form.organization_alias}
			/>
			<input id="email" name="email" type="email" placeholder="E-mail" bind:value={$form.email} />
			<input
				id="password"
				name="password"
				type="password"
				placeholder="Hasło"
				bind:value={$form.password}
			/>
			{#if $message}
				<small class="text-accent-red">{$message}</small>
			{/if}
			<div class="flex">
				<button
					type="submit"
					class="flex gap-1 items-center bg-accent-green text-main-white font-semibold h-8 px-4"
				>
					Zaloguj
				</button>
				<button type="button" class="flex gap-1 items-center text-main-gray h-8 px-4">
					Zapomniałeś hasła?
				</button>
			</div>
		</form>
	</div>
</div>
