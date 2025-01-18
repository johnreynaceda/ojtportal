<?php

namespace App\Livewire;

use App\Models\Absent;
use App\Models\Announcement;
use App\Models\Task;
use App\Models\Trainee;
use Livewire\Component;

class SupervisorDashboard extends Component
{
    public function render()
    {
        return view('livewire.supervisor-dashboard',[
            'trainees'  => Trainee::where('supervisor_id', auth()->user()->supervisor->id),
            'announcements' => Announcement::orderByDesc('created_at')->get()->take(6),
            'tasks' => Task::where('status', '!=', 'Completed')->count(),
            'absents' => Absent::whereHas('trainee', function($record){
                $record->whereHas('supervisor', function($query){
                    $query->where('id', auth()->user()->supervisor->id);
                });
            })->count(),
            'completed' => Trainee::where('supervisor_id', auth()->user()->supervisor->id)->where('status','Ccompleted')->count(),
        ]);
    }
}
