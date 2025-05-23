<?php

namespace App\Livewire\Coordinator;

use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Trainee;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class JournalList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(auth()->user()->user_type == 'supervisor' ? Trainee::query()->where('supervisor_id', auth()->user()->supervisor->id) : Trainee::query()->whereHas('student', function ($record) {
                $record->where('coordinator_id', auth()->user()->coordinator->id);
            }))->headerActions([
                    Action::make('manage_absent')->label('Manage Absents')->icon('heroicon-o-adjustments-horizontal')->iconPosition(IconPosition::After)->url(fn() => route('supervisor.absents'))
                ])
            ->columns([
                TextColumn::make('student.student_id')->label('STUDENT ID')->searchable()->sortable(),
                TextColumn::make('id')->label('FULLNAME')->formatStateUsing(fn($record) => $record->student->lastname . ', ' . $record->student->firstname)->searchable()->sortable(),
                TextColumn::make('student.section')->label('SECTION')->searchable()->sortable(),
                ViewColumn::make('spent')->label('SPENT')->view('filament.tables.spent'),
                ViewColumn::make('remaining')->label('REMAINING')->view('filament.tables.remaining'),


            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('view')->label('VIEW JOURNAL')->icon('heroicon-o-eye')->button()->color('warning')->outlined()->url(fn($record): string => route('supervisor.student-journal', ['id' => $record->student_id]))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.journal-list');
    }
}
