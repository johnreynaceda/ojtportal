<?php

namespace App\Livewire\Coordinator;

use App\Models\Shop\Product;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Trainee;
use Filament\Forms\Components\Select;
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

class ClassList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $openModal = false;
    public $student_id;
    public $supervisor_id;

    public function table(Table $table): Table
    {
        return $table
            ->query(query: Student::query()->where('course_id', auth()->user()->course_id))
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
                // ...
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
                Select::make('supervisor_id')->label('Supervisor')->options(Supervisor::all()->pluck('company_name', 'id')),
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
