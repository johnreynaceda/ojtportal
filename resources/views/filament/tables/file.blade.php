<div class="ml-3">
    @if ($getRecord()->file_path == null)
        <a href="{{ route('student.requirement.upload', ['id' => $getRecord()->id]) }}"
            class="flex space-x-2 items-center border-2 rounded-lg px-2 border-gray-400 text-gray-600 hover:text-red-600 hover:border-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-file-up">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M12 12v6" />
                <path d="m15 15-3-3-3 3" />
            </svg>
            <span>Upload File here</span>
        </a>
    @else
        <a href="{{ Storage::url($getRecord()->file_path) }}" target="_blank"
            class="flex space-x-2 items-center border-2 rounded-lg px-2 border-green-400 text-green-600 "
            href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-folder-open-dot">
                <path
                    d="m6 14 1.45-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.55 6a2 2 0 0 1-1.94 1.5H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 0 1 1.66.9l.82 1.2a2 2 0 0 0 1.66.9H18a2 2 0 0 1 2 2v2" />
                <circle cx="14" cy="15" r="1" />
            </svg>
            <span>View File</span>
        </a>
    @endif

</div>
