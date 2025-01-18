<?php

namespace App\Livewire\Coordinator;

use App\Models\Student;
use App\Models\StudentJournal;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ViewJournal extends Component implements HasForms, HasTable
{
    
    use InteractsWithTable;
    use InteractsWithForms;
    public $trainee_id;
    public $trainee_name;
    public function render()
    {
        return view('livewire.coordinator.view-journal');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentJournal::query()->where('student_id', $this->trainee_id))
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
               ViewAction::make('view')->color('warning')->button()->outlined()->form([
                Grid::make(2)->schema([
                    Textarea::make('objective')->required(),
                    Textarea::make('accomplishment')->required(),
                    Textarea::make('reflection')->required(),
                    Textarea::make('knowledge')->required(),
                    DatePicker::make('date')->required()
                ])
               ])
            ])
            ->bulkActions([
               
            ]);
    }

    public function mount(){
        $this->trainee_id = request('id');
        $trainee = Student::where('id', $this->trainee_id)->first();
        $this->trainee_name = $trainee->user->name;
    }
}
