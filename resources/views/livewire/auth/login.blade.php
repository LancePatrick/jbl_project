<x-layouts.auth>
    <!-- Background + dim overlay -->
    <div class="min-h-dvh bg-[url('/images/loginVisual.png')] bg-cover bg-center bg-no-repeat">
        <div class="min-h-dvh grid place-items-center bg-black/70">

            <!-- Card -->
            <div class="w-[90%] max-w-md rounded-2xl bg-white/90 dark:bg-neutral-900/90 backdrop-blur p-6 shadow-xl dark:text-white border border-emerald-700">

                <!-- Header (keeps your original component but copy the wording of design #2) -->
                <x-auth-header
                    :title="__('Welcome Back')"
                    :description="__('Sign in with your email')"
                />

                <!-- Session Status -->
                <x-auth-session-status class="text-center" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <flux:input
                        name="email"
                        :label="__('Email address')"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="email@example.com"
                        class="w-full p-3 rounded-lg bg-gray-400/30 dark:bg-white/10 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                    />

                    <!-- Password + Forgot -->
                    <div class="relative">
                        <flux:input
                            name="password"
                            :label="__('Password')"
                            type="password"
                            required
                            autocomplete="current-password"
                            :placeholder="__('Password')"
                            viewable
                            class="w-full p-3 rounded-lg bg-gray-400/30 dark:bg-white/10 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                        />

                        @if (Route::has('password.request'))
                            <flux:link
                                class="absolute top-0 end-0 text-xs md:text-sm text-emerald-700 hover:underline dark:text-emerald-300"
                                :href="route('password.request')"
                                wire:navigate
                            >
                                {{ __('Forgot password?') }}
                            </flux:link>
                        @endif
                    </div>

                    <!-- Remember me + (kept your component) -->
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <flux:checkbox
                            name="remember"
                            :label="__('Stay signed in')"
                            :checked="old('remember')"
                        />
                    </div>

                    <!-- Submit -->
                    <div>
                        <flux:button
                            variant="primary"
                            type="submit"
                            class="w-full p-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 transition font-semibold text-white"
                            data-test="login-button"
                        >
                            {{ __('Sign In') }}
                        </flux:button>
                    </div>
                </form>

                <!-- Register link -->
                @if (Route::has('register'))
                    <div class="mt-4 space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-700 dark:text-zinc-300">
                        <span>{{ __('Don\'t have an account?') }}</span>
                        <flux:link
                            :href="route('register')"
                            wire:navigate
                            class="font-semibold text-emerald-600 hover:text-emerald-500 underline underline-offset-2"
                        >
                            {{ __('Sign up') }}
                        </flux:link>
                    </div>
                @endif

            </div>
            <!-- /Card -->

        </div>
    </div>
</x-layouts.auth>
