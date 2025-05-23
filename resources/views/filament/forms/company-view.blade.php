<div>
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-bold text-gray-700">
            {{ $getRecord()->company_name }}
        </h1>
    </div>
    <div class="grid grid-cols-2 gap-10">
        <div class="border h-64">

        </div>
        <div class="border h-64">
            <img src="{{ Storage::url($getRecord()->location_path) }}" class="h-full w-full object-cover" alt="">
        </div>
    </div>
    <div class="mt-5">

        <div class="grid grid-cols-4 gap-5">
            <div class="mt-3">
                <h1 class="text-sm text-gray-600">Company Name</h1>
                <p class=" text-xl">{{ $getRecord()->company_name }}</p>
            </div>
            <div class="mt-3">
                <h1 class="text-sm text-gray-600">Address</h1>
                <p class=" text-xl">{{ $getRecord()->company_address }}</p>
            </div>
            <div class="mt-3">
                <h1 class="text-sm text-gray-600">Supervisor Name</h1>
                <p class=" text-xl">{{ $getRecord()->firstname . ' ' . $getRecord()->lastname }}</p>
            </div>
            <div class="mt-3">
                <h1 class="text-sm text-gray-600">Contact</h1>
                <p class=" text-xl">{{ $getRecord()->contact_number }}</p>
            </div>
            <div class="mt-3">
                <h1 class="text-sm text-gray-600">Email</h1>
                <p class=" text-xl">{{ $getRecord()->user->name }}</p>
            </div>
            <div class="col-span-4">
                <h1 class="font-bold">JOB REQUIREMENTS</h1>
            </div>
            @php
                $jobRequirements = json_decode($getRecord()->job_requirements, true);
            @endphp

            <div class="col-span-2">
                <h1 class="text-sm text-gray-600">Hard Skills</h1>
                <p class="text-xl">{{ implode(', ', $jobRequirements['hardskill'] ?? []) }}</p>
            </div>
            <div class="col-span-2">
                <h1 class="text-sm text-gray-600">Soft Skills</h1>
                <p class="text-xl">{{ implode(', ', $jobRequirements['softskill'] ?? []) }}</p>
            </div>
            <div class="col-span-2">
                <h1 class="text-sm text-gray-600">Work Experience</h1>
                <p class="text-xl">{{ $jobRequirements['work_experience'] ?? 'N/A' }}</p>
            </div>
            <div class="col-span-2">
                <h1 class="text-sm text-gray-600">Intership Location</h1>
                <p class="text-xl">{{ $jobRequirements['internship_location'] ?? 'N/A' }}</p>
            </div>
            <div class="col-span-2">
                <h1 class="text-sm text-gray-600">Intership Arrangement</h1>
                <p class="text-xl">{{ $jobRequirements['internship_arrangement'] ?? 'N/A' }}</p>
            </div>
            {{-- <div class="col-span-2">
                <h1 class="text-sm text-gray-600">Internship Location</h1>
                <p class="text-xl">{{ implode(', ', $jobRequirements['internship_location'] ?? []) }}</p>
            </div>
            <div class="col-span-2">
                <h1 class="text-sm text-gray-600">Internship Arrangement</h1>
                <p class="text-xl">{{ implode(', ', $jobRequirements['internship_arrangement'] ?? []) }}</p>
            </div> --}}
        </div>
    </div>
</div>
