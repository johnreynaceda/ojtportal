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

    <style>
        [x-cloak] {
            display: none !important;
        }

        .fi-ta-header-cell {
            background-color: #800000;
        }

        .fi-ta-header-cell-label {
            color: white !important;
        }



        .fi-ta-actions-header-cell {
            background-color: #800000;
        }
    </style>
    <wireui:scripts />
    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="font-sans antialiased">
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-main ">
                    <div class="flex flex-col flex-shrink-0 px-4">

                        <button class="hidden rounded-lg focus:outline-none focus:shadow-outline">
                            <svg fill="currentColor" viewBox="0 0 20 20" class="size-6">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-col flex-grow px-4 ">
                        <center>
                            <img src="{{ asset('images/ccs_logo.jpg') }}" class="h-20 rounded-full" alt="">
                            <h1 class="mt-2 text-lg font-bold text-white uppercase"> CCS OJT PORTAL</h1>

                        </center>
                        <div>
                            <livewire:sidebar />
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="flex flex-col relative flex-1 w-0 overflow-hidden">
            <div class="bg-white py-3 flex justify-end space-x-3 items-center px-12">

                <a href="{{ route('student.resume') }}" class="text-main">
                    <svg width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                        <path
                            d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 144-208 0c-35.3 0-64 28.7-64 64l0 144-48 0c-35.3 0-64-28.7-64-64L0 64zm384 64l-128 0L256 0 384 128zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z">
                        </path>
                    </svg>
                </a>

                <livewire:userdropdown />

            </div>
            <main class="relative flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6 px-3 2xl:px-0">
                    <div class="mx-auto py-5 2xl:max-w-7xl">
                        @if (request()->routeIs('student.dashboard'))
                            <h1 class="text-xl text-gray-700">Hello, <strong
                                    class="italic">{{ auth()->user()->name }}</strong></h1>
                            @if (auth()->user()->student->status == 'deployed')
                                <p class="text-sm mt-1 text-gray-600">you are deployed at
                                    <strong
                                        class="text-main uppercase">{{ auth()->user()->student->trainee->supervisor->company_name }}</strong>
                                    .
                                </p>
                            @endif
                        @else
                            <h1 class="text-xl text-gray-700 font-bold">@yield('title')</h1>
                        @endif
                        <div class="mt-10">{{ $slot }}</div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
