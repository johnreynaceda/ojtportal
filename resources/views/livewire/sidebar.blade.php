<div>
    @if (auth()->user()->user_type == 'student')
        <nav class="flex-1 mt-5 space-y-1 ">
            <ul>
                <li>
                    <a class="{{ request()->routeIs('student.dashboard') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('student.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-house">
                            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                            <path
                                d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        </svg>
                        <span class="ml-4"> Home </span>
                    </a>
                </li>

            </ul>
            <p class="px-4 pt-5 text-xs font-semibold text-gray-300 uppercase">
                MANAGEMENT
            </p>
            <ul>
                <li>
                    <a class="{{ request()->routeIs('student.company') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('student.company') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-building2-icon lucide-building-2">
                            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
                            <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
                            <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
                            <path d="M10 6h4" />
                            <path d="M10 10h4" />
                            <path d="M10 14h4" />
                            <path d="M10 18h4" />
                        </svg>
                        <span class="ml-4"> Company </span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('student.requirement.edited-docs') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('student.requirement.edited-docs') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-user">
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M15 18a3 3 0 1 0-6 0" />
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z" />
                            <circle cx="12" cy="13" r="2" />
                        </svg>
                        <span class="ml-4"> Requirements </span>
                    </a>
                </li>


                {{-- <li>
                    <a class="{{ request()->routeIs('student.dtr') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('student.dtr') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-calendar-range">
                            <rect width="18" height="18" x="3" y="4" rx="2" />
                            <path d="M16 2v4" />
                            <path d="M3 10h18" />
                            <path d="M8 2v4" />
                            <path d="M17 14h-6" />e
                            <path d="M13 18H7" />
                            <path d="M7 14h.01" />
                            <path d="M17 18h.01" />
                        </svg>
                        <span class="ml-4"> DTR </span>
                    </a>
                </li> --}}
                <li>
                    <a class="{{ request()->routeIs('student.tasks') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('student.tasks') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-clipboard-list">
                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                            <path d="M12 11h4" />
                            <path d="M12 16h4" />
                            <path d="M8 11h.01" />
                            <path d="M8 16h.01" />
                        </svg>
                        <span class="ml-4">Task Record</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('student.journal') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('student.journal') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-notebook-pen">
                            <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4" />
                            <path d="M2 6h4" />
                            <path d="M2 10h4" />
                            <path d="M2 14h4" />
                            <path d="M2 18h4" />
                            <path
                                d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        </svg>
                        <span class="ml-4">Journal</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('student.evaluate') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('student.evaluate') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-thumbs-up-icon lucide-thumbs-up">
                            <path d="M7 10v12" />
                            <path
                                d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z" />
                        </svg>
                        <span class="ml-4">Evaluation</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('student.chat') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('student.chat') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-message-circle-more">
                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                            <path d="M8 12h.01" />
                            <path d="M12 12h.01" />
                            <path d="M16 12h.01" />
                        </svg>
                        <span class="ml-4">Chat</span>
                    </a>
                </li>

            </ul>

        </nav>
    @endif

    @if (auth()->user()->user_type == 'coordinator')
        <nav class="flex-1 mt-5 space-y-1 ">

            <ul>
                <li>
                    <a class="{{ request()->routeIs('coordinator.dashboard') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-house">
                            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                            <path
                                d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        </svg>
                        <span class="ml-4"> Home </span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('coordinator.class') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.class') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-backpack">
                            <path d="M4 10a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z" />
                            <path d="M8 10h8" />
                            <path d="M8 18h8" />
                            <path d="M8 22v-6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6" />
                            <path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2" />
                        </svg>
                        <span class="ml-4"> Class List </span>
                    </a>
                </li>
            </ul>
            <p class="px-4 pt-5 text-xs font-semibold text-gray-300 uppercase">
                MANAGEMENT
            </p>
            <ul>
                <li>
                    <div x-data="{ open: false }">
                        <button
                            class="inline-flex items-center justify-between w-full px-4 py-2 mt-1 text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main group"
                            @click="open = ! open">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-user">
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M15 18a3 3 0 1 0-6 0" />
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z" />
                                <circle cx="12" cy="13" r="2" />
                            </svg>
                            <span class="ml-4">Trainee Inputs</span>
                            <svg fill="currentColor" viewBox="0 0 20 20"
                                :class="{ 'rotate-180': open, 'rotate-0': !open }"
                                class="inline size-5 ml-auto transition-transform duration-200 transform group-hover:text-accent rotate-0">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="p-2 pl-6 -px-px" x-show="open" @click.outside="open = false"
                            style="display: none;">
                            <ul>
                                <li>
                                    <a href="{{ route('coordinator.requirements') }}" title="#"
                                        class="inline-flex items-center w-full p-2 pl-3 text-sm font-light text-white rounded-lg hover:text-main group hover:bg-gray-50">
                                        <span class="inline-flex items-center w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dot">
                                                <circle cx="12.1" cy="12.1" r="1" />
                                            </svg>
                                            <span class="ml-4">Requirements</span>
                                        </span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('coordinator.students-dtr') }}" title=""
                                        class="inline-flex items-center w-full p-2 pl-3 text-sm font-light text-white rounded-lg hover:text-main group hover:bg-gray-50">
                                        <span class="inline-flex items-center w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dot">
                                                <circle cx="12.1" cy="12.1" r="1" />
                                            </svg>
                                            <span class="ml-4">DTR</span>
                                        </span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('coordinator.task') }}" title="#"
                                        class="inline-flex items-center w-full p-2 pl-3 text-sm font-light text-white rounded-lg hover:text-main group hover:bg-gray-50">
                                        <span class="inline-flex items-center w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dot">
                                                <circle cx="12.1" cy="12.1" r="1" />
                                            </svg>
                                            <span class="ml-4">Task Accomplishment</span>
                                        </span>
                                    </a>
                                    <a href="{{ route('coordinator.journal') }}" title="#"
                                        class="inline-flex items-center w-full p-2 pl-3 text-sm font-light text-white rounded-lg hover:text-main group hover:bg-gray-50">
                                        <span class="inline-flex items-center w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dot">
                                                <circle cx="12.1" cy="12.1" r="1" />
                                            </svg>
                                            <span class="ml-4">Journal Report</span>
                                        </span>
                                    </a>
                                    <a href="{{ route('coordinator.evaluation-form') }}" title="#"
                                        class="inline-flex items-center w-full p-2 pl-3 text-sm font-light text-white rounded-lg hover:text-main group hover:bg-gray-50">
                                        <span class="inline-flex items-center w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dot">
                                                <circle cx="12.1" cy="12.1" r="1" />
                                            </svg>
                                            <span class="ml-4">Evaluation Form</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <div x-data="{ open: false }">
                        <button
                            class="inline-flex items-center justify-between w-full px-4 py-2 mt-1 text-white transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main group"
                            @click="open = ! open">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-spreadsheet">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M8 13h2" />
                                <path d="M14 13h2" />
                                <path d="M8 17h2" />
                                <path d="M14 17h2" />
                            </svg>
                            <span class="ml-4">Grades</span>
                            <svg fill="currentColor" viewBox="0 0 20 20"
                                :class="{ 'rotate-180': open, 'rotate-0': !open }"
                                class="inline size-5 ml-auto transition-transform duration-200 transform group-hover:text-accent rotate-0">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="p-2 pl-6 -px-px" x-show="open" @click.outside="open = false"
                            style="display: none;">
                            <ul>
                                <li>
                                    <a href="{{ route('coordinator.student-rating') }}" title="#"
                                        class="inline-flex items-center w-full p-2 pl-3 text-sm font-light  text-white rounded-lg hover:text-main group hover:bg-gray-50">
                                        <span class="inline-flex items-center w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dot">
                                                <circle cx="12.1" cy="12.1" r="1" />
                                            </svg>
                                            <span class="ml-4">My Rating</span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('coordinator.supervisor-rating') }}" title=""
                                        class="inline-flex items-center w-full p-2 pl-3 text-sm font-light text-white rounded-lg hover:text-main group hover:bg-gray-50">
                                        <span class="inline-flex items-center w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-dot">
                                                <circle cx="12.1" cy="12.1" r="1" />
                                            </svg>
                                            <span class="ml-4">Supervisor Rating</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <a class="{{ request()->routeIs('coordinator.announcement') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.announcement') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-megaphone">
                            <path d="m3 11 18-5v12L3 14v-3z" />
                            <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />
                        </svg>
                        <span class="ml-4"> Announcements </span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('coordinator.users') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.users') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg>
                        <span class="ml-4"> Users </span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('coordinator.user-log') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.user-log') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-archive">
                            <path d="M10 12v-1" />
                            <path d="M10 18v-2" />
                            <path d="M10 7V6" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M15.5 22H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v16a2 2 0 0 0 .274 1.01" />
                            <circle cx="10" cy="20" r="2" />
                        </svg>
                        <span class="ml-4"> User Logs </span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('coordinator.intern-evaluation') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.intern-evaluation') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-user">
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M15 18a3 3 0 1 0-6 0" />
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z" />
                            <circle cx="12" cy="13" r="2" />
                        </svg>
                        <span class="ml-4">Intern Evaluation</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('coordinator.partner') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.partner') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-building-2">
                            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
                            <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
                            <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
                            <path d="M10 6h4" />
                            <path d="M10 10h4" />
                            <path d="M10 14h4" />
                            <path d="M10 18h4" />
                        </svg>
                        <span class="ml-4">Partners</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('coordinator.moa') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.moa') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-handshake-icon lucide-handshake">
                            <path d="m11 17 2 2a1 1 0 1 0 3-3" />
                            <path
                                d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4" />
                            <path d="m21 3 1 11h-2" />
                            <path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3" />
                            <path d="M3 4h8" />
                        </svg>
                        <span class="ml-4">MOA</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->routeIs('coordinator.chat') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('coordinator.chat') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-message-circle-more">
                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                            <path d="M8 12h.01" />
                            <path d="M12 12h.01" />
                            <path d="M16 12h.01" />
                        </svg>
                        <span class="ml-4">Chat</span>
                    </a>
                </li>

            </ul>

        </nav>
    @endif


    @if (auth()->user()->user_type == 'supervisor')
        <nav class="flex-1 mt-5 space-y-1 ">

            <ul>
                <li>
                    <a class="{{ request()->routeIs('supervisor.dashboard') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-house">
                            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                            <path
                                d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        </svg>
                        <span class="ml-4"> Home </span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('supervisor.trainee') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.trainee') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg>
                        <span class="ml-4"> Trainees </span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('supervisor.application') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.application') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg>
                        <span class="ml-4"> Applicants </span>
                    </a>
                </li>
            </ul>
            <p class="px-4 pt-5 text-xs font-semibold text-gray-300 uppercase">
                MANAGEMENT
            </p>
            <ul>
                <li>
                    <a class="{{ request()->routeIs('supervisor.journal') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.journal') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-notebook-tabs-icon lucide-notebook-tabs">
                            <path d="M2 6h4" />
                            <path d="M2 10h4" />
                            <path d="M2 14h4" />
                            <path d="M2 18h4" />
                            <rect width="16" height="20" x="4" y="2" rx="2" />
                            <path d="M15 2v20" />
                            <path d="M15 7h5" />
                            <path d="M15 12h5" />
                            <path d="M15 17h5" />
                        </svg>
                        <span class="ml-4"> Daily Journal </span>
                    </a>
                </li>
                {{-- <li>
                    <a class="{{ request()->routeIs('supervisor.attendance') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.attendance') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-spreadsheet">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M8 13h2" />
                            <path d="M14 13h2" />
                            <path d="M8 17h2" />
                            <path d="M14 17h2" />
                        </svg>
                        <span class="ml-4"> Attendances </span>
                    </a>
                </li> --}}
                <li>
                    <a class="{{ request()->routeIs('supervisor.tasks') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.tasks') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-archive">
                            <path d="M10 12v-1" />
                            <path d="M10 18v-2" />
                            <path d="M10 7V6" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M15.5 22H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v16a2 2 0 0 0 .274 1.01" />
                            <circle cx="10" cy="20" r="2" />
                        </svg>
                        <span class="ml-4"> Tasks </span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('supervisor.ratings') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.ratings') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-building-2">
                            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
                            <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
                            <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
                            <path d="M10 6h4" />
                            <path d="M10 10h4" />
                            <path d="M10 14h4" />
                            <path d="M10 18h4" />
                        </svg>
                        <span class="ml-4">Ratings</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('supervisor.moa') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.moa') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-handshake-icon lucide-handshake">
                            <path d="m11 17 2 2a1 1 0 1 0 3-3" />
                            <path
                                d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4" />
                            <path d="m21 3 1 11h-2" />
                            <path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3" />
                            <path d="M3 4h8" />
                        </svg>
                        <span class="ml-4">MOA</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('supervisor.chat') ? 'bg-white text-main scale-95' : 'text-white' }} inline-flex items-center w-full px-4 py-2 mt-1   transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-main"
                        href="{{ route('supervisor.chat') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-message-circle-more">
                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                            <path d="M8 12h.01" />
                            <path d="M12 12h.01" />
                            <path d="M16 12h.01" />
                        </svg>
                        <span class="ml-4">Chat</span>
                    </a>
                </li>

            </ul>

        </nav>
    @endif
</div>
