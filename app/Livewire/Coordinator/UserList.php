<?php

namespace App\Livewire\Coordinator;

use App\Models\Coordinator;
use App\Models\Shop\Product;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use GuzzleHttp\Promise\Create;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $viewData = false;

    public $user_data;

    public $student = [];
    public $supervisor = [];
    public $supervisor_location;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->where('user_type', '!=', 'coordinator'))->headerActions([
                    Action::make('create_coordinator')
                        ->label('Create Coordinator')
                        ->icon('heroicon-o-plus')->form([
                                Grid::make(3)->schema([
                                    TextInput::make('firstname')->label('First Name')->required(),
                                    TextInput::make('middlename')->label('Middle Name')->required(),
                                    TextInput::make('lastname')->label('Last Name')->required(),
                                ]),
                                Grid::make(2)->schema([
                                    // Select::make('course_handle')->label('Major Handle')->options([
                                    //     'Intelligent System' => 'Intelligent System',
                                    //     'Graphics and Visualization' => 'Graphics and Visualization',
                                    //     'Animation and Motion Graphics' => 'Animation and Motion Graphics',
                                    //     'Network Administration' => 'Network Administration',
                                    //     'Service Management Program' => 'Service Management Program',
                                    //     'Web and Mobile Application Development' => 'Web and Mobile Application Development',
                                    // ]),
                                    TextInput::make('contact_number')->label('Contact Number')->numeric()->required(),

                                    TextInput::make('email')->label('Email')->email()->required(),
                                    TextInput::make('password')->label('Password')->password()->required(),
                                ]),
                            ])->modalWidth('2xl')->action(
                            function ($data) {
                                $user = User::create([
                                    'name' => $data['firstname'] . ' ' . $data['lastname'],
                                    'email' => $data['email'],
                                    'password' => bcrypt($data['password']),
                                    'user_type' => 'coordinator',
                                    'is_approved' => true,
                                    'course_id' => auth()->user()->course_id,
                                ]);
                                Coordinator::create([
                                    'user_id' => $user->id,
                                    'firstname' => $data['firstname'],
                                    'lastname' => $data['lastname'],
                                    'middlename' => $data['middlename'],
                                    'course_handle' => $data['course_handle'],
                                    'contact_number' => $data['contact_number'],
                                ]);
                            }
                        )
                ])
            ->columns([
                TextColumn::make('name')->label('NAME')->searchable()->sortable(),
                TextColumn::make('email')->label('EMAIL')->searchable()->sortable(),
                TextColumn::make('user_type')->label('USER TYPE')->searchable()->sortable()->formatStateUsing(
                    fn($record) => ucfirst($record->user_type)
                )->badge()->color(fn(string $state): string => match ($state) {
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
    public function view($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->user_type == 'student') {
            $data = Student::where('id', $user->student->id)->first();
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
        } else {

            $data = Supervisor::where('id', $user->supervisor->id)->first();
            $this->supervisor = [
                'lastname' => $data->lastname,
                'firstname' => $data->firstname,
                'middlename' => $data->middlename,
                'company_name' => $data->company_name,
                'contact' => $data->contact_number,
                'companyAddress' => $data->company_address,
            ];

            $this->supervisor_location = $data->locattion_path;

            $this->dispatch('open-modal', id: 'view-supervisor');
        }

    }

    public function updateStatus($id)
    {
        $user = User::where('id', $id)->first();
        $user->update([
            'is_approved' => !$user->is_approved
        ]);
        if ($user->user_type == 'student') {
            $user->student->update([
                'coordinator_id' => $user->is_approved ? auth()->user()->coordinator->id : null,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.coordinator.user-list');
    }
}
