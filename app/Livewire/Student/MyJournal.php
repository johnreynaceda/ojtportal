<?php

namespace App\Livewire\Student;

use App\Models\StudentJournal;
use App\Models\UserLog;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MyJournal extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentJournal::query()->where('student_id', auth()->user()->student->id))->headerActions([
                    Action::make('absent')->label('Manage Absent')->color('success')->url(route('student.absent')),
                    CreateAction::make('new')->label('New Journal')->icon('heroicon-o-plus')->form([
                        // Grid::make(2)->schema([
                        //     Textarea::make('objective')->required(),
                        //     Textarea::make('accomplishment')->required(),
                        //     Textarea::make('reflection')->required(),
                        //     Textarea::make('knowledge')->required(),
                        //     DatePicker::make('date')->required()
                        // ])
                        Grid::make(2)->schema([
                            DatePicker::make('date')->required()
                        ]),
                        Grid::make(2)->schema([
                            TimePicker::make('am_timein')->label('AM Time In')->required()->withoutSeconds(),
                            TimePicker::make('am_timeout')->label('AM Time Out')->required()->withoutSeconds(),
                            TimePicker::make('pm_timein')->label('PM Time In')->required()->withoutSeconds(),
                            TimePicker::make('pm_timeout')->label('PM Time Out')->required()->withoutSeconds(),
                            Textarea::make('activities')->required(),
                            Textarea::make('problem_encountered')->label('Problem/Encountered')->required(),
                            Textarea::make('reflection')->label('Reflection')->required(),
                        ])
                    ])->action(
                            function ($data) {

                                $amTimeIn = Carbon::parse($data['am_timein']);
                                $amTimeOut = Carbon::parse($data['am_timeout']);

                                $pmTimeIn = Carbon::parse($data['pm_timein']);
                                $pmTimeOut = Carbon::parse($data['pm_timeout']);

                                $totalHours = $amTimeIn->diffInMinutes($amTimeOut) / 60 + $pmTimeIn->diffInMinutes($pmTimeOut) / 60;


                                $hours = $totalHours;




                                StudentJournal::create([
                                    'student_id' => auth()->user()->student->id,
                                    'date' => Carbon::parse($data['date']),
                                    'am_timein' => $data['am_timein'],
                                    'am_timeout' => $data['am_timeout'],
                                    'pm_timein' => $data['pm_timein'],
                                    'pm_timeout' => $data['pm_timeout'],
                                    'activities' => $data['activities'],
                                    'problem_encountered' => $data['problem_encountered'],
                                    'reflection' => $data['reflection'],
                                    'no_of_hours' => $hours,
                                    'status' => Carbon::parse($data['date'])->isSameDay(now()) ? 'On-time' : 'Delayed',
                                    'journal_status' => 'pending'
                                ]);

                                UserLog::create([
                                    'user_type' => auth()->user()->user_type,
                                    'username' => auth()->user()->name,
                                    'date' => Carbon::now(),
                                    'activity' => 'Submit Journal',
                                ]);
                            }
                        )
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
                TextColumn::make('journal_status')->label("")->words(5)->searchable()->badge()->color(fn(string $state): string => match ($state) {
                    'approved' => 'success',
                    'rejected' => 'danger',
                    'pending' => 'warning',

                })->formatStateUsing(
                        fn($record) => ucfirst($record->journal_status)
                    ),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make('edit')->color('success')->form([
                    Grid::make(2)->schema([
                        Textarea::make('objective')->required(),
                        Textarea::make('accomplishment')->required(),
                        Textarea::make('reflection')->required(),
                        Textarea::make('knowledge')->required(),
                    ])
                ]),
                DeleteAction::make('delete')->action(
                    function ($record) {
                        $record->delete();
                        UserLog::create([
                            'user_type' => auth()->user()->user_type,
                            'username' => auth()->user()->name,
                            'date' => Carbon::now(),
                            'activity' => 'Delete Journal',
                        ]);
                    }
                ),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.student.my-journal');
    }
}
