<?php

namespace App\Livewire\Coordinator;

use App\Models\Shop\Product;
use App\Models\StudentRequirement;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;


class RequirementRecord extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                StudentRequirement::query()
                    ->whereHas('student', function ($query) {
                        $query->where('course_id', auth()->user()->course_id);
                    })
                    ->with('student') // Make sure to eager load student relationship
                    ->select('student_id', DB::raw('MAX(id) as id')) // Get the latest requirement
                    ->groupBy('student_id') // Group by student_id
            )->headerActions([
                    ExportAction::make('export')->label('EXPORT')->color('success')->exports([
                        ExcelExport::make()->fromTable()->except([
                            'requirement_status',
                            'requirements',
                        ])->withColumns([
                                    Column::make('student.student_id')->heading('STUDENT ID'),
                                    Column::make('student.user.name')->heading('FULLNAME'),
                                    Column::make('student.major')->heading('MAJOR'),
                                    Column::make('student.section')->heading('SECTION'),
                                    Column::make("status")->heading('STATUS')->getStateUsing(
                                        fn($record) => $record->student->studentRequirements->where('status', null)->count() > 0 ? 'IN PROGRESS' : 'COMPLETE'
                                    ),

                                ]),

                    ]),
                ])
            ->columns([
                TextColumn::make('student.student_id')->label('ID NO.')->searchable(),
                TextColumn::make('student.user.name')->label('NAME')->searchable(),
                TextColumn::make('student.major')->label('MAJOR')->searchable(),
                TextColumn::make('student.section')->label('SECTION')->searchable(),
                ViewColumn::make('requirements')->label('REQUIREMENTS')->view('filament.tables.requirement'),
                ViewColumn::make('requirement_status')->label('STATUS')->view('filament.tables.requirement_status'),
                ViewColumn::make('status')->hidden()->label('STATUS'),
            ])
            ->filters([
                // Your filters...
            ])
            ->actions([
                // Your actions...
            ])
            ->bulkActions([
                // Your bulk actions...
            ]);

    }

    public function render()
    {
        return view('livewire.coordinator.requirement-record');
    }
}
