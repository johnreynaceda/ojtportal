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
                    // Calculate the difference from now
                    $dueDate = Carbon::parse($state);
                    $now = Carbon::now();

                    if ($now->greaterThan($dueDate)) {
                        return 'Overdue'; // Optionally handle past due dates
                    }

                    return $dueDate->diffForHumans($now, [
                        'parts' => 2, // Display up to 2 parts, e.g., "1 day 3 hours"
                        'short' => true, // Use short units, e.g., "1d 3h"
                    ]);
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
                            $currentDate = now(); // Get the current date and time
                            $dueDate = $record->due_date;

                            if ($dueDate < $currentDate) {
                                $record->update([
                                    'status' => 'Delayed',
                                ]);
                            } else {
                                // If due date is not in the past, set status to 'completed'
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
