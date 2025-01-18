<?php

namespace App\Livewire\Student;

use App\Models\StudentJournal;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
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

class MyJournal extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentJournal::query()->where('student_id', auth()->user()->student->id))->headerActions([
                CreateAction::make('new')->label('New Journal')->icon('heroicon-o-plus')->form([
                    Grid::make(2)->schema([
                        Textarea::make('objective')->required(),
                        Textarea::make('accomplishment')->required(),
                        Textarea::make('reflection')->required(),
                        Textarea::make('knowledge')->required(),
                        DatePicker::make('date')->required()
                    ])
                ])->action(
                    function($data){
                        StudentJournal::create([
                            'student_id' => auth()->user()->student->id,
                            'date' => Carbon::parse($data['date']),
                            'objective' => $data['objective'],
                            'accomplishment' => $data['accomplishment'],
                           'reflection' => $data['reflection'],
                            'knowledge' => $data['knowledge'],
                            'status' => Carbon::parse($data['date'])->isSameDay(now()) ? 'On-time' : 'Delayed'
                        ]);
                    }
                )
            ])
            ->columns([
                TextColumn::make('date')->label('DATE')->date()->searchable(),
                TextColumn::make('objective')->label('OBJECTIVE')->words(5)->searchable(),
                TextColumn::make('accomplishment')->label('ACCOMPLISHMENT')->words(5)->searchable(),
                TextColumn::make('reflection')->label('REFLECTION')->words(5)->searchable(),
                TextColumn::make('knowledge')->label('KNOWLEDGE')->words(5)->searchable(),
                TextColumn::make('status')->label('STATUS')->words(5)->searchable()->badge()->color(fn (string $state): string => match ($state) {
                    'On-time' => 'success',
                    'Delayed' => 'danger',
                    
                }),
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
                DeleteAction::make('delete'),
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
