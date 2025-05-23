<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
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
                <livewire:userdropdown />

            </div>
            <main class="relative flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6 px-3 2xl:px-0">
                    <div class="mx-auto py-5 2xl:max-w-7xl">
                        @if (request()->routeIs('supervisor.dashboard'))
                            <h1 class="text-xl text-gray-700">Hello, <strong
                                    class="italic">{{ auth()->user()->name }}</strong></h1>
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
