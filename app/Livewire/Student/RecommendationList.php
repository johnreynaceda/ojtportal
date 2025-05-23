<?php

namespace App\Livewire\Student;

use App\Models\RecommendationResponse;
use App\Models\Resume;
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
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use function Flasher\SweetAlert\Prime\sweetalert;

class RecommendationList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $experience;
    public $location;
    public $arrangement;
    public $company_id;
    public $supervisor_id;
    public $student_id;
    public $student_company_id;

    public $response;

    public function mount()
    {
        $this->response = RecommendationResponse::where('student_id', auth()->user()->student->id)->first();
        if ($this->response) {
            $this->experience = $this->response->work_experience;
            $this->location = $this->response->internship_location;
            $this->arrangement = $this->response->internship_arrangement;
        } else {

        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Supervisor::query())->headerActions([
                    Action::make('back')->label('Back')->color('gray')->url(fn() => route('student.company'))
                ])
            ->columns([
                TextColumn::make('company_name')->label('COMPANY NAME')->sortable()->searchable(),
                TextColumn::make('company_address')->label('ADDRESS')->sortable()->searchable(),
                TextColumn::make('contact_number')->label('CONTACT')->sortable()->searchable(),
                TextColumn::make('id')->label('SUPERVISOR NAME')->sortable()->searchable()->formatStateUsing(
                    fn($record) => $record->user->name
                ),
                ViewColumn::make('rating')->label('PERCENTAGE')->view('filament.tables.percentage')
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


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Answer the following:')->schema([
                    Radio::make('experience')
                        ->label('Do you have work experience?')
                        ->boolean()
                        ->inline()
                        ->inlineLabel(false),
                    Radio::make('location')->label('Preferred Internship Location')
                        ->options([
                            'LSPU' => 'LSPU',
                            'Outside' => 'Outside LSPU',
                        ])
                        ->inline()
                        ->inlineLabel(false),
                    Radio::make('arrangement')->label('Preferred Internship Arrangement')
                        ->options([
                            'On-site' => 'On-site',
                            'Remote' => 'Remote',
                            'Hybrid' => 'Hybrid',
                        ])
                        ->inline()
                        ->inlineLabel(false)
                ])->columns(2)

            ]);
    }

    public function submit()
    {

        $data = Resume::where('user_id', auth()->user()->id)->first();

        if ($data) {
            RecommendationResponse::create([
                'student_id' => auth()->user()->student->id,
                'work_experience' => $this->experience,
                'internship_location' => $this->location,
                'internship_arrangement' => $this->arrangement
            ]);
        } else {
            sweetalert()->error('Please upload a resume first');
        }



        return redirect(route('student.recommendation'));
    }

    public function render()
    {
        return view('livewire.student.recommendation-list');
    }
}
