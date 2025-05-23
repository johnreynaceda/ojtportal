<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Trainee;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class CoordinatorEvaluation extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $rating;

    public function table(Table $table): Table
    {
        return $table
            ->query(query: Student::query()->whereHas('studentEvaluation')->where('course_id', auth()->user()->course_id))
            ->columns([
                TextColumn::make('student_id')->label('STUDENT ID')->searchable()->sortable(),
                TextColumn::make('firstname')->label('FULLNAME')->formatStateUsing(fn($record) => $record->lastname . ', ' . $record->firstname)->searchable()->sortable(),
                TextColumn::make('major')->label('MAJOR')->searchable()->sortable(),
                TextColumn::make('section')->label('SECTION')->searchable()->sortable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('evaluate')->button()->outlined()->icon('heroicon-o-information-circle')->form(
                    function ($record) {
                        $this->rating = $record->studentEvaluation->rating ?? '';
                        return [
                            Textarea::make('question_1')->label('Potential of the company as training ground')
                                ->placeholder('Provide the reader concreate ideas why the company is a potential training ground and why not')->default($record->studentEvaluation->question_1 ?? ''),
                            Textarea::make('question_2')->label('Proposed Revisions for the Improvement of the Training Program')->default($record->studentEvaluation->question_2 ?? '')
                                ->placeholder('Provide inputs on how to further improve the programs. You may relate it through personal experiences'),
                            Textarea::make('question_3')->label('Advised to Future Student Interns')->default($record->studentEvaluation->question_3 ?? '')
                                ->placeholder('Provide some important points on how to become a successful student-intern'),
                            TextInput::make('rate')->label('Rate Internship Experience')->default($record->studentEvaluation->rate ?? ''),
                        ];
                    }
                )->modalSubmitAction(false)
            ])
            ->bulkActions([
                // ...
            ]);
    }


    public function render()
    {
        return view('livewire.coordinator-evaluation');
    }
}
