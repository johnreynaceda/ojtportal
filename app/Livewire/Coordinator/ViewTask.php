<?php

namespace App\Livewire\Coordinator;

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

class ViewTask extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $trainee_id;
    public $trainee_name;

    public function mount(){
        $this->trainee_id = request('id');
        $this->trainee_name = Trainee::find($this->trainee_id)->student->user->name;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(TaskAssignedStudent::query()->where('trainee_id', $this->trainee_id))->columns([
                TextColumn::make('task.name')->label('TASK NAME')->searchable(),
                TextColumn::make('task.description')->label('DESCRIPTION')->searchable(),
                // ViewColumn::make('id')->label('ASSIGNED')->view('filament.tables.assigned'),
                TextColumn::make('task.due_date')->label('DUE DATE')->date()->searchable(),
                TextColumn::make('task.status')->badge()->label('STATUS')->searchable()->color(fn (string $state): string => match ($state) {
                    'In Progress' => 'warning',
                    'Completed' => 'success',
                    'Delayed' => 'danger',
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
            //    ActionGroup::make([
            //     Action::make('rate')->name('Rating')->icon('heroicon-o-star')->color('warning')->visible(fn($record) => $record->status != 'In Progress' && $record->rate == null)->form([
            //     ViewField::make('rating')
            //         ->view('filament.forms.rating')
            //     ])->modalWidth('xl')->action(
            //         function($record){
            //             $record->update([
            //                 'rate' => $this->rating,
            //             ]);
            //         }
            //     ),
            //     EditAction::make('edit')->color('success'),
            //     DeleteAction::make('delete')
            //    ])
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.view-task');
    }
}
