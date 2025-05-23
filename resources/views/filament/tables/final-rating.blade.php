<div class="ml-3">
    @php
        $responses = \App\Models\SupervisorSurveyResponse::where('student_id', $getRecord()->student->id)->first()
            ?->responses;

        $data = json_decode($responses, true); // decode as associative array

        $totalEarned = is_array($data)
            ? array_reduce(
                $data,
                function ($carry, $item) {
                    return $carry + ($item['earned'] ?? 0);
                },
                0,
            )
            : 0;
    @endphp

    <p> {{ $totalEarned }}</p>
</div>
