<?php

namespace App\Livewire\Student;

use App\Models\Absent;
use App\Models\DailyTimeRecord;
use App\Models\UserLog;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class MyDtr extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                optional(auth()->user()->student)->trainee
                ? DailyTimeRecord::query()->where('trainee_id', auth()->user()->student->trainee->id)
                : DailyTimeRecord::query()->whereRaw('1 = 0') // Ensures no records are returned
            )->headerActions([
                    // Action::make('manage')->disabled(!optional(auth()->user()->student)->trainee)->label('Manage Absent')->color('warning')->icon('heroicon-o-arrow-top-right-on-square')->iconPosition(IconPosition::After)->url(fn (): string => route('student.absent')),
                    CreateAction::make('add')->disabled(!optional(auth()->user()->student)->trainee)->label('New DTR')->icon('heroicon-o-plus')->modalWidth('xl')->modalHeading('Create DTR')->form([
                        Grid::make(2)->schema([
                            DatePicker::make('date')->required(),

                        ]),
                        Grid::make(2)->schema([

                            TimePicker::make('am_time_in')->label('AM Time-In')->required()->seconds(false),
                            TimePicker::make('am_time_out')->label('AM Time-Out')->required()->seconds(false),
                            TimePicker::make('pm_time_in')->label('PM Time-In')->required()->seconds(false),
                            TimePicker::make('pm_time_out')->label('PM Time-Out')->required()->seconds(false),
                        ]),
                    ])->action(
                            function ($data) {
                                $exists = DailyTimeRecord::where('trainee_id', auth()->user()->student->trainee->id)->where('date', $data['date'])->exists();

                                if ($exists) {
                                    sweetalert()->error('Date[' . Carbon::parse($data['date'])->format('F d, Y') . '] is already exists');

                                } else {
                                    DailyTimeRecord::create([
                                        'trainee_id' => auth()->user()->student->trainee->id,
                                        'date' => $data['date'],
                                        'am_time_in' => $data['am_time_in'],
                                        'am_time_out' => $data['am_time_out'],
                                        'pm_time_in' => $data['pm_time_in'],
                                        'pm_time_out' => $data['pm_time_out'],
                                        'total_hours' => $this->calculateTotalHours(
                                            $data['am_time_in'],
                                            $data['am_time_out'],
                                            $data['pm_time_in'],
                                            $data['pm_time_out']
                                        ),
                                    ]);

                                    UserLog::create([
                                        'user_type' => auth()->user()->user_type,
                                        'username' => auth()->user()->name,
                                        'date' => Carbon::now(),
                                        'activity' => 'Submit Attendance',
                                    ]);
                                }
                            }
                        ),

                ])
            ->columns([
                TextColumn::make('date')->label('DATE')->searchable()->date(),
                TextColumn::make('am_time_in')->label('AM TIME-IN')->date('h:i A')->searchable(),
                TextColumn::make('am_time_out')->label('AM TIME-OUT')->date('h:i A')->searchable(),
                TextColumn::make('pm_time_in')->label('PM TIME-IN')->date('h:i A')->searchable(),
                TextColumn::make('pm_time_out')->label('PM TIME-OUT')->date('h:i A')->searchable(),
                TextColumn::make('total_hours')->label('TOTAL HOURS')->searchable(),
                TextColumn::make('status')->badge()->label('STATUS')->searchable()->color(fn(string $state): string => match ($state) {
                    'Pending' => 'warning',
                    'Approved' => 'success',
                    'Rejected' => 'danger',
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                DeleteAction::make('delete')->action(
                    function ($record) {
                        $record->delete();
                        UserLog::create([
                            'user_type' => auth()->user()->user_type,
                            'username' => auth()->user()->name,
                            'date' => Carbon::now(),
                            'activity' => 'Delete Attendance',
                        ]);
                    }
                )
            ])
            ->bulkActions([
                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn(Collection $records) => $records->each->delete()),
            ]);
    }

    protected function calculateTotalHours($amTimeIn, $amTimeOut, $pmTimeIn, $pmTimeOut)
    {
        $amDuration = strtotime($amTimeOut) - strtotime($amTimeIn); // AM duration in seconds
        $pmDuration = strtotime($pmTimeOut) - strtotime($pmTimeIn); // PM duration in seconds

        $totalDurationInSeconds = $amDuration + $pmDuration;

        // Convert seconds to hours (rounded to 2 decimal places)
        return round($totalDurationInSeconds / 3600, 2);
    }

    public function render()
    {
        return view('livewire.student.my-dtr');
    }
}
