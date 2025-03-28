<div>
    <div class="grid grid-cols-6 gap-5">
        <div class="col-span-4">
            <div class="grid grid-cols-2 gap-5">
                <div class="bg-white rounded-2xl p-5 grid grid-cols-3">
                    <div class="grid place-content-center">
                        <x-shared.trainee class="h-16" />
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <h1 class="text-xl">Trainee</h1>
                        <h1 class="text-4xl font-bold">{{ $trainee }}</h1>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 grid grid-cols-3">
                    <div class="grid place-content-center">
                        <x-shared.deployed class="h-16" />
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <h1 class="text-xl">Deployed</h1>
                        <h1 class="text-4xl font-bold">{{ $trainee }}</h1>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 grid grid-cols-3">
                    <div class="grid place-content-center">
                        <x-shared.completed class="h-16" />
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <h1 class="text-xl">Completed</h1>
                        <h1 class="text-4xl font-bold">{{ $completed }}</h1>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 grid grid-cols-3">
                    <div class="grid place-content-center">
                        <x-shared.dropped class="h-16" />
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <h1 class="text-xl">Dropped </h1>
                        <h1 class="text-4xl font-bold">{{ $dropped }}</h1>
                    </div>
                </div>

            </div>
        </div>
        <div class=" col-span-2 ">
            <div class=" bg-white rounded-2xl">
                <div class="border-b flex space-x-2 items-center p-2 px-4">
                    <h1 class="font-semibold text-gray-600">Announcement Board</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-megaphone text-main">
                        <path d="m3 11 18-5v12L3 14v-3z" />
                        <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />
                    </svg>
                </div>
                <div class="p-4 h-56 overflow-y-auto">
                    <ul class="space-y-2">
                        @forelse ($announcements as $item)
                            <li class="bg-gray-50  p-2">
                                <p class="text-xs text-justify text-gray-700">
                                    {{ $item->message }}</p>
                                <div class="flex mt-1 justify-end text-sm font-semibold space-x-1 items-center">
                                    <span>by:</span>
                                    <span>Coordinator</span>
                                </div>
                            </li>
                        @empty
                            <li>
                                <p class="text-center text-gray-600">No announcements found.</p>
                            </li>
                        @endforelse

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10">
        <div class="bg-white p-5 rounded-xl">
            <h1 class="mb-5 font-bold text-main uppercase">Top Performing Students</h1>
            <div class="max-h-96 overflow-y-auto">
                <div class="flex flex-col">
                    <div class=" overflow-x-auto">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden border rounded-lg border-gray-300">
                                <table class="min-w-full rounded-xl">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th
                                                class="p-2 w-10 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                                Rank</th>
                                            <th
                                                class="p-2 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                                Name</th>
                                            <th
                                                class="p-2 w-40 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                                Task Rating (20%)</th>
                                            <th
                                                class="p-2 w-20 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                                Attendance Rate (10%)</th>
                                            <th
                                                class="p-2 w-40 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                                Journal Rate (10%)</th>
                                            <th
                                                class="p-2 w-20 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                                Coordinator Rate (30%)</th>
                                            <th
                                                class="p-2 w-20 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                                Supervisor Rate (30%)</th>
                                            <th
                                                class="p-2 w-20 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                                Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300">
                                        @foreach ($performings as $student)
                                            <tr>
                                                <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                    {{ $student['rank'] }}</td>
                                                <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                    {{ $student['name'] }}</td>
                                                <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                    {{ $student['task_rating'] }}</td>
                                                <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                    {{ $student['attendance_rate'] }}</td>
                                                <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                    {{ $student['journal_rate'] }}</td>
                                                <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                    {{ $student['coordinator_rating'] }}</td>
                                                <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                    {{ $student['supervisor_rating'] }}</td>
                                                <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                    {{ $student['total'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10">
        <livewire:coordinator.risk-student />
    </div>
    <div class="grid mt-10 grid-cols-2 gap-5">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="bg-white h-96 rounded-2xl">
            <div class="h-full p-5">
                <h1 class="mb-5 font-bold text-main uppercase">Task Rating</h1>
                <canvas id="lineChart" class="h-full"></canvas>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const chartData = @json($taskData);
                    const ctx = document.getElementById("lineChart").getContext("2d");

                    const labels = chartData.map(data => data.week);
                    const avgRatings = chartData.map(data => data.avg_rating);

                    new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Average Rating",
                                data: avgRatings,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                tension: 0.4 // For a smooth curve
                            }, ],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: "top",
                                },
                                tooltip: {
                                    enabled: true,
                                },
                            },
                            scales: {
                                x: {
                                    beginAtZero: true
                                },
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: 5
                                }, // Assuming ratings are out of 5
                            },
                        },
                    });
                });
            </script>
        </div>


        <div class="bg-white h-96 rounded-2xl">
            <div class="h-full p-5">
                <h1 class="mb-5 font-bold text-main uppercase">Task Accomplishment</h1>
                <canvas id="barChart"></canvas>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const chartData = @json($chartData);
                    const ctx = document.getElementById("barChart").getContext("2d");

                    const labels = chartData.map(data => data.week);
                    const completedData = chartData.map(data => data.completed);
                    const delayedData = chartData.map(data => data.delayed);

                    new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: "Completed",
                                    data: completedData,
                                    backgroundColor: "rgba(54, 162, 235, 0.6)",
                                    borderColor: "rgba(54, 162, 235, 1)",
                                    borderWidth: 1,
                                },
                                {
                                    label: "Delayed",
                                    data: delayedData,
                                    backgroundColor: "rgba(255, 99, 132, 0.6)",
                                    borderColor: "rgba(255, 99, 132, 1)",
                                    borderWidth: 1,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: "top",
                                },
                                tooltip: {
                                    enabled: true,
                                },
                            },
                            scales: {
                                x: {
                                    beginAtZero: true
                                },
                                y: {
                                    beginAtZero: true
                                },
                            },
                        },
                    });
                });
            </script>
        </div>


    </div>

</div>
