<?php

namespace App\Livewire\Supervisor;

use App\Models\Absent;
use App\Models\Trainee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class ManageAbsent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Absent::query()->whereHas('trainee', function($query){
                $query->where('supervisor_id', auth()->user()->supervisor->id);
            }))->headerActions([
                Action::make('back')->color('gray')->url(fn($record) => route('supervisor.attendance')),
                CreateAction::make('new')->icon(
                    'heroicon-o-plus'
                )->form([
                    Select::make('trainee_id')->label('Trainee')->options(
                        Trainee::where('supervisor_id', auth()->user()->supervisor->id)->get()->mapWithKeys(
                            function ($trainee) {
                                return [$trainee->id => $trainee->student->user->name];
                            }
                        )
                        ),
                    DatePicker::make('date_of_absent')->required(),
                    Textarea::make('reason')->required(),
                ])->modalWidth('xl')->action(
                    function($data){
                        Absent::create([
                            'trainee_id' => $data['trainee_id'],
                            'date_of_absent' => $data['date_of_absent'],
                           'reason' => $data['reason'],
                        ]);
                    }
                )
            ])
            ->columns([
                TextColumn::make('trainee.student.user.name')->label('TRAINEE')->searchable(),
                TextColumn::make('date_of_absent')->date()->label('DATE OF ABSENT')->searchable(),
                TextColumn::make('reason')->label('REASON')->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
            //    EditAction::make('edit')->color('success'),
               DeleteAction::make('delete'),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.supervisor.manage-absent');
    }
}
