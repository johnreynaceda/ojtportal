<?php

namespace App\Livewire\Supervisor;

use App\Models\Criteria;
use App\Models\CriteriaQuestion;
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

    public function mount()
    {
        // Use question ID as array key to prevent overwriting issues
        $this->points = CriteriaQuestion::all()->mapWithKeys(fn ($question) => [
            $question->id => [
                'id' => $question->id,
                'earned' => null, // Default value
                'max' => $question->max_point, // Store max points
            ]
        ])->toArray();
    }

    public function updated($property, $value)
    {
        if (preg_match('/points\.(\d+)\.earned/', $property, $matches)) {
            $questionId = $matches[1];

            // Get max points for this specific question
            $maxPoint = $this->points[$questionId]['max'] ?? null;

            // Validate: earned points should NOT exceed max points
            if ($maxPoint !== null && is_numeric($value) && $value > $maxPoint) {
                $this->points[$questionId]['earned'] = $maxPoint; // Force max value
                $this->addError("points.$questionId.earned", "Cannot exceed max points of $maxPoint.");
            } else {
                $this->resetErrorBag("points.$questionId.earned");
            }
        }
    }

    
    public function render()
    {
        return view('livewire.supervisor.performance-rating',[
            'criterias' => Criteria::with('criteriaQuestions')->get(),
        ]);
    }
}
