<?php

namespace App\Livewire\Coordinator;

use App\Models\CoordinatorRating;
use App\Models\DailyTimeRecord;
use App\Models\Student;
use App\Models\SupervisorSurveyResponse;
use Livewire\Component;

class RiskStudent extends Component
{
    public $risks;
    public function mount()
    {

        $this->risks = $this->getPerformings();


    }

    public function getPerformings()
    {
        $students = Student::where('course_id', auth()->user()->course_id)
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
                $absentHours = $student->trainee->absents->sum('total_hour');
                $presentHours = DailyTimeRecord::where('trainee_id', $student->trainee->id)->sum('total_hours');
                $attendance_rate = $presentHours > 0
                    ? ((($presentHours - $absentHours) / $presentHours) * 100) * 0.1
                    : 0;

                // Journal rate calculation
                $onTimeCount = $student->studentJournals->where('status', 'On-time')->count();
                $journalCount = $student->studentJournals->count();
                $journal_rate = $journalCount > 0
                    ? (($onTimeCount / $journalCount) * 100) * 0.1
                    : 0;

                $evaluation = CoordinatorRating::where('student_id', $student->id)->first();
                // Fixed ratings
                $coordinator_rating = $evaluation ? $evaluation->total_rating * 0.3 : 27;

                $response = SupervisorSurveyResponse::where('student_id', $student->id)->first();
                $total = 0;

                if ($response && $response->responses) {
                    $responses = json_decode($response->responses, true); // Decode JSON to array
    
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
                $total = 100 - ($task_rating + $attendance_rate + $journal_rate + $coordinator_rating + $supervisor_rating);

                // Categorize based on total score
                $category = '';
                if ($total < 15) {
                    $category = 'exclude'; // Exclude students with total < 15
                } elseif ($total >= 15 && $total <= 20) {
                    $category = 'medium';
                } else {
                    $category = 'high';
                }

                return [
                    'name' => $student_name,
                    'task_rating' => round($task_rating),
                    'attendance_rate' => round($attendance_rate),
                    'journal_rate' => round($journal_rate),
                    'coordinator_rating' => $coordinator_rating,
                    'supervisor_rating' => $supervisor_rating,
                    'total' => round($total, 2), // Keep decimals for sorting
                    'category' => $category, // Add category
                ];
            })
            ->filter(function ($student) {
                // Exclude students with total < 15
                return $student['total'] >= 15;
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


    public function render()
    {
        return view('livewire.coordinator.risk-student');
    }
}
