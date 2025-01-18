<?php

namespace App\Livewire\Supervisor;

use App\Models\DailyTimeRecord;
use App\Models\Trainee;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ViewDtr extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $trainee_id;
    public $trainee_name;

    public function table(Table $table): Table
    {
        return $table
            ->query(DailyTimeRecord::query()->where('trainee_id', $this->trainee_id))
            ->columns([
                TextColumn::make('date')->label('DATE')->searchable()->date(),
                TextColumn::make('am_time_in')->label('AM TIME-IN')->date('h:i A')->searchable(),
                TextColumn::make('am_time_out')->label('AM TIME-OUT')->date('h:i A')->searchable(),
                TextColumn::make('pm_time_in')->label('PM TIME-IN')->date('h:i A')->searchable(),
                TextColumn::make('pm_time_out')->label('PM TIME-OUT')->date('h:i A')->searchable(),
                TextColumn::make('total_hours')->label('TOTAL HOURS')->searchable(),
                TextColumn::make('status')->badge()->label('STATUS')->searchable()->color(fn (string $state): string => match ($state) {
                    'Pending' => 'warning',
                    'Approved' => 'success',
                    'Rejected' => 'danger',
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
               ActionGroup::make([
                Action::make('approve')->icon('heroicon-s-hand-thumb-up')->color('success')->action(
                    function($record){
                        $record->update([
                            'status' => 'Approved'
                        ]);
                    }
                ),
                Action::make('reject')->icon('heroicon-s-hand-thumb-down')->color('danger')->action(
                    function($record){
                        $record->update([
                            'status' => 'Rejected'
                        ]);
                    }
                ),
               ])
            ])
            ->bulkActions([
               
            ]);
    }

   

    public function mount(){
        $this->trainee_id = request('id');
        $trainee = Trainee::where('id', $this->trainee_id)->first();
        $this->trainee_name = $trainee->student->user->name;
    }
    public function render()
    {
        return view('livewire.supervisor.view-dtr');
    }
}
