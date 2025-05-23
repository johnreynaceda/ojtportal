<?php

namespace App\Livewire\Student;

use App\Models\Task;
use App\Models\UserLog;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MyTask extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                optional(auth()->user()->student)->trainee
                ? Task::query()->whereHas('taskAssignedStudents', function ($query) {
                    $query->where('trainee_id', auth()->user()->student->trainee->id);
                })
                : Task::query()->whereRaw('1 = 0')
            )
            ->columns([
                TextColumn::make('name')->label('NAME')->searchable(),
                TextColumn::make('description')->label('DESCRIPTION')->searchable(),
                TextColumn::make('due_date')->date()->label('DUE DATE')->searchable()->formatStateUsing(function ($state) {
                    $dueDate = Carbon::parse($state)->startOfDay();
                    $now = Carbon::now()->startOfDay();

                    if ($now->greaterThan($dueDate)) {
                        return 'Overdue';
                    }

                    return 'Not due';
                }),
                TextColumn::make('status')->badge()->label('STATUS')->searchable()->color(fn(string $state): string => match ($state) {
                    'In Progress' => 'warning',
                    'Completed' => 'success',
                    'Delayed' => 'danger',
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('done')->label('Done')
                    ->button()->color('success')->visible(fn($record) => $record->status == 'In Progress')
                    ->icon('heroicon-m-check-circle')->outlined()->action(
                        function ($record) {
                            $currentDate = Carbon::now()->startOfDay();
                            $dueDate = Carbon::parse($record->due_date)->startOfDay();

                            if ($dueDate->lt($currentDate)) {
                                $record->update([
                                    'status' => 'Delayed',
                                ]);
                            } else {
                                $record->update([
                                    'status' => 'Completed',
                                ]);
                            }

                            UserLog::create([
                                'user_type' => auth()->user()->user_type,
                                'username' => auth()->user()->name,
                                'date' => Carbon::now(),
                                'activity' => 'Mark ' . $record->name . 'task to done',
                            ]);
                        }
                    )
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.student.my-task');
    }
}
