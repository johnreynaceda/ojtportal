<div class="ml-3">
    @php
        // Initialize variables with null checks
        $student = auth()->user()->student ?? null;
        $responses = $student ? \App\Models\RecommendationResponse::where('student_id', $student->id)->first() : null;
        $resume = \App\Models\Resume::where('user_id', auth()->id())->first();

        $percentage = 0;

        if ($responses && $resume && $getRecord()) {
            try {
                // Decode job requirements with error handling
                $data = json_decode($getRecord()->job_requirements);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Invalid job requirements JSON');
                }

                $matchCount = 0;
                $total = 3; // Total criteria to match

                // 1. Work Experience (int comparison)

                // 1. Work Experience (boolean check)
                if (isset($data->work_experience) && isset($responses->work_experience)) {
                    $inputWorkExp = strtolower($data->work_experience) === 'yes' ? 1 : 0;
                    if ((int) $responses->work_experience === $inputWorkExp) {
                        $matchCount++;
                    }
                }

                // 2. Internship Location (string)
                if (isset($data->internship_location) && isset($responses->internship_location)) {
                    if (strtolower($data->internship_location) === strtolower($responses->internship_location)) {
                        $matchCount++;
                    }
                }

                // 3. Internship Arrangement (string)
                if (isset($data->internship_arrangement) && isset($responses->internship_arrangement)) {
                    if (strtolower($data->internship_arrangement) === strtolower($responses->internship_arrangement)) {
                        $matchCount++;
                    }
                }

                $resumehardskills = json_decode($resume->hard_skill, true) ?? [];
                $allresumehardskills = $resumehardskills;
                $alljobhardskills = $data->hardskill ?? [];
                if (!empty($alljobhardskills)) {
                    // Get the intersected skills
                    $matched = array_intersect($allresumehardskills, $alljobhardskills);
                    // If there are any matches, add the count of matches to matchCount
                    $matchCount += count($matched); // Add the number of matched skills
                }

                // 5. Soft Skills (array comparison)
                $resumesoftskills = json_decode($resume->soft_skill, true) ?? [];
                $allresumesoftskills = $resumesoftskills;
                $alljobsoftskills = array_map('strtolower', $data->softskill ?? []);
                if (!empty($alljobsoftskills)) {
                    // Get the intersected soft skills
                    $matchedSoft = array_intersect($allresumesoftskills, $alljobsoftskills);
                    // If there are any matches, add the count of matches to matchCount
                    $matchCount += count($matchedSoft); // Add the number of matched skills
                }

                $totalhardskill = count($alljobhardskills);
                $totalsoftskill = count($alljobsoftskills);

                $percentage = round(($matchCount / ($totalsoftskill + $totalhardskill + $total)) * 100);
            } catch (Exception $e) {
                $percentage = 0;
            }
        }
    @endphp
    {{ $percentage }}%
</div>
