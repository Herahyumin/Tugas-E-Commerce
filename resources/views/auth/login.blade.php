{{-- Kita tidak akan menggunakan x-guest-layout di sini untuk kontrol penuh atas background --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-800 to-purple-900 opacity-90 z-0"></div>
        <div class="absolute inset-0 z-0" 
             style="background-image: url('https://images.unsplash.com/photo-1550745165-9bc0b252726a?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; filter: blur(2px);">
        </div>
        
        <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-8 bg-white/90 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-xl border border-white/30">
            
            <div class="text-center mb-10">
                <a href="/">
                    <h1 class="text-5xl font-extrabold text-indigo-700 tracking-tight drop-shadow-lg">Computer-OnShop</h1>
                </a>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-white/80 border-gray-300 rounded-md shadow-sm placeholder-gray-500 focus:border-purple-600 focus:ring-purple-600" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-white/80 border-gray-300 rounded-md shadow-sm placeholder-gray-500 focus:border-purple-600 focus:ring-purple-600"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500" name="remember">
                        <span class="ml-2 text-sm text-gray-800">{{ __('Ingat saya') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-800 hover:text-purple-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition ease-in-out duration-150" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 shadow-md hover:shadow-lg transition ease-in-out duration-150">
                        {{ __('Log In') }}
                    </x-primary-button>
                </div>

                <div class="text-center mt-8 border-t border-gray-300 pt-6">
                    <p class="text-sm text-gray-800">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-purple-600 hover:text-purple-800 transition ease-in-out duration-150">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>