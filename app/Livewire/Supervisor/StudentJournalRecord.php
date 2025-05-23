<?php

namespace App\Livewire\Supervisor;

use App\Models\Student;
use App\Models\StudentJournal;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StudentJournalRecord extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $student;

    public function mount()
    {
        $this->student = Student::where('id', request('id'))->first();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentJournal::query()->where('student_id', $this->student->id))->headerActions([
                    Action::make('back')->icon('heroicon-o-arrow-left')->url(route('supervisor.journal')),
                ])
            ->columns([
                TextColumn::make('date')->label('DATE')->date()->searchable(),
                TextColumn::make('activities')->label('ACTIVITIES')->words(5)->searchable(),
                TextColumn::make('problem_encountered')->label('PROBLEM/ENCOUNTERED')->words(5)->searchable(),
                TextColumn::make('reflection')->label('REFLECTION')->words(5)->searchable(),
                TextColumn::make('am_timein')->label('AM')->words(5)->searchable()->formatStateUsing(
                    fn($record) => Carbon::parse($record->am_timein)->format('h:i A') . ' - ' . Carbon::parse($record->am_timeout)->format('h:i A')
                ),
                TextColumn::make('pm_timein')->label('PM')->words(5)->searchable()->formatStateUsing(
                    fn($record) => Carbon::parse($record->pm_timein)->format('h:i A') . ' - ' . Carbon::parse($record->pm_timeout)->format('h:i A')
                ),
                TextColumn::make('status')->label('STATUS')->words(5)->searchable()->badge()->color(fn(string $state): string => match ($state) {
                    'On-time' => 'success',
                    'Delayed' => 'danger',

                }),
                TextColumn::make('journal_status')->label('')->words(5)->searchable()->formatStateUsing(
                    fn($record) => ucfirst($record->journal_status)
                )->badge()->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',

                    }),


            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('approved')->color('success')->icon('heroicon-m-hand-thumb-up')->action(
                        fn($record) => $record->update([
                            'journal_status' => 'approved'
                        ])
                    ),
                    Action::make('reject')->color('danger')->icon('heroicon-m-hand-thumb-down')->action(
                        fn($record) => $record->update([
                            'journal_status' => 'rejected'
                        ])
                    ),
                ])->visible(fn($record) => $record->journal_status == 'pending' && auth()->user()->user_type == 'supervisor'),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.supervisor.student-journal-record');
    }
}
