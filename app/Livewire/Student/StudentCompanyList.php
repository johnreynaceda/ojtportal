<?php

namespace App\Livewire\Student;

use App\Models\StudentCompany;
use App\Models\Supervisor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StudentCompanyList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Supervisor::query())->headerActions([
                    Action::make('recommendation')->label('Company Recommendation')->color('success')->url(fn() => route('student.recommendation'))
                ])
            ->columns([
                TextColumn::make('company_name')->label('COMPANY NAME')->sortable()->searchable(),
                TextColumn::make('company_address')->label('ADDRESS')->sortable()->searchable(),
                TextColumn::make('contact_number')->label('CONTACT')->sortable()->searchable(),
                TextColumn::make('id')->label('SUPERVISOR NAME')->sortable()->searchable()->formatStateUsing(
                    fn($record) => $record->user->name
                ),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ViewAction::make('view')->color('warning')->slideOver()->modalHeading('Company Details')->form([
                    ViewField::make('data')->view('filament.forms.company-view')
                ]),
                Action::make('apply')->button()->size('sm')->color('success')->form([
                    FileUpload::make('resume')->required()->directory('Resume')
                ])->modalWidth('lg')->modalHeading('Upload Resume')->modalSubHeading('Upload a file of Resume.')->action(
                        function ($data, $record) {
                            StudentCompany::create([
                                'student_id' => auth()->user()->student->id,
                                'supervisor_id' => $record->id,
                                'resume_path' => $data['resume'],
                            ]);
                        }
                    )->hidden(
                        function ($record) {
                            return StudentCompany::where('supervisor_id', $record->id)->where('student_id', auth()->user()->student->id)->exists();
                        }
                    ),
                Action::make('cancel')->label('Cancel Application')->button()->size('sm')->color('success')->action(
                    function ($record) {
                        StudentCompany::where('supervisor_id', $record->id)->where('student_id', auth()->user()->student->id)->delete();
                    }
                )->visible(
                        function ($record) {
                            return StudentCompany::where('supervisor_id', $record->id)->where('student_id', auth()->user()->student->id)->exists();
                        }
                    )
            ])
            ->bulkActions([
                // ...
            ]);
    }





    public function render()
    {
        return view('livewire.student.student-company-list');
    }
}
