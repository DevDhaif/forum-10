<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json"> --}}
     <!-- Favicon and app icons -->
     <link rel="icon" type="image/png" href="{{ asset('favicon-48x48.png') }}" sizes="48x48" />
     <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
     <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
     <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
     <meta name="apple-mobile-web-app-title" content="MyWebSite" />
     <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <!-- Background Image -->
        <div class="bg-cover bg-center bg-fixed min-h-screen flex justify-center items-center" style="background-image: url('{{ asset('bg.webp') }}')">

            <!-- Centered Form -->
            <div class="mx-4 p-8 rounded-lg shadow-white/50 backdrop-blur-xl shadow-lg bg-white/40 w-full sm:max-w-2xl  z-10 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <div class="flex justify-center mb-6">
                    <a href="/all">
                        <img src="{{ asset('favicon-96x96.png') }}" alt="logo" class="w-20 h-20 rounded-full">
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
