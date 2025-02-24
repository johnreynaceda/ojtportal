<?php

namespace App\Livewire\Coordinator;

use App\Models\Criteria;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CriteriaList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Criteria::query())->headerActions([
               
                CreateAction::make('new')->icon('heroicon-o-plus')->form([
                    TextInput::make('name')
                ])->modalWidth('xl')
            ])
            ->columns([
                TextColumn::make('name')->label('CRITERIA NAME'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('manage_questions')->button()->outlined()->icon('heroicon-o-queue-list')->iconPosition(IconPosition::After)->url(fn($record) => route('coordinator.criteria-questions', ['id' => $record->id])),
                EditAction::make('edit')->color('success')->form([
                    TextInput::make('name')
                ])->modalWidth('xl')
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function render()
    {
        return view('livewire.coordinator.criteria-list');
    }
}
