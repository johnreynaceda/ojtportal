<?php

namespace App\Livewire;

use App\Models\StudentCompany;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;


class SupervisorApplicant extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentCompany::query()->where('supervisor_id', auth()->user()->supervisor->id))
            ->columns([
                TextColumn::make('student.student_id')->label('ID NO.'),
                TextColumn::make('student.user.name')->label('STUDENT NAME'),
                TextColumn::make('student.major')->label('MAJOR'),
                ViewColumn::make('id')->label('RESUME')->view('filament.tables.resume'),
                ViewColumn::make('rating')->label('MATCHING PERCENTAGE')->view('filament.tables.supervisor-percentage'),
                TextColumn::make('status')->formatStateUsing(fn($record) => ucfirst($record->status))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })


            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('approve')->color('success')->action(
                        fn($record) => $record->update([
                            'status' => 'approved'
                        ])
                    ),
                    Action::make('reject')->color('danger')->action(
                        fn($record) => $record->update([
                            'status' => 'rejected'
                        ])
                    ),
                ])
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.supervisor-applicant');
    }
}
