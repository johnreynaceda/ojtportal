<?php

namespace App\Livewire\Coordinator;

use App\Models\TrainingPlan;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TraningPlan extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(TrainingPlan::query())->headerActions([
                    Action::make('back')->label('Back')->button()->outlined(),
                    CreateAction::make('new')->label('New Skills')->icon('heroicon-o-plus')->form([
                        TextInput::make('skills_to_learn')->label('Skill')->required()
                    ])->modalWidth('xl')->modalHeading('New Skill')
                ])
            ->columns([
                TextColumn::make('created_at')->date()->label('DATE'),
                TextColumn::make('skills_to_learn')->label('SKILLS TO BE LEARNED'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make('edit')->color('success')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.traning-plan');
    }
}
