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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <section class="h-auto bg-white">
        <div class="max-w-7xl mx-auto py-16 px-10 sm:py-24 sm:px-6 lg:px-8 sm:text-center">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase"></h2>
            <div class="flex mt-10 justify-center items-end space-x-3">
                <img src="{{ asset('images/school_logo.jpg') }}" class="h-20" alt="">
                <img src="{{ asset('images/ccs_logo.jpg') }}" class="h-20" alt="">

            </div>
            <p class="mt-5 text-4xl font-extrabold text-main sm:text-5xl sm:tracking-tight lg:text-6xl">CCS OJT
                PORTAL</p>
            <p class="max-w-3xl mt-5 mx-auto text-xl text-gray-300">Please hold on while the coordinator reviews and
                approves your account.
            </p>
            <div class="mt-5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button href="route('logout')"
                        onclick="event.preventDefault();
                                this.closest('form').submit();"
                        label="Logout" negative rounded lg class="font-semibold" right-icon="arrow-uturn-right" />
                </form>
            </div>
        </div>
    </section>



</body>

</html>
