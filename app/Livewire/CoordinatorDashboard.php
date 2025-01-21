<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\Student;
use App\Models\Trainee;
use Livewire\Component;

class CoordinatorDashboard extends Component
{
    public function render()
    {
        return view('livewire.coordinator-dashboard',[
            'trainee' => Trainee::whereHas('student', function($record){
                $record->where('course_id', auth()->user()->course_id);
            })->count(),
            'completed' => Trainee::whereHas('student', function($record){
                $record->where('course_id', auth()->user()->course_id);
            })->where('status', 'Completed')->count(),
            'dropped' => Student::where('course_id', auth()->user()->course_id)->where('status', 'dropped')->count(),
            'announcements' => Announcement::orderByDesc('created_at')->get()->take(6),
        ]);
    }
}
