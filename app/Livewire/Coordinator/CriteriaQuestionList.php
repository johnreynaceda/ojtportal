<?php

namespace App\Livewire\Coordinator;

use App\Models\Criteria;
use App\Models\CriteriaQuestion;
use Filament\Forms\Components\Textarea;
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

class CriteriaQuestionList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $criteriaId;
    public $criteria;

    public function mount(){
        $this->criteriaId = request('id');
        $this->criteria = Criteria::find($this->criteriaId)->name;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(CriteriaQuestion::query()->where('criteria_id', $this->criteriaId))->headerActions([
                Action::make('back')->color('gray')->icon('heroicon-o-arrow-left')->label('BACK')->url(fn() => route('coordinator.evaluation-form')),
                CreateAction::make('new')->icon('heroicon-o-plus')->form([
                    Textarea::make('question')->required(),
                    TextInput::make('max_point')->numeric()->rules('max:10')->required(),
                ])->modalWidth('xl')->action(
                    function($record,$data){
                        CriteriaQuestion::create([
                            'criteria_id' => $this->criteriaId,
                            'question' => $data['question'],
                           'max_point' => $data['max_point'],
                        ]);
                    }
                )
            ])
            ->columns([
                TextColumn::make('question')->label('QUESTIONS'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make('edit')->color('success')->form([
                    Textarea::make('question'),
                    TextInput::make('max_point')->numeric()->rules('max:10')->required(),
                ])->modalWidth('xl')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.criteria-question-list');
    }
}
