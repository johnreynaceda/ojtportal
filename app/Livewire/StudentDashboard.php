<?php

namespace App\Livewire;

use App\Models\Absent;
use App\Models\Announcement;
use App\Models\Task;
use Carbon\Carbon;
use Livewire\Component;

class StudentDashboard extends Component
{
    public $chartData;
    public $taskData;

    public function mount()
    {
        $this->chartData = $this->getTaskData();
        $this->taskData = $this->getChartData();
    }

    private function getWeekNumber(Carbon $firstWeekStart, Carbon $taskDate): int
    {
        return $firstWeekStart->diffInWeeks($taskDate->startOfWeek()) + 1;
    }

    public function getChartData()
    {

        $firstTask = Task::whereHas('taskAssignedStudents.trainee', function ($query) {
            $query->where('student_id', auth()->user()->student->id);
        })
            ->orderBy('due_date', 'asc')
            ->first();

        if (!$firstTask) {
            return [];
        }

        $firstWeekStart = Carbon::parse($firstTask->due_date)->startOfWeek();
        $currentWeekStart = Carbon::now()->startOfWeek();
        $totalWeeks = $firstWeekStart->diffInWeeks($currentWeekStart) + 1;

        // Fetch tasks
        $tasks = Task::get();

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

        $firstTask = Task::whereHas('taskAssignedStudents.trainee', function ($query) {
            $query->where('student_id', auth()->user()->student->id);
        })
            ->orderBy('due_date', 'asc')
            ->first();

        if (!$firstTask) {
            return [];
        }

        $firstWeekStart = Carbon::parse($firstTask->due_date)->startOfWeek();
        $currentWeekStart = Carbon::now()->startOfWeek();
        $totalWeeks = $firstWeekStart->diffInWeeks($currentWeekStart) + 1;

        $tasks = Task::get();

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
        return view('livewire.student-dashboard', [
            'announcements' => Announcement::orderByDesc('created_at')->get()->take(6),
            'tasks' => auth()->user()->student->trainee == null ? 0 : Task::whereHas('taskAssignedStudents', function ($record) {
                $record->where('trainee_id', auth()->user()->student->trainee->id);
            })->where('status', '!=', 'Completed')->count(),
            'absents' => auth()->user()->student->trainee == null ? 0 : Absent::where('trainee_id', auth()->user()->student->trainee->id)->count(),
        ]);
    }
}
