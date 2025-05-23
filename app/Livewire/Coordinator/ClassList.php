<?php

namespace App\Livewire\Coordinator;

use App\Models\Shop\Product;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Trainee;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use PhpParser\Node\Stmt\Label;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ClassList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $openModal = false;
    public $student_id;
    public $supervisor_id;

    public $student = [];
    public $supervisor = [];
    public $supervisor_location;
    public $view_student = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(query: Student::query()->where('coordinator_id', auth()->user()->coordinator->id))->headerActions([
                    // ExportAction::make('export')->label('EXPORT')->color('success'),
                    ExportAction::make()->exports([
                        ExcelExport::make()->withColumns([
                            Column::make('student_id')->heading('ID NUMBER'),
                            Column::make('user.name')->heading('FULLNAME'),
                            Column::make('user.email')->heading('EMAIL'),
                            Column::make('student_contact')->heading('CONTACT'),
                            Column::make('address')->heading('ADDRESS'),
                        ]),
                    ])
                ])
            ->columns([
                TextColumn::make('student_id')->label('STUDENT ID')->searchable()->sortable(),
                TextColumn::make('firstname')->label('FULLNAME')->formatStateUsing(fn($record) => $record->lastname . ', ' . $record->firstname)->searchable()->sortable(),
                TextColumn::make('major')->label('MAJOR')->searchable()->sortable(),
                TextColumn::make('section')->label('SECTION')->searchable()->sortable(),


                ViewColumn::make('statuss')->label('ACTIONS')->view('filament.tables.actions'),
                ViewColumn::make('status')->label('STATUS')->view('filament.tables.status'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('approve')->label('Approve')->icon('heroicon-o-hand-thumb-up')->color('success')->action(
                        function ($record) {
                            $record->user->update([
                                'is_approved' => true,
                            ]);
                        }
                    ),
                    Action::make('reject')->label('Reject')->icon('heroicon-o-hand-thumb-down')->color('danger'),
                ])->visible(fn($record) => $record->user->is_approved == false)
            ])
            ->bulkActions([
            ]);
    }

    public function viewStudent($id)
    {
        $data = Student::where('id', $id)->first();
        $this->student = [
            'lastname' => $data->lastname,
            'firstname' => $data->firstname,
            'middlename' => $data->middlename,
            'address' => $data->address,
            'major' => $data->major,
            'id' => $data->student_id,
            'section' => $data->section,
            'contact' => $data->student_contact,
            'email' => $data->user->email,
            'guardian' => $data->guardian_name,
            'guardian_contact' => $data->guardian_contact,
            'course' => $data->course->name,
        ];
        $this->dispatch('open-modal', id: 'view-user');


    }

    public function dropStudent($id)
    {
        $student = Student::where('id', $id)->first();
        $student->update([
            'status' => 'dropped',
        ]);
    }

    public function render()
    {
        return view('livewire.coordinator.class-list');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('supervisor_id')->label('Supervisor')->options(Supervisor::all()->pluck('company_name', 'id'))

            ]);
    }

    public function deployStudent($id)
    {
        $this->student_id = $id;
        $this->openModal = true;

    }

    public function deployNow()
    {
        Trainee::create([
            'student_id' => $this->student_id,
            'supervisor_id' => $this->supervisor_id,
        ]);

        $student = Student::where('id', $this->student_id)->first();
        $student->update([
            'status' => 'deployed',
        ]);

        $this->openModal = false;
    }

}
