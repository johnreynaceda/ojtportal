<?php

namespace App\Livewire\Coordinator;

use App\Models\UserLog;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserLogList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(UserLog::query())
            ->columns([
                TextColumn::make('user_type')->label('USER TYPE')->searchable(),
                TextColumn::make('username')->label('USER NAME'),
                TextColumn::make('date')->date()->label('DATE'),
                TextColumn::make('id')->label('TIME')->formatStateUsing(
                    fn($record) => Carbon::parse($record->date)->format('h:i A')
                ),
                TextColumn::make('activity')->label('ACTIVITY'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.user-log-list');
    }
}
