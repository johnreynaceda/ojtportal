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

class MyRating extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(query: Student::query()->where('course_id', auth()->user()->course_id))
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
                Action::make('evaluate')->button()->outlined()->icon('heroicon-o-information-circle')->url(fn($record) => route('coordinator.survey-response', ['id' => $record->id]))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.my-rating');
    }
}
