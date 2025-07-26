<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="mt-2">
        <div class="flex items-center justify-center w-full max-w-md sm:max-w-lg mx-auto mb-4">
            <img class="h-[30px] w-[60px] sm:h-[50px] sm:w-[100px] mb-2" src="{{ asset('images/logoz.png') }}" alt="Description of Image">
            <a href="/" class="block">
                <h1  class="text-5xl xs:text-4xl sm:text-5xl md:text-5xl font-extrabold bg-gradient-to-r from-teal-800 to-cyan-300 text-transparent bg-clip-text">
                    OffSuppSys
                </h1>
            </a>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="w-full">
            @csrf
        
            <!-- Email Address -->
      <div class="mb-4 relative">
    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-1" />

    <!-- Icon inside input -->
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-teal-600">
            <i class="fas fa-user"></i>
        </span>
        
        <x-text-input 
            id="email" 
            class="pl-10 block w-full px-4 py-2 text-gray-800 bg-white/90 border border-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-teal-300 focus:border-teal-300 placeholder-gray-400 transition duration-150 ease-in-out" 
            type="email" 
            name="email" 
            :value="old('email')" 
            placeholder="example@gmail.com" 
            required 
            autofocus 
            autocomplete="username" 
        />
    </div>

    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
</div>

        
           <!-- Password -->
<div x-data="{ show: false }" class="mb-4 relative">
    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-1" />

    <div class="relative">
        <!-- Lock Icon (Left) -->
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-teal-600">
            <i class="fas fa-lock"></i>
        </span>

        <!-- Password Input -->
        <input 
            :type="show ? 'text' : 'password'" 
            id="password"
            name="password"
            required 
            autocomplete="current-password"
            class="pl-10 pr-12 block w-full px-4 py-2 text-gray-800 bg-white/90 border border-gray-200 rounded-md shadow-sm focus:ring-2 focus:ring-teal-300 focus:border-teal-300 transition duration-150 ease-in-out"
        />

        <!-- Eye Toggle Icon (Right) -->
        <div @click="show = !show" 
             class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.146-3.328m3.177-2.197A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.969 9.969 0 01-4.202 5.178M15 12a3 3 0 00-3-3m0 0a3 3 0 013 3m0 0a3 3 0 01-3 3m0-6v.01" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
            </svg>
        </div>
    </div>

    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
</div>


            <!-- Remember Me -->
            <div class="flex items-center mb-4">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="h-4 w-4 rounded border-gray-300 text-teal-500 focus:ring-teal-300 transition duration-150 ease-in-out" 
                    name="remember"
                >
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                    {{ __('Remember me') }}
                </label>
            </div>
        
            <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-teal-500 hover:text-teal-700 focus:outline-none focus:underline transition duration-150 ease-in-out" 
                    href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
        
                <x-primary-button class="w-50 sm:w-auto px-6 py-2 bg-teal-500 hover:bg-teal-600 focus:bg-teal-600 active:bg-teal-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-300 transition duration-150 ease-in-out">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>