<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @yield('body')




    @livewireScripts

    @if (Route::currentRouteName() !== 'talk.show')
        <footer class="bg-gray-800 text-sm py-4 text-gray-400 fixed-bottom">
            <div class="container mx-auto flex justify-between">
                <div>
                    DH+ group, SIB, Lausanne
                </div>
                <div>
                    <a class="text-gray-400 hover:text-white " href="{{ route('about') }}">About</a>
                    <a class="text-gray-400 hover:text-white ml-3" href="{{ route('contact') }}">Contact</a>
                </div>
            </div>
        </footer>
    @endif
</body>

</html>
