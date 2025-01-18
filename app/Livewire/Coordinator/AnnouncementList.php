<?php

namespace App\Livewire\Coordinator;

use App\Models\Announcement;
use App\Models\Shop\Product;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AnnouncementList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Announcement::query())->headerActions([
                CreateAction::make('new')->icon('heroicon-o-plus')->form([
                    Textarea::make('message')->required(),
                ])->modalWidth('xl')
            ])
            ->columns([
                TextColumn::make('message')->label('MESSAGE')->words(20)->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make('edit')->color('success'),
                DeleteAction::make('delete')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.coordinator.announcement-list');
    }
}
