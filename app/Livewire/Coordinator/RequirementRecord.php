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
use Livewire\Component;
use Livewire\WithFileUploads;


class RequirementRecord extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentRequirement::query()->whereHas('student', function($query){
                $query->where('course_id', auth()->user()->course_id);
            })->groupBy('student_id'))
            ->columns([
                TextColumn::make('student.student_id')->label('ID NO.')->searchable(),
                TextColumn::make('student.user.name')->label('NAME')->searchable(),
                TextColumn::make('student.major')->label('MAJOR')->searchable(),
                TextColumn::make('student.section')->label('SECTION')->searchable(),
                ViewColumn::make('requirements')->label('REQUIREMENTS')->view('filament.tables.requirement'),
                ViewColumn::make('requirement_status')->label('STATUS')->view('filament.tables.requirement_status'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
               
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.requirement-record');
    }
}
