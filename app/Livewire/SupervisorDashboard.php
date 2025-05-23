<?php

namespace App\Livewire;

use App\Models\Absent;
use App\Models\Announcement;
use App\Models\Task;
use App\Models\Trainee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SupervisorDashboard extends Component
{
    public $chartData;
    public $taskData;

    public function mount()
    {
        $this->chartData = $this->getTaskData();
        $this->taskData = $this->getChartData();
    }

    // Helper: Get week number relative to first task week
    private function getWeekNumber(Carbon $firstWeekStart, Carbon $taskDate): int
    {
        return $firstWeekStart->diffInWeeks($taskDate->startOfWeek()) + 1;
    }

    public function getChartData()
    {
        $supervisorId = Auth::user()->supervisor->id;

        $firstTask = Task::where('supervisor_id', $supervisorId)
            ->orderBy('due_date', 'asc')
            ->first();

        if (!$firstTask) {
            return [];
        }

        $firstWeekStart = Carbon::parse($firstTask->due_date)->startOfWeek();
        $currentWeekStart = Carbon::now()->startOfWeek();
        $totalWeeks = $firstWeekStart->diffInWeeks($currentWeekStart) + 1;

        // Fetch tasks
        $tasks = Task::where('supervisor_id', $supervisorId)->get();

        // Initialize weeks
        $ratingsPerWeek = [];
        for ($i = 1; $i <= $totalWeeks; $i++) {
            $ratingsPerWeek[$i] = [];
        }

        foreach ($tasks as $task) {
            $weekNumber = $this->getWeekNumber($firstWeekStart, Carbon::parse($task->due_date));
            if (isset($ratingsPerWeek[$weekNumber]) && $task->rate !== null) {
                $ratingsPerWeek[$weekNumber][] = $task->rate;
            }
        }

        // Format for chart
        $weeks = [];
        foreach ($ratingsPerWeek as $weekNum => $rates) {
            $avg_rating = count($rates) > 0 ? round(array_sum($rates) / count($rates), 2) : 0;
            $weeks[] = [
                'week' => 'Week ' . $weekNum,
                'avg_rating' => $avg_rating,
            ];
        }

        return $weeks;
    }

    public function getTaskData()
    {
        $supervisorId = Auth::user()->supervisor->id;

        $firstTask = Task::where('supervisor_id', $supervisorId)
            ->orderBy('due_date', 'asc')
            ->first();

        if (!$firstTask) {
            return [];
        }

        $firstWeekStart = Carbon::parse($firstTask->due_date)->startOfWeek();
        $currentWeekStart = Carbon::now()->startOfWeek();
        $totalWeeks = $firstWeekStart->diffInWeeks($currentWeekStart) + 1;

        $tasks = Task::where('supervisor_id', $supervisorId)->get();

        $taskStatusPerWeek = [];
        for ($i = 1; $i <= $totalWeeks; $i++) {
            $taskStatusPerWeek[$i] = [
                'completed' => 0,
                'delayed' => 0,
            ];
        }

        foreach ($tasks as $task) {
            $weekNumber = $this->getWeekNumber($firstWeekStart, Carbon::parse($task->due_date));
            if (!isset($taskStatusPerWeek[$weekNumber]))
                continue;

            if ($task->status === 'Completed') {
                $taskStatusPerWeek[$weekNumber]['completed'] += 1;
            } elseif ($task->status === 'Delayed') {
                $taskStatusPerWeek[$weekNumber]['delayed'] += 1;
            }
        }

        $weeks = [];
        foreach ($taskStatusPerWeek as $weekNum => $data) {
            $weeks[] = [
                'week' => 'Week ' . $weekNum,
                'completed' => $data['completed'],
                'delayed' => $data['delayed'],
            ];
        }

        return $weeks;
    }

    public function render()
    {
        return view('livewire.supervisor-dashboard', [
            'trainees' => Trainee::where('supervisor_id', auth()->user()->supervisor->id),
            'announcements' => Announcement::orderByDesc('created_at')->get()->take(6),
            'tasks' => Task::where('status', '!=', 'Completed')->count(),
            'absents' => Absent::whereHas('trainee', function ($record) {
                $record->whereHas('supervisor', function ($query) {
                    $query->where('id', auth()->user()->supervisor->id);
                });
            })->count(),
            'completed' => Trainee::where('supervisor_id', auth()->user()->supervisor->id)->where('status', 'Completed')->count(),
        ]);
    }
}
