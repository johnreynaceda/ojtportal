<?php

namespace App\Livewire;

use App\Models\StudentEvaluation;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StudentEvaluationRecord extends Component implements HasForms
{
    use InteractsWithForms;

    public $rating;
    public $question_1, $question_2, $question_3;

    public $record;


    public function mount()
    {
        $this->record = StudentEvaluation::where('student_id', auth()->user()->student->id)->first();
        if ($this->record) {
            $this->question_1 = $this->record->question_1;
            $this->question_2 = $this->record->question_2;
            $this->question_3 = $this->record->question_3;
            $this->rating = $this->record->rate;
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('question_1')->label('Potential of the company as training ground')
                    ->placeholder('Provide the reader concreate ideas why the company is a potential training ground and why not'),
                Textarea::make('question_2')->label('Proposed Revisions for the Improvement of the Training Program')
                    ->placeholder('Provide inputs on how to further improve the programs. You may relate it through personal experiences'),
                Textarea::make('question_3')->label('Advised to Future Student Interns')
                    ->placeholder('Provide some important points on how to become a successful student-intern'),
                ViewField::make('rating')->label('Rate Internship Experience')
                    ->view('filament.forms.rating')
            ]);
    }

    public function submit()
    {
        StudentEvaluation::create([
            'student_id' => auth()->user()->student->id,
            'question_1' => $this->question_1,
            'question_2' => $this->question_2,
            'question_3' => $this->question_3,
            'rate' => $this->rating
        ]);

        return redirect()->route('student.evaluate');
    }



    public function render()
    {
        return view('livewire.student-evaluation-record');
    }
}
