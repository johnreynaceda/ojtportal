<?php

namespace App\Livewire\Coordinator;

use App\Models\Student;
use App\Models\StudentRequirement;
use App\Models\UserLog;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ViewRequirement extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use WithFileUploads;

    public $student_id;
    public $student_name;

    public function mount()
    {
        $this->student_id = request('id');
        $this->student_name = Student::where('id', $this->student_id)->first()->user->name;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentRequirement::query()->where('student_id', $this->student_id))
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
                ActionGroup::make([
                    Action::make('approve')->label('Approve')->icon('heroicon-o-hand-thumb-up')->color('success')->action(
                        function ($record) {
                            $record->update([
                                'status' => 'approved'
                            ]);

                            UserLog::create([
                                'user_type' => auth()->user()->user_type,
                                'username' => auth()->user()->name,
                                'date' => Carbon::now(),
                                'activity' => 'Approve ' . $record->name . ' of ' . $record->student->user->name,
                            ]);
                        }
                    ),
                    Action::make('reject')->label('Reject')->icon('heroicon-o-hand-thumb-down')->color('danger')->action(
                        function ($record) {
                            $record->update([
                                'status' => 'rejected'
                            ]);

                            UserLog::create([
                                'user_type' => auth()->user()->user_type,
                                'username' => auth()->user()->name,
                                'date' => Carbon::now(),
                                'activity' => 'Reject ' . $record->name . ' of ' . $record->student->user->name,
                            ]);
                        }
                    ),
                ])->hidden(fn($record) => $record->status == 'approved')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.view-requirement');
    }
}
