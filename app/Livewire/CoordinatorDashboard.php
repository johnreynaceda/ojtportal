<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\CoordinatorRating;
use App\Models\CoordinatorStudentRate;
use App\Models\DailyTimeRecord;
use App\Models\Student;
use App\Models\StudentJournal;
use App\Models\SupervisorSurveyResponse;
use App\Models\Task;
use App\Models\Trainee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CoordinatorDashboard extends Component
{

    public $chartData;
    public $taskData;

    public $performings;

    public function mount()
    {
        $this->chartData = $this->getTaskData();
        $this->taskData = $this->getChartData();
        $this->performings = $this->getPerformings();


    }

    public function getPerformings()
    {
        $students = Student::where('coordinator_id', auth()->user()->coordinator->id)
            ->whereHas('trainee')
            ->with(['trainee.taskAssignedStudents.task', 'trainee.absents', 'studentJournals'])
            ->get()
            ->map(function ($student) {
                $student_name = $student->user->name;

                // Task rating calculation
                $taskRates = $student->trainee->taskAssignedStudents->map(fn($q) => $q->task->rate);
                $averageTaskRate = $taskRates->count() > 0 ? $taskRates->avg() : 0;
                $taskPercentage = ($averageTaskRate / 5) * 100;
                $task_rating = $taskPercentage * 0.2;

                // Attendance rate calculation
                $absentHours = $student->trainee->absents->sum('no_of_hours');
                $presentHours = StudentJournal::where('student_id', $student->trainee->id)->where('journal_status', 'approved')->where('status', '!=', 'Delayed')->sum('no_of_hours');

                $attendance_rate = $presentHours > 0
                    ? ((($presentHours - $absentHours) / $presentHours) * 100) * 0.1
                    : 0;

                // Journal rate calculation
                $onTimeCount = $student->studentJournals->where('journal_status', 'approved')->where('status', 'On-time')->count();
                $journalCount = $student->studentJournals->count();
                $journal_rate = $journalCount > 0
                    ? (($onTimeCount / $journalCount) * 100) * 0.1
                    : 0;

                $evaluation = CoordinatorStudentRate::where('student_id', $student->id)->first();
                // Fixed ratings
                $total = 0;

                if ($evaluation && $evaluation->responses) {
                    $responses = json_decode($evaluation->responses, true); // Decode JSON to array
    
                    // Sum all earned points
                    foreach ($responses as $data) {
                        $earned = isset($data['earned']) ? (int) $data['earned'] : 0;
                        $total += $earned;
                    }

                    $coordinator_rating = $total * 0.3;
                } else {
                    $coordinator_rating = 27; // Default fallback if no response
                }

                $supervisor_response = SupervisorSurveyResponse::where('student_id', $student->id)->first();
                $total = 0;

                if ($supervisor_response && $supervisor_response->responses) {
                    $responses = json_decode($supervisor_response->responses, true); // Decode JSON to array
    
                    // Sum all earned points
                    foreach ($responses as $data) {
                        $earned = isset($data['earned']) ? (int) $data['earned'] : 0;
                        $total += $earned;
                    }

                    $supervisor_rating = $total * 0.3;
                } else {
                    $supervisor_rating = 27; // Default fallback if no response
                }

                // Total score
                $total = round($task_rating) + round($attendance_rate) + round($journal_rate) + round($coordinator_rating) + round($supervisor_rating);

                // $total_risk = 100 - $total;
    
                $category = '';
                if ($total >= 86) {
                    $category = 'Low';
                } elseif ($total >= 80 && $total <= 85) {
                    $category = 'Medium';
                } else {
                    $category = 'High';
                }

                return [
                    'name' => $student_name,
                    'task_rating' => round($task_rating),
                    'attendance_rate' => round($attendance_rate),
                    'journal_rate' => round($journal_rate),
                    'coordinator_rating' => round($coordinator_rating),
                    'supervisor_rating' => round($supervisor_rating),
                    'total' => round($total, 2), // Keep decimals for sorting
                    'category' => $category,
                ];
            })
            ->sortByDesc('total')
            ->values();

        // Assign ranks after sorting
        $rankedStudents = $students->map(function ($student, $index) {
            $student['rank'] = $index + 1;
            return $student;
        });

        return $rankedStudents;

    }


    // Helper: Get week number relative to first task week
    private function getWeekNumber(Carbon $firstWeekStart, Carbon $taskDate): int
    {
        return $firstWeekStart->diffInWeeks($taskDate->startOfWeek()) + 1;
    }

    public function getChartData()
    {

        $firstTask = Task::orderBy('due_date', 'asc')
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

        $firstTask = Task::orderBy('due_date', 'asc')
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
        return view('livewire.coordinator-dashboard', [
            'trainee' => Trainee::whereHas('student', function ($record) {
                $record->where('course_id', auth()->user()->course_id);
            })->count(),
            'completed' => Trainee::whereHas('student', function ($record) {
                $record->where('course_id', auth()->user()->course_id);
            })->where('status', 'Completed')->count(),
            'dropped' => Student::where('course_id', auth()->user()->course_id)->where('status', 'dropped')->count(),
            'announcements' => Announcement::orderByDesc('created_at')->get()->take(6),
        ]);
    }
}
