<?php

namespace App\Livewire\Coordinator;

use App\Models\Shop\Product;
use App\Models\Student;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $viewData = false;

    public $user_data;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->where('user_type', '!=', 'coordinator'))
            ->columns([
                TextColumn::make('name')->label('NAME')->searchable()->sortable(),
                TextColumn::make('email')->label('EMAIL')->searchable()->sortable(),
                TextColumn::make('user_type')->label('USER TYPE')->searchable()->sortable()->formatStateUsing(
                    fn($record)=>  ucfirst($record->user_type)
                )->badge()->color(fn (string $state): string => match ($state) {
                    'student' => 'info',
                    'supervisor' => 'danger',
                }),
                   
                    ViewColumn::make('status')->label('ACTIONS')->view('filament.tables.actions')
            ])
            ->filters([
                SelectFilter::make('user_type')->options([
                    'student' => 'Student',
                    'supervisor' => 'Supervisor',
                ])
            ])
            ->actions([
                // ActionGroup::make([
                //     Action::make('approve')->label('Approve')->icon('heroicon-o-hand-thumb-up')->color('success')->action(
                //         function($record){
                //             $record->user->update([
                //                 'is_approved' => true,
                //             ]);
                //         }
                //     ),
                //     Action::make('reject')->label('Reject')->icon('heroicon-o-hand-thumb-down')->color('danger'),
                // ])->visible(fn($record) => $record->user->is_approved == false)
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function view($id){
        $this->viewData = true;
        $this->user_data = User::where('id', $id)->with('supervisor')->first();
    }

    public function updateStatus($id){
        $user = User::where('id', $id)->first();
        $user->update([
            'is_approved' => !$user->is_approved
        ]);
    }

    public function render()
    {
        return view('livewire.coordinator.user-list');
    }
}
