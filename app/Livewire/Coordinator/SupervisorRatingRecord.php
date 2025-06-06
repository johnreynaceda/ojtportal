<?php

namespace App\Livewire\Coordinator;

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
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SupervisorRatingRecord extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Trainee::query()->whereHas('student', function ($record) {
                $record->where('coordinator_id', auth()->user()->coordinator->id);
            }))
            ->columns([
                TextColumn::make('student.student_id')->label('STUDENT ID')->searchable()->sortable(),
                TextColumn::make('id')->label('FULLNAME')->formatStateUsing(fn($record) => $record->student->lastname . ', ' . $record->student->firstname)->searchable()->sortable(),
                TextColumn::make('student.major')->label('MAJOR')->searchable()->sortable(),
                TextColumn::make('student.course.name')->label('COURSE')->searchable()->sortable(),
                TextColumn::make('student.section')->label('SECTION')->searchable()->sortable(),
                // TextColumn::make("final_rating")->label('FINAL RATING')->searchable()->sortable(),
                ViewColumn::make('status')->label('FINAL RATING')->view('filament.tables.final-rating')
                // TextColumn::make('status')->label('STATUS')->searchable()->badge()->color(fn (string $state): string => match ($state) {
                //     'On-the-job training' => 'gray',
                //     'Completed' => 'success',
                // })->icon(fn (string $state): string => match ($state) {
                //     'On-the-job training' => 'heroicon-s-briefcase',
                //     'Completed' => 'heroicon-s-check-circle',
                // }),




            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('evalution')->button()->icon('heroicon-m-eye')->iconPosition(IconPosition::After)->url(fn($record) => route('coordinator.supervisor-rating-record', ['id' => $record->student->id])),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.supervisor-rating-record');
    }
}
