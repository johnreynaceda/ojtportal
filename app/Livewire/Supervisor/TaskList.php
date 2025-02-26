<?php

namespace App\Livewire\Supervisor;

use App\Models\Task;
use App\Models\TaskAssignedStudent;
use App\Models\Trainee;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\ViewColumn;
use Livewire\Component;

class TaskList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public  $rating = 0;

    public function table(Table $table): Table
    {
        return $table
            ->query(Task::query()->where('supervisor_id', auth()->user()->id))->headerActions(
               [
                CreateAction::make('new')->label('New Tasks')->icon('heroicon-o-plus')->form([
                    Grid::make(2)->schema([
                        TextInput::make('name')->required(),
                        DatePicker::make('due_date'),
                        Textarea::make('description')->columnSpan(2),
                        Select::make('trainees')->options(
                            Trainee::where('supervisor_id', auth()->user()->supervisor->id)->get()->mapWithKeys(
                                function ($trainee) {
                                    return [$trainee->id => $trainee->student->firstname. ' '. $trainee->student->lastname];
                                }
                            ),
                        )->multiple()->columnSpan(2),
                    ])
                ])->modalWidth('xl')->action(
                    function($data){
                     
                        $task = Task::create([
                            'supervisor_id' => auth()->user()->supervisor->id, // Correct assignment
                            'name' => $data['name'],
                            'due_date' => Carbon::parse($data['due_date']),
                            'description' => $data['description'],
                        ]);
                        
                        // Iterate over the trainees and assign them to the task
                        foreach ($data['trainees'] as $traineeId) {
                            TaskAssignedStudent::create([
                                'task_id' => $task->id,
                                'trainee_id' => $traineeId,
                            ]);
                        }
                    }
                )
               ]
            )
            ->columns([
                TextColumn::make('name')->label('TASK NAME')->searchable(),
                TextColumn::make('description')->label('DESCRIPTION')->searchable(),
                ViewColumn::make('id')->label('ASSIGNED')->view('filament.tables.assigned'),
                TextColumn::make('due_date')->label('DUE DATE')->date()->searchable(),
                TextColumn::make('status')->badge()->label('STATUS')->searchable()->color(fn (string $state): string => match ($state) {
                    'In Progress' => 'warning',
                    'Completed' => 'success',
                    'Delayed' => 'danger',
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
               ActionGroup::make([
                Action::make('rate')->name('Rating')->icon('heroicon-o-star')->color('warning')->visible(fn($record) => $record->status != 'In Progress' && $record->rate == null)->form([
                ViewField::make('rating')
                    ->view('filament.forms.rating')
                ])->modalWidth('xl')->action(
                    function($record){
                        $record->update([
                            'rate' => $this->rating,
                        ]);
                    }
                ),
                EditAction::make('edit')->color('success'),
                DeleteAction::make('delete')
               ])
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
       
        return view('livewire.supervisor.task-list');
    }
}
