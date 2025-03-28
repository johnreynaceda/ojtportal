@section('title', 'EVALUATION - ' . strtoupper($student_name))

<div>
    <div class="mb-3">
        <x-button label="BACK" class="font-medium" icon="arrow-left" slate
            href="{{ route('coordinator.intern-evaluation') }}" />
    </div>
    <div class="flex space-x-5 font-medium text-lg">
        <div>SA - Strongly Agree</div>
        <div>A - Agree</div>
        <div>N - Neutral</div>
        <div>D - Disagree</div>
        <div>SD - Strongly Disagree</div>
    </div>
    <div class="table w-full">
        @if (!$has_rating)
            <table class="border-collapse border border-gray-400 w-full">
                <thead>
                    <tr>
                        <th class="border border-gray-300">Questions</th>
                        <th class="w-[30rem] border border-gray-300">RATING</th>
                    </tr>
                    <tr>
                        <th class="border border-gray-300"></th>
                        <th class="w-[30rem] border border-gray-300">
                            <div class="flex justify-between divide-x divide-gray-300 text-center">
                                <span class="flex-1">SA(5)</span>
                                <span class="flex-1">A(4)</span>
                                <span class="flex-1">N(3)</span>
                                <span class="flex-1">D(2)</span>
                                <span class="flex-1">SD(1)</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ORIENTATION Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 font-bold border-gray-300">ORIENTATION</td>
                    </tr>
                    @foreach ($orientationQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio"
                                                wire:model.live="responses.orientation.{{ $index }}"
                                                value="{{ $value }}" class="form-radio">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- SCHOOL SUPPORT Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 font-bold border-gray-300">SCHOOL SUPPORT</td>
                    </tr>
                    @foreach ($schoolSupportQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio"
                                                wire:model.live="responses.school_support.{{ $index }}"
                                                value="{{ $value }}" class="form-radio">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- COMPANY Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 uppercase font-bold border-gray-300">Company</td>
                    </tr>
                    @foreach ($companyQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio"
                                                wire:model.live="responses.company.{{ $index }}"
                                                value="{{ $value }}" class="form-radio">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- MONITORING Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 uppercase font-bold border-gray-300">Monitoring</td>
                    </tr>
                    @foreach ($monitoringQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio"
                                                wire:model.live="responses.monitoring.{{ $index }}"
                                                value="{{ $value }}" class="form-radio">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- IMPACT OF THE PROGRAM Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 uppercase font-bold border-gray-300">Impact of the
                            Program</td>
                    </tr>
                    @foreach ($impactQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio"
                                                wire:model.live="responses.impact.{{ $index }}"
                                                value="{{ $value }}" class="form-radio">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <table class="border-collapse border border-gray-400 w-full">
                <thead>
                    <tr>
                        <th class="border border-gray-300">Questions</th>
                        <th class="w-[30rem] border border-gray-300">RATING</th>
                    </tr>
                    <tr>
                        <th class="border border-gray-300"></th>
                        <th class="w-[30rem] border border-gray-300">
                            <div class="flex justify-between divide-x divide-gray-300 text-center">
                                <span class="flex-1">SA(5)</span>
                                <span class="flex-1">A(4)</span>
                                <span class="flex-1">N(3)</span>
                                <span class="flex-1">D(2)</span>
                                <span class="flex-1">SD(1)</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ORIENTATION Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 font-bold border-gray-300">ORIENTATION</td>
                    </tr>
                    @foreach ($orientationQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio" name="orientation_{{ $index }}"
                                                value="{{ $value }}" class="form-radio" disabled
                                                @if (isset($results['orientation'][$index]) && $results['orientation'][$index] == $value) checked @endif>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- SCHOOL SUPPORT Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 font-bold border-gray-300">SCHOOL SUPPORT</td>
                    </tr>
                    @foreach ($schoolSupportQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio" name="school_support_{{ $index }}"
                                                value="{{ $value }}" class="form-radio" disabled
                                                @if (isset($results['school_support'][$index]) && $results['school_support'][$index] == $value) checked @endif>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- COMPANY Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 uppercase font-bold border-gray-300">Company</td>
                    </tr>
                    @foreach ($companyQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio" name="company_{{ $index }}"
                                                value="{{ $value }}" class="form-radio" disabled
                                                @if (isset($results['company'][$index]) && $results['company'][$index] == $value) checked @endif>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- MONITORING Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 uppercase font-bold border-gray-300">Monitoring
                        </td>
                    </tr>
                    @foreach ($monitoringQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio" name="monitoring_{{ $index }}"
                                                value="{{ $value }}" class="form-radio" disabled
                                                @if (isset($results['monitoring'][$index]) && $results['monitoring'][$index] == $value) checked @endif>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- IMPACT OF THE PROGRAM Section -->
                    <tr>
                        <td colspan="2" class="border px-4 py-1 uppercase font-bold border-gray-300">Impact of the
                            Program</td>
                    </tr>
                    @foreach ($impactQuestions as $index => $question)
                        <tr>
                            <td class="border px-4 border-gray-300">
                                <p class="py-1">{{ $question }}</p>
                            </td>
                            <td class="border font-bold border-gray-300">
                                <div class="flex justify-between divide-x divide-gray-300 text-center">
                                    @foreach ([5, 4, 3, 2, 1] as $value)
                                        <div class="flex-1 flex justify-center">
                                            <input type="radio" name="impact_{{ $index }}"
                                                value="{{ $value }}" class="form-radio" disabled
                                                @if (isset($results['impact'][$index]) && $results['impact'][$index] == $value) checked @endif>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if (!$has_rating)
        <div class="mt-6">
            <h3 class="text-lg font-bold">Section Rates:</h3>
            <ul class="list-disc pl-5">
                @foreach ($sectionRates as $section => $rate)
                    <li class="mt-2">
                        <span class="font-medium">{{ ucfirst($section) }}:</span>
                        {{ number_format($rate, 2) }}
                    </li>
                @endforeach
            </ul>
            <h3 class="mt-4 text-lg font-bold">Overall Rate:</h3>
            <p class="text-xl font-bold">{{ number_format($overallRate, 2) }}</p>
        </div>

        <div class="mt-4">
            <button wire:click="submitEvaluation"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit Evaluation
            </button>
        </div>
    @endif
</div>
