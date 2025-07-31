<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="relative min-h-screen w-full flex items-center justify-center p-4"
         style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <div class="relative z-10 text-center w-full max-w-7xl mx-auto px-4">
            <h1 class="text-white text-4xl md:text-5xl mb-8 drop-shadow-lg" style="font-family: 'Poppins', sans-serif;">
                Selamat Datang Admin <span class="text-white-300 font-bold">Indibiz</span>
            </h1>

            <div class="bg-white rounded-xl shadow-xl p-8 sm:p-10 max-w-xl mx-auto">
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Indibiz Logo" class="w-36 h-auto">
                </div>

                @if (session('status'))
                    <div class="mb-4 text-sm text-red-600 text-left">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Username --}}
                    <div class="mb-4" style="font-family: 'Poppins', sans-serif;">
                        <x-input-label for="username" :value="__('Username')" class="text-left" />
                        <div class="relative">
                            <x-text-input
                                id="username"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm placeholder-gray-400"
                                type="text"
                                name="username"
                                :value="old('username')"
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan username anda"
                            />
                        </div>
                        @error('username')
                            <p class="mt-2 text-sm text-red-600 text-left">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mt-4 mb-4" style="font-family: 'Poppins', sans-serif;">
                        <x-input-label for="password" :value="__('Password')" class="text-left" />
                        <div class="relative">
                            <x-text-input
                                id="password"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm pr-10 placeholder-gray-400"
                                type="password"
                                name="password"
                                autocomplete="current-password"
                                placeholder="Masukkan password anda"
                            />
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500" onclick="togglePasswordVisibility()">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="password-toggle-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </span>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 text-left">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="block mt-4 text-left">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingatkan saya') }}</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <div class="flex items-center justify-center mt-6">
                        <x-primary-button class="w-full justify-center py-2 px-4 rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            {{ __('Masuk') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const passwordToggleIcon = document.getElementById('password-toggle-icon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            if (type === 'password') {
                passwordToggleIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            } else {
                passwordToggleIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.33 0 2.618.22 3.823.633M6.43 6.43L2.5 12l9.5 7.5 7-7.5" />`;
            }
        }
    </script>
</body>
</html>
