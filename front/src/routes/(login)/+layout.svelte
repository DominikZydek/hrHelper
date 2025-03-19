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
	<div class="w-1/3 flex items-center justify-center flex-col gap-5">
		<slot />
	</div>
</div>
