<?php

namespace App\Livewire\Coordinator;

use App\Models\Supervisor;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class PartnerList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Supervisor::query())->headerActions([
                    ExportAction::make()->exports([
                        ExcelExport::make()->withColumns([
                            Column::make('company_name')->heading('COMPANY NAME'),
                            Column::make('user.name')->heading('SUPERVISOR NAME'),
                            Column::make("trainees")->heading('TRAINEE HANDLED')->formatStateUsing(
                                fn($record) => $record->trainees->mapWithKeys(function ($record) {
                                    return [$record->id => strtoupper($record->student->firstname) . ' ' . strtoupper($record->student->lastname)];
                                })->implode(', ')
                            ),
                            Column::make('contact_number')->heading('CONTACT'),
                            Column::make('company_address')->heading('ADDRESS'),
                        ]),
                    ])
                ])
            ->columns([
                TextColumn::make('company_name')->label('COMPANY NAME')->searchable(),
                TextColumn::make('firstname')->label('SUPERVISOR NAME')->searchable()->formatStateUsing(
                    fn($record) => strtoupper($record->lastname) . ', ' . strtoupper($record->firstname) . ' ' . strtoupper($record->middlename[0]) . '.'
                ),
                TextColumn::make("trainees")->label('NAME OF TRAINEE HANDLED')->formatStateUsing(
                    fn($record) => $record->trainees->mapWithKeys(function ($record) {
                        return [$record->id => strtoupper($record->student->firstname) . ' ' . strtoupper($record->student->lastname)];
                    })->implode(', ')
                ),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ViewAction::make('view')->color('warning')->slideOver()->modalHeading('Company Details')->form([
                    ViewField::make('data')->view('filament.forms.company-view')
                ]),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.partner-list');
    }
}
