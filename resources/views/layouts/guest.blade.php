<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <wireui:scripts />
    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">


        <div
            class="w-full {{ request()->routeIs('register') ? 'sm:max-w-xl' : 'sm:max-w-md' }} mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-lg">
            <div class="flex justify-center items-center space-x-4">
                <img src="{{ asset('images/school_logo.jpg') }}" class="h-20" alt="">
                <img src="{{ asset('images/ccs_logo.jpg') }}" class="h-20" alt="">
            </div>
            <div class="text-center mt-3 text-2xl text-gray-500 font-bold">CCS OJT PORTAL</div>
            <div class="mt-10">
                {{ $slot }}
            </div>
        </div>
    </div>
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
