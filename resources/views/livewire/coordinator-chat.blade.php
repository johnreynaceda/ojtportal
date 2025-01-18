<div>
    <div class="grid grid-cols-7  bg-white divide-x-2">
        <div class=" col-span-2" x-data="{ open: false }">
            <div x-show="!open" class="px-3 py-5">
                <div @click="open = true"
                    class="border h-12 px-4 flex space-x-1   items-center py-1 rounded-full  relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>

                    <span class="text-sm">Search Chat</span>
                </div>
                <ul class="mt-2">
                    @forelse ($chats as $item)
                        @php
                            $userIDS = json_decode($item->user_ids, true);
                            $user = collect($userIDS)->first(fn($id) => $id != auth()->user()->id);
                            $data = \App\Models\User::where('id', $user)->first();
                            $lastMessage = \App\Models\Message::where('chat_id', $item->id)
                                ->orderBy('id', 'desc')
                                ->first();
                        @endphp
                        @if ($lastMessage)
                            <li wire:click="chat({{ $item->id }})"
                                class="{{ $lastMessage->sender_id != auth()->user()->id ? 'bg-red-50' : '' }} flex space-x-3 items-center w-full py-2 px-2 hover:bg-gray-100 cursor-pointer rounded-lg">
                                <img src="{{ asset('images/ccs_logo.jpg') }}" class="h-12 w-12 rounded-full"
                                    alt="">
                                <div class="flex-1">
                                    <h3 class="text-gray-900  font-semibold leading-snug">

                                        {{ $data->name }}
                                    </h3>
                                    <div class="flex justify-between items-center">
                                        <p class="text-xs">
                                            {{ \App\Models\User::where('id', $lastMessage->sender_id)->first()->name }}:
                                            @if ($lastMessage->image != null)
                                                <span>Image</span>
                                            @else
                                                {{ $lastMessage->message }}
                                            @endif
                                        </p>
                                        <span
                                            class="text-xs">{{ \Carbon\Carbon::parse($lastMessage->created_at)->diffForHumans(now(), \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW, true) }}</span>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li wire:click="chat({{ $item->id }})"
                                class=" flex space-x-3 items-center w-full py-2 px-2 hover:bg-gray-100 cursor-pointer rounded-lg">
                                <img src="{{ asset('images/ccs_logo.jpg') }}" class="h-12 w-12 rounded-full"
                                    alt="">
                                <div class="flex-1">
                                    <h3 class="text-gray-900  font-semibold leading-snug">

                                        {{ $data->name }}
                                    </h3>
                                    <div class="flex justify-between items-center">
                                        <p class="text-xs">

                                        </p>
                                        <span class="text-xs"></span>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @empty
                        <div class="flex justify-center mt-5 items-center text-gray-600 text-sm">
                            <span>
                                No Chat Available...
                            </span>
                        </div>
                    @endforelse

                </ul>
            </div>
            <div x-show="open">
                <div class="px-3 py-5 flex ">
                    <button @click="open = false"
                        class="h-12 w-12 grid hover:border hover:text-red-600 place-content-center px-2  space-x-1   items-center py-1 rounded-full  relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-circle-arrow-left">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M16 12H8" />
                            <path d="m12 8-4 4 4 4" />
                        </svg>

                    </button>
                    <div class="border h-12 px-4 flex space-x-1   items-center py-1 rounded-full  relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-search">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="text" wire:model.live="search" placeholder="Search...." name=""
                            id="" class="h-full w-full border-0 ring-0 focus:ring-0 text-sm text-gray-600">
                    </div>
                </div>
                <ul class="mt-2 px-5 text-white">
                    @foreach ($users as $item)
                        <li @click="open = false" wire:click="chatUser({{ $item->id }})"
                            class="flex space-x-3 items-center relative w-full py-2 px-2 hover:bg-gray-100 cursor-pointer rounded-lg">
                            <img src="{{ asset('images/ccs_logo.jpg') }}" class="h-12 w-12 rounded-full"
                                alt="">
                            <div class="flex-1 overflow-hidden">
                                <p class="text-gray-900 truncate font-semibold">
                                    {{ $item->name }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class=" col-span-5">
            @if ($chat_data)
                <div class="">
                    <div class="flex justify-between items-center border-b-2">
                        <div class="flex space-x-2 px-5 items-center py-3 ">
                            <img src="{{ asset('images/ccs_logo.jpg') }}" class="h-12 w-12" alt="">
                            <div>
                                <h3 class="text-gray-900  font-semibold leading-snug">{{ $user_data->name }}</h3>
                                <div class="flex  text-xs items-center text-gray-500">
                                    <div class="relative">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="text-green-600 animate-ping w-3 h-3" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z">
                                            </path>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="text-green-600 absolute top-0 w-3 h-3" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span>Online</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-5">
                            <x-dropdown>
                                <x-dropdown.header label="Action">
                                    <x-dropdown.item label="Delete Chat" />
                                </x-dropdown.header>
                            </x-dropdown>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="w-full relative bg-white rounded-xl ">

                            <div class="h-[34rem] mb-5 overflow-y-auto flex flex-col-reverse" id="chat-container"
                                x-data x-init="$nextTick(() => $el.scrollTop = $el.scrollHeight)">
                                <!-- Chat Messages -->
                                <div>
                                    <!-- Example Message 1 -->
                                    @if ($chat_id)
                                        @forelse ($chat_data->messages as $message)
                                            @if ($message->sender_id == auth()->user()->id)
                                                <div class="flex gap-2.5 mb-4 justify-end">
                                                    <div class="grid w-fit ml-auto">
                                                        <h5
                                                            class="text-right text-gray-900 text-sm font-semibold leading-snug pb-1">
                                                            You</h5>
                                                        <div class="px-3 py-2 bg-indigo-600 rounded">
                                                            @if ($message->message)
                                                                <p class="text-white text-sm font-normal leading-snug">
                                                                    {{ $message->message }}
                                                                @else
                                                                    <a href="{{ Storage::url($message->image) }}"
                                                                        target="_blank">
                                                                        <img src="{{ Storage::url($message->image) }}"
                                                                            class="w-40 h-40" alt="">
                                                                    </a>
                                                            @endif
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="text-gray-500 text-xs font-normal leading-4 py-1 text-right">
                                                            {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                    <img src="{{ asset('images/feiryfox.png') }}" alt="Hailey image"
                                                        class="w-10 h-11">
                                                </div>
                                            @else
                                                <div class="flex gap-2.5 mb-4">
                                                    <img src="{{ asset('images/ccs_logo.jpg') }}" alt="Shanay image"
                                                        class="w-10 h-11">
                                                    <div class="grid">
                                                        <h5
                                                            class="text-gray-900 text-sm font-semibold leading-snug pb-1">
                                                            @php
                                                                $name = '';
                                                                if ($message->receiver_id == auth()->user()->id) {
                                                                    $name = \App\Models\User::where(
                                                                        'id',
                                                                        $message->sender_id,
                                                                    )->first()->name;
                                                                }
                                                            @endphp
                                                            {{ $name }}
                                                        </h5>
                                                        <div class="px-3.5 py-2 bg-gray-100 w-auto rounded">
                                                            @if ($message->message)
                                                                <p
                                                                    class="text-gray-900 text-sm font-normal leading-snug">
                                                                    {{ $message->message }}
                                                                @else
                                                                    <a href="{{ Storage::url($message->image) }}"
                                                                        target="_blank">
                                                                        <img src="{{ Storage::url($message->image) }}"
                                                                            class="w-40 h-40" alt="">
                                                                    </a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="text-gray-500 text-xs font-normal leading-4">
                                                            {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif



                                        @empty
                                            <div class="w-full h-96 text-gray-500 text-center">
                                                send message to start chatting.
                                            </div>
                                        @endforelse
                                    @else
                                        <div class="w-full h-96 text-gray-500 text-center">
                                            send message to start chatting.
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div
                                class="w-full pl-3 pr-1 py-1 rounded-3xl border h-14  border-gray-200 items-center gap-2 inline-flex justify-between">
                                <div class="flex flex-1 items-center gap-2 h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 22 22" fill="none">
                                        <g id="User Circle">
                                            <path id="icon"
                                                d="M6.05 17.6C6.05 15.3218 8.26619 13.475 11 13.475C13.7338 13.475 15.95 15.3218 15.95 17.6M13.475 8.525C13.475 9.89191 12.3669 11 11 11C9.6331 11 8.525 9.89191 8.525 8.525C8.525 7.1581 9.6331 6.05 11 6.05C12.3669 6.05 13.475 7.1581 13.475 8.525ZM19.25 11C19.25 15.5563 15.5563 19.25 11 19.25C6.44365 19.25 2.75 15.5563 2.75 11C2.75 6.44365 6.44365 2.75 11 2.75C15.5563 2.75 19.25 6.44365 19.25 11Z"
                                                stroke="#4F46E5" stroke-width="1.6" />
                                        </g>
                                    </svg>
                                    <input
                                        class="grow shrink basis-0 text-black w-full focus:ring-0 border-0 text-sm  leading-4 focus:outline-none"
                                        placeholder="Type here..." wire:model="message">
                                </div>
                                <div class="flex items-center gap-2">
                                    <button wire:click="fileUpload">
                                        <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="22"
                                            height="22" viewBox="0 0 22 22" fill="none">
                                            <g id="Attach 01">
                                                <g id="Vector">
                                                    <path
                                                        d="M14.9332 7.79175L8.77551 14.323C8.23854 14.8925 7.36794 14.8926 6.83097 14.323C6.294 13.7535 6.294 12.83 6.83097 12.2605L12.9887 5.72925M12.3423 6.41676L13.6387 5.04176C14.7126 3.90267 16.4538 3.90267 17.5277 5.04176C18.6017 6.18085 18.6017 8.02767 17.5277 9.16676L16.2314 10.5418M16.8778 9.85425L10.72 16.3855C9.10912 18.0941 6.49732 18.0941 4.88641 16.3855C3.27549 14.6769 3.27549 11.9066 4.88641 10.198L11.0441 3.66675"
                                                        stroke="#9CA3AF" stroke-width="1.6" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M14.9332 7.79175L8.77551 14.323C8.23854 14.8925 7.36794 14.8926 6.83097 14.323C6.294 13.7535 6.294 12.83 6.83097 12.2605L12.9887 5.72925M12.3423 6.41676L13.6387 5.04176C14.7126 3.90267 16.4538 3.90267 17.5277 5.04176C18.6017 6.18085 18.6017 8.02767 17.5277 9.16676L16.2314 10.5418M16.8778 9.85425L10.72 16.3855C9.10912 18.0941 6.49732 18.0941 4.88641 16.3855C3.27549 14.6769 3.27549 11.9066 4.88641 10.198L11.0441 3.66675"
                                                        stroke="black" stroke-opacity="0.2" stroke-width="1.6"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M14.9332 7.79175L8.77551 14.323C8.23854 14.8925 7.36794 14.8926 6.83097 14.323C6.294 13.7535 6.294 12.83 6.83097 12.2605L12.9887 5.72925M12.3423 6.41676L13.6387 5.04176C14.7126 3.90267 16.4538 3.90267 17.5277 5.04176C18.6017 6.18085 18.6017 8.02767 17.5277 9.16676L16.2314 10.5418M16.8778 9.85425L10.72 16.3855C9.10912 18.0941 6.49732 18.0941 4.88641 16.3855C3.27549 14.6769 3.27549 11.9066 4.88641 10.198L11.0441 3.66675"
                                                        stroke="black" stroke-opacity="0.2" stroke-width="1.6"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </g>
                                            </g>
                                        </svg>
                                    </button>
                                    <button wire:click="sendChat"
                                        class="items-center flex px-3 py-2 h-full bg-indigo-600 rounded-full shadow ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 16 16" fill="none">
                                            <g id="Send 01">
                                                <path id="icon"
                                                    d="M9.04071 6.959L6.54227 9.45744M6.89902 10.0724L7.03391 10.3054C8.31034 12.5102 8.94855 13.6125 9.80584 13.5252C10.6631 13.4379 11.0659 12.2295 11.8715 9.81261L13.0272 6.34566C13.7631 4.13794 14.1311 3.03408 13.5484 2.45139C12.9657 1.8687 11.8618 2.23666 9.65409 2.97257L6.18714 4.12822C3.77029 4.93383 2.56187 5.33664 2.47454 6.19392C2.38721 7.0512 3.48957 7.68941 5.69431 8.96584L5.92731 9.10074C6.23326 9.27786 6.38623 9.36643 6.50978 9.48998C6.63333 9.61352 6.72189 9.7665 6.89902 10.0724Z"
                                                    stroke="white" stroke-width="1.6" stroke-linecap="round" />
                                            </g>
                                        </svg>
                                        <h3 class="text-white text-xs font-semibold leading-4 px-2">Send</h3>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="h-96 grid place-content-center">
                    <span>Please select any Chat .</span>
                </div>
            @endif

        </div>
    </div>
    <x-modal name="simpleModal" wire:model.defer="upload_modal" align="center">
        <x-card title="Upload Image">
            <div class="w-96">
                {{ $this->form }}
            </div>

            <x-slot name="footer" class="flex justify-end gap-x-2">
                <x-button flat label="Cancel" x-on:click="close" />

                <x-button slate label="Upload & Send" wire:click="sendChat" spinner="sendChat" />
            </x-slot>
        </x-card>
    </x-modal>
</div>
