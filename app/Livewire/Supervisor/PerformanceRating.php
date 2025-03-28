<?php

namespace App\Livewire\Supervisor;

use App\Models\Criteria;
use App\Models\CriteriaQuestion;
use App\Models\SupervisorSurveyResponse;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PerformanceRating extends Component implements HasForms
{
    use InteractsWithForms;

    public $points = [];
    public $student_id;

    public $responses = [];

    public $has_rating = false;

    public function mount()
    {
        $this->student_id = request('id');
        // Use question ID as array key to prevent overwriting issues
        $this->points = CriteriaQuestion::all()->mapWithKeys(fn($question) => [
            $question->id => [
                'id' => $question->id,
                'earned' => null, // Default value
                'max' => $question->max_point, // Store max points
            ]
        ])->toArray();

        $survey = SupervisorSurveyResponse::where('student_id', $this->student_id)->first();
        if ($survey) {
            $this->responses = json_decode($survey->responses, true);

            // If no responses exist, initialize an empty array for each question
            foreach (CriteriaQuestion::all() as $question) {
                if (!isset($this->responses[$question->id])) {
                    $this->responses[$question->id] = [
                        'earned' => 0, // Default value
                        'max' => $question->max_point, // Store max points
                    ];
                }
            }
            $this->has_rating = true;
        }
    }

    public function updated($property, $value)
    {
        if (preg_match('/points\.(\d+)\.earned/', $property, $matches)) {
            $questionId = $matches[1];

            // Get max points for this specific question
            $maxPoint = $this->points[$questionId]['max'] ?? null;

            // Ensure the value is an integer
            if (is_numeric($value)) {
                $intValue = (int) $value;

                // Validate: earned points should NOT exceed max points
                if ($maxPoint !== null && $intValue > $maxPoint) {
                    $this->points[$questionId]['earned'] = $maxPoint; // Force max value
                    $this->addError("points.$questionId.earned", "Cannot exceed max points of $maxPoint.");
                } else {
                    $this->points[$questionId]['earned'] = $intValue; // Update with casted integer
                    $this->resetErrorBag("points.$questionId.earned");
                }
            } else {
                $this->addError("points.$questionId.earned", "Points must be a valid integer.");
                $this->points[$questionId]['earned'] = 0; // Or leave it unchanged based on your needs
            }
        }
    }

    public function submitRating()
    {
        $total = 0;

        foreach ($this->points as $data) {
            $earned = isset($data['earned']) ? (int) $data['earned'] : 0;
            $total += $earned;
        }

        SupervisorSurveyResponse::create([
            'student_id' => $this->student_id,
            'responses' => json_encode($this->points),
        ]);

    }


    public function render()
    {
        return view('livewire.supervisor.performance-rating', [
            'criterias' => Criteria::with('criteriaQuestions')->get(),
        ]);
    }
}
