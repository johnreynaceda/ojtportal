<?php

namespace App\Livewire\Auth;

use App\Models\Course;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RegisterUser extends Component implements HasForms
{
    use InteractsWithForms;
    public string $firstname, $middlename, $lastname, $course_id, $major, $section, $student_id, $institutional_email, $address, $student_contact, $guardian_name, $guardian_contact, $password;
    public $contact_no, $company_name, $company_address, $email;

    public $hard_skill = [], $soft_skills = [], $internship_location, $internship_arrangement, $work_experience;

    public $file = [];


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Job requirements')->columns(1)->schema([
                    Select::make('hard_skill')->multiple()->options([
                        'html' => 'HTML',
                        'css' => 'CSS',
                        'javascript' => 'JavaScript',
                        'php' => 'PHP',
                        'python' => 'Python',
                        'java' => 'Java',
                        'c++' => 'C++',
                        'sql' => 'SQL',
                        'laravel' => 'Laravel',
                        'react' => 'React',
                        'vue' => 'Vue.js',
                        'node' => 'Node.js',
                        'docker' => 'Docker',
                        'git' => 'Git',
                        'aws' => 'AWS',
                        'azure' => 'Azure',
                        'linux' => 'Linux',
                        'figma' => 'Figma',
                        'wordpress' => 'WordPress',
                    ])
                        ->searchable(),
                    Select::make('soft_skills')
                        ->label('Soft Skills')
                        ->multiple()
                        ->options([
                            'communication' => 'Communication',
                            'problem_solving' => 'Problem Solving',
                            'teamwork' => 'Teamwork',
                            'adaptability' => 'Adaptability',
                            'critical_thinking' => 'Critical Thinking',
                            'time_management' => 'Time Management',
                            'creativity' => 'Creativity',
                            'leadership' => 'Leadership',
                            'attention_to_detail' => 'Attention to Detail',
                            'emotional_intelligence' => 'Emotional Intelligence',
                            'conflict_resolution' => 'Conflict Resolution',
                            'work_ethic' => 'Work Ethic',
                            'collaboration' => 'Collaboration',
                            'decision_making' => 'Decision Making',
                            'self_motivation' => 'Self-Motivation',
                        ])
                        ->searchable()
                ]),
                Grid::make(2)->schema([
                    Radio::make('work_experience')
                        ->label('Work Experience Required?')
                        ->options([
                            'yes' => 'yes',
                            'no' => 'no',
                        ])->inline()
                        ->inlineLabel(false),
                    Radio::make('internship_location')
                        ->label('Internship Location')
                        ->options([
                            'LSPU' => 'LSPU',
                            'outside' => 'outside',
                        ])->inline()
                        ->inlineLabel(false),
                ]),
                Radio::make('internship_arrangement')
                    ->label('Internship Arrangement')
                    ->options([
                        'On-site' => 'On-site',
                        'Remote' => 'Remote',
                        'Hybrid' => 'Hybrid',
                    ])->inline()
                    ->inlineLabel(false),
            ]);
    }

    public function render()
    {
        return view('livewire.auth.register-user', [
            'courses' => Course::all(),
        ]);
    }

    protected $rules = [
        'firstname' => 'required',
    ];


    public function registerStudent()
    {


        $this->validate();

        $this->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'course_id' => 'required',
            'major' => 'required',
            'section' => 'required',
            'student_id' => 'required',
            'institutional_email' => 'required|email',
            'address' => 'required',
            'student_contact' => 'required',
            'guardian_name' => 'required',
            'guardian_contact' => 'required',
            'password' => 'required|min:8',
        ]);




        $user = User::create([
            'name' => $this->firstname . ' ' . $this->lastname,
            'email' => $this->institutional_email,
            'password' => bcrypt($this->password),
            'user_type' => 'student',
            'course_id' => $this->course_id,
        ]);

        Student::create([
            'user_id' => $user->id,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'major' => $this->major,
            'section' => $this->section,
            'course_id' => $this->course_id,
            'student_id' => $this->student_id,
            'address' => $this->address,
            'student_contact' => $this->student_contact,
            'guardian_name' => $this->guardian_name,
            'guardian_contact' => $this->guardian_contact,
        ]);

        auth()->loginUsingId($user->id);
        sleep(4);

        return redirect()->route('dashboard');
    }

    public function registerSupervisor()
    {

        $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'company_name' => 'required',
            'company_address' => 'required',
            'contact_no' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);


        $user = User::create([
            'name' => $this->firstname . ' ' . $this->lastname,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'user_type' => 'supervisor',
        ]);

        $data = [
            'hardskill' => $this->hard_skill,
            'softskill' => $this->soft_skills,
            'work_experience' => $this->work_experience,
            'internship_location' => $this->internship_location,
            'internship_arrangement' => $this->internship_arrangement,
        ];


        $super = Supervisor::create([
            'user_id' => $user->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'middlename' => $this->middlename,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'contact_number' => $this->contact_no,
            'job_requirements' => json_encode($data),
        ]);

        foreach ($this->file as $key => $value) {
            $super->update([
                'location_path' => $value->store('supervisor', 'public'),
            ]);
        }

        auth()->loginUsingId($user->id);
        sleep(4);

        return redirect()->route('dashboard');
    }
}
