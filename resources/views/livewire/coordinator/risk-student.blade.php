<div>
    <div class="bg-white p-5 rounded-xl">
        <h1 class="mb-5 font-bold text-main uppercase">At Risks Students</h1>
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
                                        <th class="p-2 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
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
                                            Risk Rating</th>
                                        <th
                                            class="p-2 w-28 text-left text-sm font-semibold text-gray-900 px-4 uppercase">
                                            Risk Level</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300">
                                    <tr>
                                        @foreach ($risks as $student)
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
                                                {{ $student['total'] }}
                                            </td>
                                            <td class="p-2 px-4 text-sm font-medium text-gray-900">
                                                @switch($student['category'])
                                                    @case('medium')
                                                        <x-badge label="Medium" warning />
                                                    @break

                                                    @case('high')
                                                        <x-badge label="High" negative />
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
