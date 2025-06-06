<div x-data="{
    slideOverOpen: @entangle('viewData')
}">
    {{ $this->table }}

    <div class="relative z-50 w-auto h-auto">
        <template x-teleport="body">
            <div x-show="slideOverOpen" @keydown.window.escape="slideOverOpen=false" class="relative z-[99]">
                <div x-show="slideOverOpen" x-transition.opacity.duration.600ms @click="slideOverOpen = false"
                    class="fixed inset-0 bg-black bg-opacity-10"></div>
                <div class="fixed inset-0 overflow-hidden">
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                            <div x-show="slideOverOpen" @click.away="slideOverOpen = false"
                                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                class="w-screen max-w-md">
                                <div
                                    class="flex flex-col h-full py-5 overflow-y-scroll bg-white border-l shadow-lg border-neutral-100/70">
                                    <div class="px-4 sm:px-5">
                                        <div class="flex items-start justify-between pb-1">
                                            <h2 class="text-base font-semibold leading-6 text-gray-900"
                                                id="slide-over-title">View Information</h2>
                                            <div class="flex items-center h-auto ml-3">
                                                <button @click="slideOverOpen=false"
                                                    class="absolute top-0 right-0 z-30 flex items-center justify-center px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    <span>Close</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 px-4 mt-5 sm:px-5">
                                        <div class="absolute inset-0 px-4 sm:px-5">
                                            <div class="relative h-full overflow-hidden ">
                                                @if ($user_data)
                                                    @if ($user_data->user_type == 'student')
                                                        <div>
                                                            <x-badge flat info icon="user" label="Student" />
                                                        </div>
                                                    @else
                                                        <div>
                                                            <x-badge flat negative icon="user" label="Supervisor" />
                                                            <div class="mt-5">
                                                                <div class="grid-cols-2 grid gap-5">
                                                                    <div>
                                                                        <h1 class="text-xs uppercase">Firstname</h1>
                                                                        <h1 class="font-bold leading-3 text-gray-700">
                                                                            {{ $user_data->supervisor->firstname ?? '' }}
                                                                        </h1>
                                                                    </div>
                                                                    <div>
                                                                        <h1 class="text-xs uppercase">Middlename</h1>
                                                                        <h1 class="font-bold leading-3 text-gray-700">
                                                                            {{ $user_data->supervisor->middlename ?? '' }}
                                                                        </h1>
                                                                    </div>
                                                                    <div>
                                                                        <h1 class="text-xs uppercase">Contact</h1>
                                                                        <h1 class="font-bold leading-3 text-gray-700">
                                                                            {{ $user_data->supervisor->contact_number ?? '' }}
                                                                        </h1>
                                                                    </div>
                                                                </div>
                                                                <div class="grid-cols-2 mt-10 grid gap-5">
                                                                    <div>
                                                                        <h1 class="text-xs uppercase">Company Name</h1>
                                                                        <h1 class="font-bold leading-3 text-gray-700">
                                                                            {{ $user_data->supervisor->company_name ?? '' }}
                                                                        </h1>
                                                                    </div>
                                                                    <div>
                                                                        <h1 class="text-xs uppercase">Company Address
                                                                        </h1>
                                                                        <h1 class="font-bold leading-3 text-gray-700">
                                                                            {{ $user_data->supervisor->company_address ?? '' }}
                                                                        </h1>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>


</div>
