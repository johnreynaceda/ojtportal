<?php

namespace App\Livewire\Coordinator;

use App\Models\Supervisor;
use App\Models\SupervisorMoa;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MoaRecord extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Supervisor::query())
            ->columns([
                TextColumn::make('company_name')->label('COMPANY NAME'),
                TextColumn::make('company_address')->label('ADDRESS'),
                TextColumn::make('contact_number')->label('CONTACT'),
                TextColumn::make('supervisorMoa.expiration')->date()->label('MOA EXPIRATION'),
                TextColumn::make('supervisorMoa.status')->label('STATUS'),
                TextColumn::make('supervisorMoa.remarks')->label('REMARKS'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make('view')->color('success')->modalHeading('Company Details')->form([
                        ViewField::make('data')->view('filament.forms.company-view')
                    ]),
                    Action::make('moa')->label('Submit MOA')->size(ActionSize::ExtraSmall)->color('success')->icon('heroicon-o-arrow-up-on-square-stack')->form([
                        FileUpload::make('moa_file')->label('Upload MOA')->required()->directory('MOA'),
                        DatePicker::make('expiration')->required()
                    ])->modalWidth('xl')->modalHeading('UPLOAD MOA')->modalSubHeading('Upload a file of Memorandum of Agreement.')->action(
                            function ($record, $data) {
                                SupervisorMoa::create([
                                    'coordinator_id' => auth()->user()->coordinator->id,
                                    'supervisor_id' => $record->id,
                                    'expiration' => Carbon::parse($data['expiration']),
                                    'moa_file_path' => $data['moa_file']
                                ]);
                            }
                        )->hidden(fn($record) => $record->supervisorMoa != null),
                    DeleteAction::make('delete')->action(
                        function ($record) {
                            SupervisorMoa::where('supervisor_id', $record->id)->first()->delete();
                        }
                    )
                ])
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.moa-record');
    }
}
