<?php

namespace App\Livewire\Coordinator;

use App\Models\CoordinatorRating;
use App\Models\Student;
use Livewire\Component;

class StudentEvaluation extends Component
{
    public $student_id;
    public $student_name;
    public $has_rating;

    public $results = [];

    public $responses = [
        'orientation' => [],
        'school_support' => [],
        'company' => [],
        'monitoring' => [],
        'impact' => [],
    ];

    public $orientationQuestions = [
        'Adequate and proper orientation was given before the OJT course',
        'I understood the importance of the OJT course',
        'My previous subjects helped me prepare for the OJT program',
    ];

    public $schoolSupportQuestions = [
        'The school provided adequate assistance in searching for the right company',
        'The school provided adequate assistance in processing the requirements of the company',
        'The school compiles a list of reliable partner companies for the OJT',
        'There is coordination between the school and the OJT company',
    ];

    public $companyQuestions = [
        'The company where I landed was suited to the objectives of the OJT program',
        'The company has programs and efforts to expose students to training and other development activities',
        'The staff of the company is accommodating to student practicumers',
    ];

    public $monitoringQuestions = [
        'The school monitors my progress and accomplishments in the company',
        'The company assigned an immediate supervisor to mentor and guide me',
        'My immediate supervisor regularly assesses my working performance evaluation',
        'My immediate supervisor takes time to discuss the results of performance evaluation',
        'My immediate supervisor provides advices to improve my working performance',
    ];

    public $impactQuestions = [
        'I learned a lot of things during the entire phase of my OJT',
        'The OJT exposure improved my professional skills',
        'The OJT program complemented what I learned from the classroom',
    ];

    public $sectionRates = [
        'orientation' => 0,
        'school_support' => 0,
        'company' => 0,
        'monitoring' => 0,
        'impact' => 0,
    ];
    public $overallRate = 0;

    protected function calculateSectionRates()
    {
        foreach ($this->sectionRates as $section => $rate) {
            $responses = $this->responses[$section];
            if (count($responses) > 0) {
                $this->sectionRates[$section] = array_sum($responses) / count($responses);
            }
        }
    }

    public function submitEvaluation()
    {
        // Validate the responses
        $this->validate([
            'responses.orientation.*' => 'required|integer|between:1,5',
            'responses.school_support.*' => 'required|integer|between:1,5',
            'responses.company.*' => 'required|integer|between:1,5',
            'responses.monitoring.*' => 'required|integer|between:1,5',
            'responses.impact.*' => 'required|integer|between:1,5',
        ]);

        // Calculate the rate for each section
        $totalSum = 0;
        foreach ($this->responses as $section => $questions) {
            $totalSum += array_sum($questions);
        }

        CoordinatorRating::create([
            'student_id' => $this->student_id,
            'responses' => json_encode($this->responses), // Save responses as JSON
            'total_rating' => $totalSum, // Save overall rate
        ]);

    }


    protected function calculateOverallRate()
    {
        $totalSections = count($this->sectionRates);
        $totalRate = array_sum($this->sectionRates);

        if ($totalSections > 0) {
            $this->overallRate = $totalRate / $totalSections;
        }
    }


    public function mount()
    {
        $this->student_id = request('id');

        $student = Student::findOrFail($this->student_id);

        $this->student_name = $student->firstname . ' ' . $student->lastname;

        $evaluation = CoordinatorRating::where('student_id', $this->student_id)->first();

        if ($evaluation) {
            $this->results = json_decode($evaluation->responses, true);
            $this->has_rating = true; // Set to true to display results
        }

    }

    public function render()
    {
        return view('livewire.coordinator.student-evaluation');
    }
}
