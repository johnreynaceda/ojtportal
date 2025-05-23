<?php

namespace App\Livewire\Student;

use App\Models\Shop\Product;
use App\Models\StudentRequirement;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadRequirement extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use WithFileUploads;
    public $modalOpen = false;

    public $file_id;
    public $file_name;
    public $upload = [];

    public $requirements_count = 0;

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentRequirement::query()->where('student_id', auth()->user()->student->id))
            ->columns([
                TextColumn::make('name')->label('NAME')->searchable()->formatStateUsing(
                    fn($record) => strtoupper($record->name)
                ),
                ViewColumn::make('id')->label('FILE')->view('filament.tables.file'),
                TextColumn::make('status')->label('STATUS')->searchable()->badge()->color(fn(string $state): string => match ($state) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                DeleteAction::make('delete')->action(
                    function ($record) {
                        $record->update([
                            'file_path' => null,
                            'status' => null
                        ]);
                    }
                )->visible(fn($record) => $record->file_path != null),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('upload')->label('')->required(),

            ]);
    }



    public function submitRequirement()
    {
        $data = StudentRequirement::where('id', $this->file_id)->first();
        foreach ($this->upload as $key => $value) {
            $data->update([
                'file_path' => $value->store('Requirement', 'public'),
            ]);
        }
    }


    public function openUpload($id)
    {
        $this->file_id = $id;
        $this->file_name = StudentRequirement::where('id', $id)->first()->name;
        $this->modalOpen = true;
    }

    public function generateRequirement()
    {
        $names = [
            'Resume',
            'Certification of Registration',
            'Medical Certificate',
            'Evaluation of Grades from Registrar',
            'Good Moral',
            'Parents Consent',
            'Student ID',
            'Insurance',
            'Orientation Certificate',
            'Parents Consent',
            'Endorsement Letter',
            'Internship Contract',
            'Internship Plan',
            'OJT Time-frame'
        ];
        foreach ($names as $key => $value) {
            StudentRequirement::create([
                'name' => $value,
                'student_id' => auth()->user()->student->id
            ]);
        }


    }

    public function dlParentConsent()
    {
        $filePath = public_path('requirements/Parents-Consent.docx'); // adjust path as needed
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404, 'File not found.');
    }

    public function dlInternshipPlan()
    {
        $filePath = public_path('requirements/Internship-Training-Plan.docx'); // adjust path as needed
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404, 'File not found.');
    }
    public function dlTimeFrame()
    {
        $filePath = public_path('requirements/OJT-time-frame.docx'); // adjust path as needed
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404, 'File not found.');
    }
    public function dlContract()
    {
        $filePath = public_path('requirements/Intership-Contract.docx'); // adjust path as needed
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404, 'File not found.');
    }

    public function dlEndorsement()
    {
        $filePath = public_path('requirements/Endorsement-Letter.docx'); // adjust path as needed
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404, 'File not found.');
    }

    public function render()
    {
        $this->requirements_count = StudentRequirement::where('student_id', auth()->user()->student->id)->count();
        return view('livewire.student.upload-requirement');
    }
}
