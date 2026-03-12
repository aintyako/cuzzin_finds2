<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-2xl font-black text-white tracking-tight italic">Welcome Back</h2>
        <p class="text-gray-400 text-sm mt-1 font-medium">Please enter your details to sign in.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-400 font-bold uppercase text-[10px] tracking-widest" />
            <x-text-input id="email" class="block mt-1 w-full bg-[#0f172a] border-gray-700 text-white focus:ring-indigo-500 focus:border-indigo-500 rounded-2xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-400 font-bold uppercase text-[10px] tracking-widest" />
            <x-text-input id="password" class="block mt-1 w-full bg-[#0f172a] border-gray-700 text-white focus:ring-indigo-500 focus:border-indigo-500 rounded-2xl"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-700 bg-[#0f172a] text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-400 font-medium">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col space-y-4 mt-8">
            <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-widest text-xs rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('password.request'))
                <a class="text-center text-xs text-gray-500 hover:text-indigo-400 font-bold uppercase tracking-widest transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>