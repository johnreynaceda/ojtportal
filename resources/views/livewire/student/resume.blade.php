<div x-data>
    @if (auth()->user()->resume == null)
        <div>
            {{ $this->form }}
        </div>
        <div class="mt-5 flex space-x-3 items-center">
            <x-button label="Submit Record" negative squared wire:click="submitRecord" spinner="submitRecord" />
            <x-button label="Close" href="{{ route('student.dashboard') }}" slate squared />
        </div>
    @else
        <div class="flex justify-end">
            <x-button label="PRINT" right-icon="printer" class="font-semibold" slate
                @click="printOut($refs.printContainer.outerHTML);" />
        </div>
        <div class="mt-5" x-ref="printContainer">
            <div class="h-64 flex relative space-x-20 items-center justify-center w-full bg-main">
                <div class="  border h-56 w-56 absolute left-10 top-[3rem] bg-gray-400 ">
                    <img src="{{ Storage::url(auth()->user()->resume->photo) }}" class="h-full w-full object-cover"
                        alt="">
                </div>
                <div class="w-40">

                </div>
                <div>
                    <p class="text-2xl uppercase text-yellow-400 font-bold">
                        {{ auth()->user()->name }}
                    </p>
                    <h1 class=" text-xl uppercase mt-3 text-yellow-400 ">
                        {{ auth()->user()->student->major }} Student
                    </h1>
                </div>
            </div>
            <div class="mt-20 grid grid-cols-2 px-10 gap-5">
                <div class=" flex flex-col space-y-10">
                    <div>
                        <h1 class="text-3xl font-bold text-yellow-600">My Contact</h1>
                        <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                        <ul class="mt-5 space-y-2">
                            @php
                                $contact = json_decode(auth()->user()->resume->contact, true);

                            @endphp
                            <li class="flex space-x-2 item-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                </svg>
                                <span>{{ $contact['email'] }}</span>
                            </li>
                            <li class="flex space-x-2 item-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                                <span>{{ $contact['phone'] }}</span>
                            </li>
                            <li class="flex space-x-2 item-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-house">
                                    <path
                                        d="M15 22a1 1 0 0 1-1-1v-4a1 1 0 0 1 .445-.832l3-2a1 1 0 0 1 1.11 0l3 2A1 1 0 0 1 22 17v4a1 1 0 0 1-1 1z" />
                                    <path
                                        d="M18 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 .601.2" />
                                    <path d="M18 22v-3" />
                                    <circle cx="10" cy="10" r="3" />
                                </svg>
                                <span>{{ $contact['address'] }}</span>
                            </li>
                            <li class="flex space-x-2 item-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                                    <path d="M2 12h20" />
                                </svg>
                                <span>{{ $contact['social'] }}</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-yellow-600">Hard Skill</h1>
                        <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                        <ul class="mt-5 space-y-2">
                            @php
                                $skill = json_decode(auth()->user()->resume->hard_skill, true);
                            @endphp
                            @foreach ($skill as $item)
                                <li class="flex space-x-2 item-center">
                                    {{ $item['skill'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-yellow-600">Soft Skill</h1>
                        <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                        <ul class="mt-5 space-y-2">
                            @php
                                $skill = json_decode(auth()->user()->resume->soft_skill, true);
                            @endphp
                            @foreach ($skill as $item)
                                <li class="flex space-x-2 item-center">
                                    {{ $item['skill'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-yellow-600">Education Background</h1>
                        <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                        <ul class="mt-5 space-y-2">
                            @php
                                $skill = json_decode(auth()->user()->resume->education_background, true);
                            @endphp
                            @foreach ($skill as $item)
                                <li class="">
                                    <p class="font-semibold">{{ $item['school_name'] }}</p>
                                    <p>{{ $item['degree'] }}</p>
                                    <p>{{ $item['year'] }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div>
                    <div class="flex flex-col space-y-10">
                        <div>
                            <h1 class="text-3xl font-bold text-yellow-600">Career Objectives</h1>
                            <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                            <ul class="mt-5 space-y-2">
                                @php
                                    $skill = auth()->user()->resume->career_objective;
                                @endphp
                                <p>{{ $skill }}</p>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-yellow-600">WORK EXPERIENCE</h1>
                            <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                            <ul class="mt-5 space-y-2">
                                @php
                                    $skill = json_decode(auth()->user()->resume->work_experience, true);
                                @endphp
                                @foreach ($skill as $item)
                                    <li class="">
                                        <p class="font-semibold">{{ $item['name'] }}</p>
                                        <p>{{ $item['type_of_work'] }}</p>
                                        <p>{{ \Carbon\Carbon::parse($item['date_from'])->format('F Y') }} -
                                            {{ $item['present'] ? 'Present' : \Carbon\Carbon::parse($item['date_to'])->format('F Y') }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-yellow-600">Awards</h1>
                            <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                            <ul class="mt-5 space-y-2">
                                @php
                                    $skill = json_decode(auth()->user()->resume->award, true);
                                @endphp
                                @foreach ($skill as $item)
                                    <li class="flex space-x-2 item-center">
                                        {{ $item['award'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-yellow-600">Certifications</h1>
                            <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                            <ul class="mt-5 space-y-2">
                                @php
                                    $skill = json_decode(auth()->user()->resume->certification, true);
                                @endphp
                                @foreach ($skill as $item)
                                    <li class="flex space-x-2 item-center">
                                        {{ $item['certificate'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10 px-10">
                <div>
                    <h1 class="text-3xl font-bold text-yellow-600">Character References</h1>
                    <div class="mt-2 h-1 w-40 bg-yellow-800"></div>
                    <ul class="mt-5 grid grid-cols-4 gap-5">
                        @php
                            $skill = json_decode(auth()->user()->resume->character_reference, true);
                        @endphp
                        @foreach ($skill as $item)
                            <li class="">
                                <p class="font-semibold">{{ $item['name'] }}</p>
                                <p>{{ $item['relation'] }}</p>
                                <p>{{ $item['number'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
