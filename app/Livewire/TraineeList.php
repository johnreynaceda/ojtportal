<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Trainee;
use App\Models\UserLog;
use Carbon\Carbon;
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

class TraineeList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function render()
    {
        return view('livewire.trainee-list');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Trainee::query()->where('supervisor_id', auth()->user()->supervisor->id))
            ->columns([
                TextColumn::make('student.student_id')->label('STUDENT ID')->searchable()->sortable(),
                TextColumn::make('id')->label('FULLNAME')->formatStateUsing(fn($record) => $record->student->lastname . ', ' . $record->student->firstname)->searchable()->sortable(),
                TextColumn::make('student.major')->label('MAJOR')->searchable()->sortable(),
                TextColumn::make('student.section')->label('SECTION')->searchable()->sortable(),
                TextColumn::make('status')->label('STATUS')->searchable()->badge()->color(fn(string $state): string => match ($state) {
                    'On-the-job training' => 'gray',
                    'Completed' => 'success',
                })->icon(fn(string $state): string => match ($state) {
                        'On-the-job training' => 'heroicon-s-briefcase',
                        'Completed' => 'heroicon-s-check-circle',
                    }),




            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('complete')->button()->outlined()->color('success')->icon('heroicon-s-check-circle')->iconPosition(IconPosition::After)->action(
                    function ($record) {
                        $record->update([
                            'status' => 'Completed',
                        ]);

                        UserLog::create([
                            'user_type' => auth()->user()->user_type,
                            'username' => auth()->user()->name,
                            'date' => Carbon::now(),
                            'activity' => 'Mark ' . $record->student->user->name . 'complete from internship',
                        ]);
                    }
                )
            ])
            ->bulkActions([
                // ...
            ]);
    }

}
