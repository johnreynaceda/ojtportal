<?php

namespace App\Livewire;

use App\Models\Absent;
use App\Models\Announcement;
use App\Models\Task;
use Livewire\Component;

class StudentDashboard extends Component
{
    public function render()
    {
        return view('livewire.student-dashboard',[
            'announcements' => Announcement::orderByDesc('created_at')->get()->take(6),
            'tasks' => auth()->user()->student->trainee == null ? 0 : Task::whereHas('taskAssignedStudents', function($record){
                $record->where('trainee_id', auth()->user()->student->trainee->id);
            })->where('status', '!=', 'Completed')->count(),
            'absents' => auth()->user()->student->trainee == null ? 0 : Absent::where('trainee_id', auth()->user()->student->trainee->id)->count(),
        ]);
    }
}
