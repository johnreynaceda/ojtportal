<?php

namespace App\Livewire\Student;

use App\Models\Absent;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MyAbsent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Absent::query()->where('trainee_id', auth()->user()->student->trainee->id))->headerActions([
                CreateAction::make('new')->icon(
                    'heroicon-o-plus'
                )->form([
                    DatePicker::make('date_of_absent')->required(),
                    Textarea::make('reason')->required(),
                ])->modalWidth('xl')->action(
                    function($data){
                        Absent::create([
                            'trainee_id' => auth()->user()->student->trainee->id,
                            'date_of_absent' => $data['date_of_absent'],
                           'reason' => $data['reason'],
                        ]);
                    }
                )
            ])
            ->columns([
                TextColumn::make('date_of_absent')->date()->label('DATE OF ABSENT')->searchable(),
                TextColumn::make('reason')->label('REASON')->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
               EditAction::make('edit')->color('success'),
               DeleteAction::make('delete'),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        
        return view('livewire.student.my-absent');
    }
}
