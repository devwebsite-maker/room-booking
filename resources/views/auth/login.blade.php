@extends('layouts.guest')

@section('content')
    <div>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 font-serif">Welcome Back!</h2>
        <p class="mt-2 text-gray-500">Sign in to continue to your account.</p>
    </div>

    <x-auth-session-status class="my-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
        @csrf

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="bi bi-envelope text-gray-400"></i>
            </div>
            <label for="email" class="sr-only">Email</label>
            <input id="email" class="block mt-1 w-full pl-10 py-3 bg-gray-50 border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="your@email.com"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="bi bi-lock text-gray-400"></i>
            </div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" class="block mt-1 w-full pl-10 py-3 bg-gray-50 border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="password" name="password" required autocomplete="current-password" placeholder="Password"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
                <span class="ms-2 text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="font-medium text-teal-600 hover:text-teal-500 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Log in
        </button>
        
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Don't have an account? 
                <a class="font-medium text-teal-600 hover:underline" href="{{ route('register') }}">
                    Sign up
                </a>
            </p>
        </div>
    </form>
@endsection