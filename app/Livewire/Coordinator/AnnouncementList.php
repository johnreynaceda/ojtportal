<?php

namespace App\Livewire\Coordinator;

use App\Models\Announcement;
use App\Models\Shop\Product;
use App\Models\UserLog;
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
use Illuminate\Support\Carbon;
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
                    ])->modalWidth('xl')->action(
                            function ($data) {
                                Announcement::create([
                                    'message' => $data['message'],
                                ]);

                                UserLog::create([
                                    'user_type' => auth()->user()->user_type,
                                    'username' => auth()->user()->name,
                                    'date' => Carbon::now(),
                                    'activity' => 'Post Announcement',
                                ]);
                            }
                        )
                ])
            ->columns([
                TextColumn::make('message')->label('MESSAGE')->words(20)->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([

                DeleteAction::make('delete')->action(
                    function ($record) {
                        $record->delete();

                        UserLog::create([
                            'user_type' => auth()->user()->user_type,
                            'username' => auth()->user()->name,
                            'date' => Carbon::now(),
                            'activity' => 'Delete Announcement',
                        ]);
                    }
                )
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
