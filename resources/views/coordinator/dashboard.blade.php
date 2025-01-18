<x-coordinator-layout>
    <div class="grid grid-cols-3 gap-10">
        <div class="col-span-2">
            <div class="grid grid-cols-2 gap-5">
                <div class="bg-white rounded-2xl p-5 grid grid-cols-3">
                    <div class="grid place-content-center">
                        <x-shared.trainee class="h-16" />
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <h1 class="text-xl">Trainee</h1>
                        <h1 class="text-4xl font-bold">50</h1>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 grid grid-cols-3">
                    <div class="grid place-content-center">
                        <x-shared.deployed class="h-16" />
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <h1 class="text-xl">Deployed</h1>
                        <h1 class="text-4xl font-bold">48</h1>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 grid grid-cols-3">
                    <div class="grid place-content-center">
                        <x-shared.completed class="h-16" />
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <h1 class="text-xl">Completed</h1>
                        <h1 class="text-4xl font-bold">5</h1>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 grid grid-cols-3">
                    <div class="grid place-content-center">
                        <x-shared.dropped class="h-16" />
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <h1 class="text-xl">Dropped </h1>
                        <h1 class="text-4xl font-bold">23</h1>
                    </div>
                </div>

            </div>
        </div>
        <div class="bg-white rounded-2xl grid place-content-center">
            <span>Content here...</span>
        </div>
    </div>
    <div class="grid mt-10 grid-cols-2 gap-10">

        <div class="bg-white h-96 rounded-2xl grid place-content-center">
            <span>Content here...</span>
        </div>
        <div class="bg-white h-96 rounded-2xl grid place-content-center">
            <span>Content here...</span>
        </div>
    </div>
</x-coordinator-layout>
