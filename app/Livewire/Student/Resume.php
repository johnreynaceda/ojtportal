<?php

namespace App\Livewire\Student;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\ViewField;
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
    public $image;
    public $email, $phone, $address, $social;
    public $hard_skill = [];
    public $soft_skills = [];
    public $education = [[]];
    public $preference = [[]];
    public $work;
    public $award;
    public $certificate;

    public $edit_resume = false;

    public $file = [];
    public $objective;



    public function edit()
    {
        $data = \App\Models\Resume::where('user_id', auth()->user()->id)->first();
        $contact = json_decode($data->contact, true);

        $this->email = $contact['email'];
        $this->phone = $contact['phone'];
        $this->address = $contact['address'];
        $this->social = $contact['social'];
        $this->hard_skill = json_decode($data->hard_skill, true);
        $this->soft_skills = json_decode($data->soft_skill, true);
        $this->education = json_decode($data->education, true);
        $this->preference = json_decode($data->preference, true);
        $this->objective = $data->career_objective;
        $this->work = json_decode($data->work_experience, true);
        $this->award = json_decode($data->award, true);
        $this->certificate = json_decode($data->certification, true);
        $this->image = $data->photo;
        $this->edit_resume = true;

    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)->schema([
                    FileUpload::make('photo')
                        ->required()
                        ->hidden(fn() => $this->edit_resume == true),
                    ViewField::make('rating')
                        ->view('filament.forms.resume-image')->hidden(fn() => $this->edit_resume == false),
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
                            Select::make('hard_skill')->multiple()->options([
                                'Debugging' => 'Debugging',
                                'Testing' => 'Testing',
                                'Computer programs' => 'Computer programs',
                                'Programming' => 'Programming',
                                'Microsoft Excel' => 'Microsoft Excel',
                                'MS Excel' => 'MS Excel',
                                'Microsoft Office' => 'Microsoft Office',
                                'Software Development' => 'Software Development',
                                'HTML' => 'HTML',
                                'Retention' => 'Retention',
                                'SQL' => 'SQL',
                                'Modeling' => 'Modeling',
                                'Analytics' => 'Analytics',
                                'Apache' => 'Apache',
                                'Apache Airflow' => 'Apache Airflow',
                                'Apache Impala' => 'Apache Impala',
                                'Apache Drill' => 'Apache Drill',
                                'Apache Hadoop' => 'Apache Hadoop',
                                'Data Collection' => 'Data Collection',
                                'Business Requirements' => 'Business Requirements',
                                'Data Mining' => 'Data Mining',
                                'Data Science' => 'Data Science',
                                'Visualization' => 'Visualization',
                                'Technical Guidance' => 'Technical Guidance',
                                'Client Analytics' => 'Client Analytics',
                                'Programming Skills' => 'Programming Skills',
                                'Sql Server' => 'Sql Server',
                                'Computer Science' => 'Computer Science',
                                'Statistical Modeling' => 'Statistical Modeling',
                                'Applied Data Science' => 'Applied Data Science',
                                'Hiring' => 'Hiring',
                                'Technical' => 'Technical',
                                'Database' => 'Database',
                                'R' => 'R',
                                'C' => 'C',
                                'C++' => 'C++',
                                'C#' => 'C#',
                                'Ruby' => 'Ruby',
                                'Ruby on Rails' => 'Ruby on Rails',
                                'Weka' => 'Weka',
                                'Matlab' => 'Matlab',
                                'Django' => 'Django',
                                'NetBeans' => 'NetBeans',
                                'IDE' => 'IDE',
                                'stochastic' => 'stochastic',
                                'Marketing' => 'Marketing',
                                'Mining' => 'Mining',
                                'Mathematics' => 'Mathematics',
                                'Forecasts' => 'Forecasts',
                                'Statistics' => 'Statistics',
                                'Python' => 'Python',
                                'Microsoft Sql Server' => 'Microsoft Sql Server',
                                'NoSql' => 'NoSql',
                                'Hadoop' => 'Hadoop',
                                'Spark' => 'Spark',
                                'Java' => 'Java',
                                'Numpy' => 'Numpy',
                                'Pandas' => 'Pandas',
                                'Scikit' => 'Scikit',
                                'clustering' => 'clustering',
                                'classification' => 'classification',
                                'neural networks' => 'neural networks',
                                'neural network' => 'neural network',
                                'tensorflow' => 'tensorflow',
                                'pytorch' => 'pytorch',
                                'theano' => 'theano',
                                'keras' => 'keras',
                                'Pig' => 'Pig',
                                'Adaboost' => 'Adaboost',
                                'Statistical analysis' => 'Statistical analysis',
                                'machine learning' => 'machine learning',
                                'data mining' => 'data mining',
                                'data science' => 'data science',
                                'data analytics' => 'data analytics',
                                'regression' => 'regression',
                                'kmeans' => 'kmeans',
                                'k-means' => 'k-means',
                                'kNN' => 'kNN',
                                'Bayes' => 'Bayes',
                                'Bayesian Probability' => 'Bayesian Probability',
                                'Bayesian Estimation' => 'Bayesian Estimation',
                                'Bayesian Network' => 'Bayesian Network',
                                'Forest' => 'Forest',
                                'Random Forest' => 'Random Forest',
                                'Decision Tree' => 'Decision Tree',
                                'Matrix' => 'Matrix',
                                'Matrix Factorization' => 'Matrix Factorization',
                                'SVD' => 'SVD',
                                'Outlier' => 'Outlier',
                                'Outlier detection' => 'Outlier detection',
                                'Regression Analysis' => 'Regression Analysis',
                                'Frequent Itemset Mining' => 'Frequent Itemset Mining',
                                'Classification Analysis' => 'Classification Analysis',
                                'Backpropagation' => 'Backpropagation',
                                'LogitBoost' => 'LogitBoost',
                                'Time Series' => 'Time Series',
                                'Dynamic programming' => 'Dynamic programming',
                                'Clustering' => 'Clustering',
                                'Classification' => 'Classification',
                                'Algorithms' => 'Algorithms',
                                'Application Development' => 'Application Development',
                                'AWS' => 'AWS',
                                'AWS Glue' => 'AWS Glue',
                                'Architecture' => 'Architecture',
                                'AROS' => 'AROS',
                                'Ars Based Programming' => 'Ars Based Programming',
                                'Aspect Oriented Programming' => 'Aspect Oriented Programming',
                                'CASE Tools' => 'CASE Tools',
                                'Coding' => 'Coding',
                                'Computer Platforms' => 'Computer Platforms',
                                'Computational complexity' => 'Computational complexity',
                                'Constraint-based Programming' => 'Constraint-based Programming',
                                'Customer Service' => 'Customer Service',
                                'Database Management Systems' => 'Database Management Systems',
                                'Database Techniques' => 'Database Techniques',
                                'Data Analytics' => 'Data Analytics',
                                'Data Structures' => 'Data Structures',
                                'Design' => 'Design',
                                'Design Patterns' => 'Design Patterns',
                                'Development' => 'Development',
                                'Development Tools' => 'Development Tools',
                                'Distributed Computing' => 'Distributed Computing',
                                'Documentation' => 'Documentation',
                                'Embedded Hardware' => 'Embedded Hardware',
                                'Emerging Technologies' => 'Emerging Technologies',
                                'Hardware' => 'Hardware',
                                'HTML Authoring Tools' => 'HTML Authoring Tools',
                                'HTML Conversion Tools' => 'HTML Conversion Tools',
                                'Industry Systems' => 'Industry Systems',
                                'iOS' => 'iOS',
                                'Linux' => 'Linux',
                                'MacOS' => 'MacOS',
                                'Mobile' => 'Mobile',
                                'Multimedia' => 'Multimedia',
                                'MXNet' => 'MXNet',
                                'Object oriented programming' => 'Object oriented programming',
                                'object oriented' => 'object oriented',
                                'Operating Systems' => 'Operating Systems',
                                'Organizational' => 'Organizational',
                                'OS Programming' => 'OS Programming',
                                'Post Object Programming' => 'Post Object Programming',
                                'Presto' => 'Presto',
                                'Problem Solving' => 'Problem Solving',
                                'Programming Languages' => 'Programming Languages',
                                'Programming Methodologies' => 'Programming Methodologies',
                                'Quality Control' => 'Quality Control',
                                'Relational Databases' => 'Relational Databases',
                                'Relational Programming' => 'Relational Programming',
                                'Reporting' => 'Reporting',
                                'Revision Control' => 'Revision Control',
                                'Software' => 'Software',
                                'Structured Query Language (SQL)' => 'Structured Query Language (SQL)',
                                'System Architecture' => 'System Architecture',
                                'System Development' => 'System Development',
                                'System Design' => 'System Design',
                                'System Programming' => 'System Programming',
                                'System Testing' => 'System Testing',
                                'Troubleshooting' => 'Troubleshooting',
                                'UNIX' => 'UNIX',
                                'Web' => 'Web',
                                'Web Applications' => 'Web Applications',
                                'Web Platforms' => 'Web Platforms'
                            ])
                                ->searchable(),
                        ])->columns(1),
                    Section::make('SOFT SKILLS')
                        ->description('Fill all the required fields.')
                        ->schema([
                            Select::make('soft_skills')
                                ->label('Soft Skills')
                                ->multiple()
                                ->searchable()
                                ->options([
                                    'abstract thinking' => 'abstract thinking',
                                    'accurate' => 'accurate',
                                    'achieving goals' => 'achieving goals',
                                    'active person' => 'active person',
                                    'active personality' => 'active personality',
                                    'advocacy skills' => 'advocacy skills',
                                    'ambitious' => 'ambitious',
                                    'assertive' => 'assertive',
                                    'assertiveness' => 'assertiveness',
                                    'autonomy' => 'autonomy',
                                    'calm' => 'calm',
                                    'character' => 'character',
                                    'client relationships' => 'client relationships',
                                    'coaching' => 'coaching',
                                    'conceptual thinking' => 'conceptual thinking',
                                    'confident personality' => 'confident personality',
                                    'conflict management' => 'conflict management',
                                    'curious' => 'curious',
                                    'customer orientation' => 'customer orientation',
                                    'decision maker' => 'decision maker',
                                    'delegation skills' => 'delegation skills',
                                    'diplomacy skills' => 'diplomacy skills',
                                    'dynamic person' => 'dynamic person',
                                    'enthusiastic personality' => 'enthusiastic personality',
                                    'hard worker' => 'hard worker',
                                    'independent worker' => 'independent worker',
                                    'initiative person' => 'initiative person',
                                    'innovative thinking' => 'innovative thinking',
                                    'judgment skills' => 'judgment skills',
                                    'leadership ability' => 'leadership ability',
                                    'learn quickly' => 'learn quickly',
                                    'learning skills' => 'learning skills',
                                    'listening skills' => 'listening skills',
                                    'make decisions' => 'make decisions',
                                    'memory skills' => 'memory skills',
                                    'multitask oriented' => 'multitask oriented',
                                    'oral skills' => 'oral skills',
                                    'organized person' => 'organized person',
                                    'outgoing personality' => 'outgoing personality',
                                    'outgoing' => 'outgoing',
                                    'people oriented' => 'people oriented',
                                    'personal commitment' => 'personal commitment',
                                    'personal integrity' => 'personal integrity',
                                    'problem solver' => 'problem solver',
                                    'problem solving' => 'problem solving',
                                    'problemsolving' => 'problemsolving',
                                    'professional attitude' => 'professional attitude',
                                    'selfconfident' => 'selfconfident',
                                    'selflearner' => 'selflearner',
                                    'selflearning' => 'selflearning',
                                    'sociable personality' => 'sociable personality',
                                    'solution oriented' => 'solution oriented',
                                    'strategic planning' => 'strategic planning',
                                    'supervision skills' => 'supervision skills',
                                    'sympathy' => 'sympathy',
                                    'systematic' => 'systematic',
                                    'team builder' => 'team builder',
                                    'teamwork approach' => 'teamwork approach',
                                    'teamworker' => 'teamworker',
                                    'tolerant' => 'tolerant',
                                    'work ethics' => 'work ethics',
                                    'polite manners' => 'polite manners',
                                    'organizational skills' => 'organizational skills',
                                    'work collaboratively' => 'work collaboratively',
                                    'communicator' => 'communicator',
                                    'accountability' => 'accountability',
                                    'mentoring skills' => 'mentoring skills',
                                    'communicative' => 'communicative',
                                    'reliable personality' => 'reliable personality',
                                    'goal oriented' => 'goal oriented',
                                    'educational skills' => 'educational skills',
                                    'skilled negotiator' => 'skilled negotiator',
                                    'monitoring skills' => 'monitoring skills',
                                    'reliable' => 'reliable',
                                    'sales driven' => 'sales driven',
                                    'international outlook' => 'international outlook',
                                    'dedicated person' => 'dedicated person',
                                    'communicate easily' => 'communicate easily',
                                    'discretion' => 'discretion',
                                    'relationship builder' => 'relationship builder',
                                    'self confidence' => 'self confidence',
                                    'self driven' => 'self driven',
                                    'imagination' => 'imagination',
                                    'organized' => 'organized',
                                    'responsible' => 'responsible',
                                    'counselling skills' => 'counselling skills',
                                    'analytical thinking' => 'analytical thinking',
                                    'political awareness' => 'political awareness',
                                    'motivation' => 'motivation',
                                    'consulting skills' => 'consulting skills',
                                    'creativity thinking' => 'creativity thinking',
                                    'initiative thinking' => 'initiative thinking',
                                    'ingenuity' => 'ingenuity',
                                    'versatility' => 'versatility',
                                    'leadership' => 'leadership',
                                    'positive attitude' => 'positive attitude',
                                    'analytic skills' => 'analytic skills',
                                    'people skills' => 'people skills',
                                    'mature personality' => 'mature personality',
                                    'proactive' => 'proactive',
                                    'correct reporting' => 'correct reporting',
                                    'intercultural skills' => 'intercultural skills',
                                    'interpretation skills' => 'interpretation skills',
                                    'reporting skills' => 'reporting skills',
                                    'self starter' => 'self starter',
                                    'timemanagement skills' => 'timemanagement skills',
                                    'open minded' => 'open minded',
                                    'supervisory skills' => 'supervisory skills',
                                    'personable' => 'personable',
                                    'self starters' => 'self starters',
                                    'presonal initiative' => 'presonal initiative',
                                    'self motivated' => 'self motivated',
                                    'managing skills' => 'managing skills',
                                    'management skill' => 'management skill',
                                    'energetic' => 'energetic',
                                    'negotiation skills' => 'negotiation skills',
                                    'diplomatic manner' => 'diplomatic manner',
                                    'judgement skills' => 'judgement skills',
                                    'initiative' => 'initiative',
                                    'results oriented' => 'results oriented',
                                    'telephone skills' => 'telephone skills',
                                    'speaking ability' => 'speaking ability',
                                    'creative thinking' => 'creative thinking',
                                    'team player' => 'team player',
                                    'communicating skills' => 'communicating skills',
                                    'diplomacy' => 'diplomacy',
                                    'communication skill' => 'communication skill',
                                    'facilitating skills' => 'facilitating skills',
                                    'self organized' => 'self organized',
                                    'meeting deadlines' => 'meeting deadlines',
                                    'communications skills' => 'communications skills',
                                    'analytical skills' => 'analytical skills',
                                    'problemsolving attitude' => 'problemsolving attitude',
                                    'sensitivity' => 'sensitivity',
                                    'personality skills' => 'personality skills',
                                    'confident' => 'confident',
                                    'attractive personality' => 'attractive personality',
                                    'enthusiasm' => 'enthusiasm',
                                    'quick learner' => 'quick learner',
                                    'work ethic' => 'work ethic',
                                    'action oriented' => 'action oriented',
                                    'leadership skills' => 'leadership skills',
                                    'proactive approach' => 'proactive approach',
                                    'time management' => 'time management',
                                    'polite' => 'polite',
                                    'methodical' => 'methodical',
                                    'managing tasks' => 'managing tasks',
                                    'results orientation' => 'results orientation',
                                    'flexible' => 'flexible',
                                    'responsible person' => 'responsible person',
                                    'creativity' => 'creativity',
                                    'self confident' => 'self confident',
                                    'training skills' => 'training skills',
                                    'motivated' => 'motivated',
                                    'diplomatic' => 'diplomatic',
                                    'conceptualization skills' => 'conceptualization skills',
                                    'verbal skills' => 'verbal skills',
                                    'organizational capabilities' => 'organizational capabilities',
                                    'attentive' => 'attentive',
                                    'organization skills' => 'organization skills',
                                    'courteous manner' => 'courteous manner',
                                    'detailed oriented' => 'detailed oriented',
                                    'administrative skills' => 'administrative skills',
                                    'humor' => 'humor',
                                    'flexibility' => 'flexibility',
                                    'analysis skills' => 'analysis skills',
                                    'teamwork' => 'teamwork',
                                    'facilitation skills' => 'facilitation skills',
                                    'dynamic personality' => 'dynamic personality',
                                    'team oriented' => 'team oriented',
                                    'deadline oriented' => 'deadline oriented',
                                    'openminded' => 'openminded',
                                    'professional manner' => 'professional manner',
                                    'professional presentation' => 'professional presentation',
                                    'analytical mind' => 'analytical mind',
                                    'cheerful personality' => 'cheerful personality',
                                    'critical thinking' => 'critical thinking',
                                    'hard working' => 'hard working',
                                    'self initiative' => 'self initiative',
                                    'take initiative' => 'take initiative',
                                    'result oriented' => 'result oriented',
                                    'innovative' => 'innovative',
                                    'organizing skills' => 'organizing skills',
                                    'interpersonal skills' => 'interpersonal skills',
                                    'self awareness' => 'self awareness',
                                    'team commitment' => 'team commitment',
                                    'presentation skills' => 'presentation skills',
                                    'systematic manner' => 'systematic manner',
                                    'cooperation skills' => 'cooperation skills',
                                    'client oriented' => 'client oriented',
                                    'client orientation' => 'client orientation',
                                    'self motivation' => 'self motivation',
                                    'creative' => 'creative',
                                    'results driven' => 'results driven',
                                    'positive' => 'positive',
                                    'tactful manner' => 'tactful manner',
                                    'coordination skills' => 'coordination skills',
                                    'tactful' => 'tactful',
                                    'responsible personality' => 'responsible personality',
                                    'reasoning skills' => 'reasoning skills',
                                    'team worker' => 'team worker',
                                    'dedication' => 'dedication',
                                    'sound judgment' => 'sound judgment',
                                    'goals oriented' => 'goals oriented',
                                    'organisational skills' => 'organisational skills',
                                    'marketing skills' => 'marketing skills',
                                    'managerial ability' => 'managerial ability',
                                    'professionalism' => 'professionalism',
                                    'problemsolving skills' => 'problemsolving skills',
                                    'detail oriented' => 'detail oriented',
                                    'influencing skills' => 'influencing skills',
                                    'teambuilding skills' => 'teambuilding skills',
                                    'courteous' => 'courteous',
                                    'client skills' => 'client skills',
                                    'innovativeness' => 'innovativeness',
                                    'wellorganized' => 'wellorganized',
                                    'creative imagination' => 'creative imagination',
                                    'listen skills' => 'listen skills',
                                    'analytical abilities' => 'analytical abilities',
                                    'logical abilities' => 'logical abilities',
                                    'maturity' => 'maturity',
                                    'social skills' => 'social skills',
                                    'respectful' => 'respectful',
                                    'teamwork skills' => 'teamwork skills',
                                    'punctual' => 'punctual',
                                    'managerial skills' => 'managerial skills',
                                    'management skills' => 'management skills',
                                    'accuracy' => 'accuracy',
                                    'scheduling skills' => 'scheduling skills',
                                    'constructive feedback' => 'constructive feedback',
                                    'well organized' => 'well organized',
                                    'conceptual skills' => 'conceptual skills',
                                    'hardworking' => 'hardworking',
                                    'empathy' => 'empathy',
                                    'ambitious personality' => 'ambitious personality',
                                    'lively personality' => 'lively personality',
                                    'punctuality' => 'punctuality',
                                    'creative approach' => 'creative approach',
                                    'organizer' => 'organizer',
                                    'self directed' => 'self directed',
                                    'initiative driven' => 'initiative driven',
                                    'goaloriented' => 'goaloriented',
                                    'cultural sensitivity' => 'cultural sensitivity',
                                    'friendly personality' => 'friendly personality',
                                    'responsable' => 'responsable',
                                    'patience' => 'patience',
                                    'communication skills' => 'communication skills',
                                    'enthusiastic' => 'enthusiastic',
                                    'judgment' => 'judgment',
                                    'coordinating skills' => 'coordinating skills',
                                    'motivating' => 'motivating',
                                    'disciplined' => 'disciplined',
                                    'articulate' => 'articulate',
                                    'organising skills' => 'organising skills',
                                    'responsibility' => 'responsibility',
                                    'team spirit' => 'team spirit',
                                    'planning skills' => 'planning skills',
                                    'coaching skills' => 'coaching skills',
                                    'tact' => 'tact',
                                    'diligent' => 'diligent',
                                    'hardworker' => 'hardworker',
                                    'service mentality' => 'service mentality',
                                    'prioritization skills' => 'prioritization skills',
                                    'negotiator' => 'negotiator',
                                    'communication abilities' => 'communication abilities',
                                    'professional personality' => 'professional personality',
                                    'strategic thinking' => 'strategic thinking',
                                    'quality minded' => 'quality minded',
                                    'public speaking' => 'public speaking',
                                    'self learning' => 'self learning',
                                    'forward thinker' => 'forward thinker',
                                    'team management' => 'team management',
                                    'personal management' => 'personal management',
                                    'staff management' => 'staff management',
                                    'people management' => 'people management',
                                    'project management' => 'project management',
                                    'be creative' => 'be creative',
                                    'multitasking skills' => 'multitasking skills',
                                    'quick learning' => 'quick learning',
                                    'proposal writing' => 'proposal writing',
                                ])
                                ->searchable()

                        ])->columns(1),
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
                                    TextInput::make('name'),
                                    TextInput::make('type_of_work'),

                                    DatePicker::make('date_from'),
                                    DatePicker::make('date_to'),
                                    Checkbox::make('present'),
                                ])->columns(4),

                            Section::make('AWARDS')
                                ->description('Fill all the required fields.')
                                ->schema([
                                    Repeater::make('award')->label('')->addActionLabel('Add Award')
                                        ->schema([
                                            TextInput::make('award'),
                                        ])
                                ])->columns(2),
                            Section::make('CERTIFICATIONS')
                                ->description('Fill all the required fields.')
                                ->schema([
                                    Repeater::make('certificate')->label('')->addActionLabel('Add Certificate')
                                        ->schema([
                                            TextInput::make('certificate'),
                                        ])
                                ])->columns(2),
                        ])->columns(1),
                ]),

            ]);
    }

    public function submitRecord()
    {
        foreach ($this->photo as $key => $value) {
            \App\Models\Resume::create([
                'user_id' => auth()->user()->id,
                'contact' => json_encode(['email' => $this->email, 'phone' => $this->phone, 'address' => $this->address, 'social' => $this->social]),
                'hard_skill' => json_encode($this->hard_skill),
                'soft_skill' => json_encode($this->soft_skills),
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

    public function updateResume()
    {
        \App\Models\Resume::where('user_id', auth()->user()->id)->update([
            'user_id' => auth()->user()->id,
            'contact' => json_encode(['email' => $this->email, 'phone' => $this->phone, 'address' => $this->address, 'social' => $this->social]),
            'hard_skill' => json_encode($this->hard_skill),
            'soft_skill' => json_encode($this->soft_skills),
            'education_background' => json_encode($this->education),
            'character_reference' => json_encode($this->preference),
            'career_objective' => $this->objective,
            'work_experience' => json_encode($this->work),
            'award' => json_encode($this->award),
            'certification' => json_encode($this->certificate),
        ]);

        $this->edit_resume = false;
        $this->image == null;
    }

    public function render()
    {
        return view('livewire.student.resume');
    }
}

