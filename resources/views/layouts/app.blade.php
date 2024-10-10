<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
     <!-- Favicon and app icons -->
     <link rel="icon" type="image/png" href="{{ asset('favicon-48x48.png') }}" sizes="48x48" />
     <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
     <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
     <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
     <meta name="apple-mobile-web-app-title" content="MyWebSite" />
     <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" /> --}}

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>

<body class="antialiased text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900">
    {{-- <div class="min-h-screen bg-gray-100" id="app">
        <flash message="{{ session('flash') }}">
        </flash>
        @include('layouts.navigation')
        <!-- Page Content -->
        <main class="container max-w-screen-xl p-4 mx-auto">
            <!--  content -->
            @yield('content')
        </main>
    </div> --}}
    @inertia
</body>

</html>
