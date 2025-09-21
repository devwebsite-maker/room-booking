@extends('layouts.guest')

@section('content')
    <div>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 font-serif">Create an Account</h2>
        <p class="mt-2 text-gray-500">Join us and start booking your perfect stay.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
        @csrf

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="bi bi-person text-gray-400"></i>
            </div>
            <label for="name" class="sr-only">Name</label>
            <input id="name" class="block mt-1 w-full pl-10 py-3 bg-gray-50 border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Full Name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="relative">
             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="bi bi-envelope text-gray-400"></i>
            </div>
            <label for="email" class="sr-only">Email</label>
            <input id="email" class="block mt-1 w-full pl-10 py-3 bg-gray-50 border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="your@email.com"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="bi bi-lock text-gray-400"></i>
            </div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" class="block mt-1 w-full pl-10 py-3 bg-gray-50 border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="password" name="password" required autocomplete="new-password" placeholder="Password"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="bi bi-lock text-gray-400"></i>
            </div>
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <input id="password_confirmation" class="block mt-1 w-full pl-10 py-3 bg-gray-50 border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Register
        </button>
        
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a class="font-medium text-teal-600 hover:underline" href="{{ route('login') }}">
                    Sign in
                </a>
            </p>
        </div>
    </form>
@endsection