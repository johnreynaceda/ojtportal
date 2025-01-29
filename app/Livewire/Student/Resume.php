<?php

namespace App\Livewire\Student;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Resume extends Component implements HasForms
{
    use InteractsWithForms;

    public $photo = [];
    public $email, $phone, $address, $social;
    public $hard_skill = [['skill' => '']];
    public $soft_skill = [['skill' => '']];
    public $education = [[]];
    public $preference = [[]];
    public $work = [[]];
    public $award = [[]];
    public $certificate  = [[]];
    public $objective;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Grid::make(4)->schema([
                    FileUpload::make('photo')->required(),
                Section::make('MY CONTACTS')
                    ->description('Fill all the required fields.')
                    ->schema([
                        TextInput::make('email')->required(),
                        TextInput::make('phone')->required(),
                        TextInput::make('address'),  
                        TextInput::make('social')->url(),  
                ])->columns(4),
                Section::make('HARD SKILLS')
                    ->description('Fill all the required fields.')
                    ->schema([
                        Repeater::make('hard_skill')->label('')->addActionLabel('Add Skill')
                ->schema([
                    TextInput::make('skill')->required(),
                
                    ])
                
                            ])->columns(2),
                Section::make('SOFT SKILLS')
                    ->description('Fill all the required fields.')
                    ->schema([
                        Repeater::make('soft_skill')->label('')->addActionLabel('Add Skill')
                ->schema([
                    TextInput::make('skill')->required(),
                
                    ])
                
                            ])->columns(2),
                Section::make('EDUCATION BACKGROUND')
                    ->description('Fill all the required fields.')
                    ->schema([
                        Repeater::make('education')->label('')->addActionLabel('Add another')
                ->schema([
                    TextInput::make('school_name')->columnSpan(2)->required(),
                    TextInput::make('degree')->required(),
                    TextInput::make('year')->numeric()->required(),
                
                    ])->columns(4)
                
                    ])->columns(1),
                Section::make('CHARACTER REFERENCES')
                    ->description('Fill all the required fields.')
                    ->schema([
                        Repeater::make('preference')->label('')->addActionLabel('Add another')
                ->schema([
                    TextInput::make('name')->columnSpan(2)->required(),
                    TextInput::make('relation')->required(),
                    TextInput::make('number')->numeric()->required(),
                
                    ])->columns(4)
                
                    ])->columns(1),
                Section::make('CAREER OBJECTIVES')
                    ->description('Fill all the required fields.')
                    ->schema([
                        Textarea::make('objective')->label('')
                    ])->columns(1),
                Section::make('WORK EXPERIENCE')
                    ->description('Fill all the required fields.')
                    ->schema([
                        Repeater::make('work')->label('')->addActionLabel('Add Experience')
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('type_of_work')->required(),
                    
                    DatePicker::make('date_from')->required(),
                    DatePicker::make('date_to'),
                    Checkbox::make('present'),
                    ])->columns(4),

                    Section::make('AWARDS')
                    ->description('Fill all the required fields.')
                    ->schema([
                        Repeater::make('award')->label('')->addActionLabel('Add Award')
                ->schema([
                    TextInput::make('award')->required(),
                    ])
                            ])->columns(2),
                    Section::make('CERTIFICATIONS')
                    ->description('Fill all the required fields.')
                    ->schema([
                        Repeater::make('certificate')->label('')->addActionLabel('Add Certificate')
                ->schema([
                    TextInput::make('certificate')->required(),
                    ])
                            ])->columns(2),
                    ])->columns(1),
                ]),
                
            ]);
    }

    public function submitRecord(){
        foreach ($this->photo as $key => $value) {
           \App\Models\Resume::create([
            'user_id' => auth()->user()->id,
            'contact' => json_encode(['email' => $this->email, 'phone' => $this->phone, 'address' => $this->address, 'social' => $this->social]),
            'hard_skill' => json_encode($this->hard_skill),
            'soft_skill' => json_encode($this->soft_skill),
            'education_background' => json_encode($this->education),
            'character_reference' => json_encode($this->preference),
            'career_objective' => $this->objective,
            'work_experience' => json_encode($this->work),
            'award' => json_encode($this->award),
            'certification' => json_encode($this->certificate),
            'photo' => $value->store('Resume', 'public')
           ]);
        }
    }

    public function render()
    {
        return view('livewire.student.resume');
    }
}
