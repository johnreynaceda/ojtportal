<div class="ml-3 flex space-x-1 items-center" x-data="{ modalOpen: @entangle('openModal') }" @keydown.escape.window="modalOpen = false"
    wire:ignore>
    @if (request()->routeIs('coordinator.class'))
        <x-mini-button rounded icon="arrow-top-right-on-square" wire:click="deployStudent({{ $getRecord()->id }})"
            positive />
        <x-mini-button rounded icon="x-circle" negative wire:click="dropStudent({{ $getRecord()->id }})" />
        <x-mini-button rounded icon="eye" warning wire:click="viewStudent({{ $getRecord()->id }})" />
    @else
        <x-mini-button rounded icon="eye" warning wire:click="view({{ $getRecord()->id }})" />
        <x-mini-button rounded :disabled="$getRecord()->is_approved == true" icon="check-badge" wire:click="updateStatus({{ $getRecord()->id }})"
            spinner="updateStatus({{ $getRecord()->id }})" positive />

        {{-- <x-mini-button rounded icon="x-circle" negative /> --}}
    @endif

    <x-filament::modal id="view-user" slide-over width="3xl">
        <x-slot name="heading">
            View Student
        </x-slot>
        <div>
            <div class="grid grid-cols-3 mt-10 gap-5">
                <div>
                    <label for="">Last Name</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.lastname" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">First Name</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.firstname" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Middle Name</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.middlename" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Course</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.course" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Major</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.major" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Section</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.section" disabled />
                    </x-filament::input.wrapper>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-5 gap-5">
                <div>
                    <label for="">Student ID</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.id" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Institutional Email</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.email" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Address</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.address" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Contact No.</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.contact" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Guardian Name</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.guardian" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Contact No.</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="student.guardian_contact" disabled />
                    </x-filament::input.wrapper>
                </div>
            </div>
        </div>
    </x-filament::modal>


    <x-filament::modal id="view-supervisor" slide-over width="3xl">
        <x-slot name="heading">
            View Supervisor
        </x-slot>
        <div>
            <div class="grid grid-cols-3 mt-10 gap-5">
                <div>
                    <label for="">Last Name</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="supervisor.lastname" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">First Name</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="supervisor.firstname" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Middle Name</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="supervisor.middlename" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Company Name</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="supervisor.company_name" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div>
                    <label for="">Contact</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="supervisor.contact" disabled />
                    </x-filament::input.wrapper>
                </div>
                <div class="col-span-3">
                    <label for="">Company Address</label>
                    <x-filament::input.wrapper disabled>
                        <x-filament::input type="text" wire:model="supervisor.companyAddress" disabled />
                    </x-filament::input.wrapper>
                </div>

            </div>

        </div>
    </x-filament::modal>

    <div class="relative z-50 w-auto h-auto">
        <template x-teleport="body">
            <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen"
                x-cloak>
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false"
                    class="absolute inset-0 w-full h-full bg-black bg-opacity-40"></div>
                <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative w-full py-6 bg-white px-7 sm:max-w-lg sm:rounded-lg">
                    <div class="flex items-center justify-between pb-2">
                        <h3 class="text-lg font-semibold">Deploy Student</h3>
                        <button @click="modalOpen=false"
                            class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative w-auto">
                        <div>
                            {{ $this->form }}
                        </div>
                        <div class="mt-4">
                            <x-button label="Deploy" sm right-icon="arrow-right" wire:click="deployNow"
                                spinner="deployNow" positive />
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
