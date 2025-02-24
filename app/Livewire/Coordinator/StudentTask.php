<?php

namespace App\Livewire\Coordinator;

use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Trainee;
use Filament\Forms\Components\Select;
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

class StudentTask extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public function table(Table $table): Table
    {
        return $table
            ->query(Trainee::query()->whereHas('student', function($stud){
                $stud->where('course_id', auth()->user()->course_id);
            }))
            ->columns([
                TextColumn::make('student.student_id')->label('STUDENT ID')->searchable()->sortable(),
                TextColumn::make('id')->label('FULLNAME')->formatStateUsing(fn($record) => $record->student->lastname.', '. $record->student->firstname )->searchable()->sortable(),
                TextColumn::make('student.section')->label('SECTION')->searchable()->sortable(),
                TextColumn::make('student.major')->label('MAJOR')->searchable()->sortable(),
                
            ])
            ->filters([
                // ...
            ])
            ->actions([
             Action::make('view')->label('View Tasks')->button()->color('warning')->icon('heroicon-o-eye')->outlined()->url(fn ($record): string => route('coordinator.view_task', ['id' => $record->id]))
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function render()
    {
        return view('livewire.coordinator.student-task');
    }
}
