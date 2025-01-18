<?php

namespace App\Livewire\Auth;

use App\Models\Course;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Livewire\Component;

class RegisterUser extends Component
{
    public string $firstname, $middlename, $lastname, $course_id, $major, $section, $student_id, $institutional_email, $address, $student_contact, $guardian_name, $guardian_contact, $password;
    public $contact_no, $company_name, $company_address, $email;  
    public function render()
    {
        return view('livewire.auth.register-user',[
            'courses' => Course::all(),
        ]);
    }

    protected $rules = [
        'firstname' =>'required',
    ];


    public function registerStudent(){
        
        $this->validate();
        
        $this->validate([
            'firstname' =>'required',
           'middlename' =>'required',
            'lastname' =>'required',
            'course_id' =>'required',
           'major' =>'required',
           'section' =>'required',
           'student_id' =>'required',
            'institutional_email' =>'required|email',
            'address' =>'required',
           'student_contact' =>'required',
            'guardian_name' =>'required',
            'guardian_contact' =>'required',
            'password' => 'required|min:8',
        ]);
        

        $user = User::create([
            'name' => $this->firstname. ' '. $this->lastname,
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

    public function registerSupervisor(){
        $this->validate([
            'firstname' =>'required',
            'lastname' =>'required',
            'company_name' =>'required',
            'company_address' =>'required',
            'contact_no' =>'required',
            'email' =>'required|email',
            'password' => 'required|min:8',
        ]);
        

        $user = User::create([
            'name' => $this->firstname. ' '. $this->lastname,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'user_type' => 'supervisor',
        ]);

        Supervisor::create([
            'user_id' => $user->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'middlename' => $this->middlename,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'contact_number' => $this->contact_no,
        ]);

        auth()->loginUsingId($user->id);
        sleep(4);

        return redirect()->route('dashboard');
    }
}
