<?php

namespace App\Livewire\Supervisor;

use App\Models\Trainee;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AttendanceList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Trainee::query()->where('supervisor_id', auth()->user()->supervisor->id))->headerActions([
                Action::make('manage_absent')->label('Manage Absents')->icon('heroicon-o-adjustments-horizontal')->iconPosition(IconPosition::After)->url(fn() => route('supervisor.absents'))
            ])
            ->columns([
                TextColumn::make('student.student_id')->label('STUDENT ID')->searchable()->sortable(),
                TextColumn::make('id')->label('FULLNAME')->formatStateUsing(fn($record) => $record->student->lastname.', '. $record->student->firstname )->searchable()->sortable(),
                TextColumn::make('student.section')->label('SECTION')->searchable()->sortable(),
                TextColumn::make('student.id')->label('SPENT')->searchable()->sortable()->formatStateUsing(
                    function($record){
                        return $record->dailyTimeRecords->where('status', 'Approved')->sum('total_hours');
                    }
                ),
                TextColumn::make('student_id')->label('REMAINING')->searchable()->sortable()->formatStateUsing(
                    function($record){
                        $approved_dtr = $record->dailyTimeRecords->where('status', 'Approved')->sum('total_hours');
                        return 400 - $approved_dtr;
                    }
                ),
            ])
            ->filters([
                // ...
            ])
            ->actions([
             Action::make('view')->label('View DTR')->button()->color('warning')->icon('heroicon-o-eye')->outlined()->url(fn ($record): string => route('supervisor.view_attendance', ['id' => $record->id]))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.supervisor.attendance-list');
    }
}
