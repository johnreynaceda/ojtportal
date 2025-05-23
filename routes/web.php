<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckUser;
use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::post('/logout', function () {
    if (auth()->check()) {
        UserLog::create([
            'user_type' => auth()->user()->user_type,
            'username' => auth()->user()->name,
            'date' => Carbon::now(),
            'activity' => 'Logout',
        ]);

        Auth::logout();
    }

    return redirect()->route('login');
})->name('logout');



Route::get('/verification-status', function () {
    return view('pages.verification');
})->name('user.not_approved');

Route::get('/dashboard', function () {
    switch (auth()->user()->user_type) {
        case 'coordinator':
            return redirect()->route('coordinator.dashboard');
        case 'student':
            return redirect()->route('student.dashboard');
        case 'supervisor':
            return redirect()->route('supervisor.dashboard');

        default:
            # code...
            break;
    }
})->middleware(['auth', 'verified', CheckUser::class])->name('dashboard');

Route::prefix('coordinator')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('coordinator.dashboard');
    })->name('coordinator.dashboard');
    Route::get('/class-list', function () {
        return view('coordinator.class');
    })->name('coordinator.class');
    Route::get('/requirements', function () {
        return view('coordinator.requirements');
    })->name('coordinator.requirements');
    Route::get('/requirements/{id}', function () {
        return view('coordinator.requirement_view');
    })->name('coordinator.requirements_view');
    Route::get('/users', function () {
        return view('coordinator.users');
    })->name('coordinator.users');
    Route::get('/journal-reports', function () {
        return view('coordinator.journal');
    })->name('coordinator.journal');
    Route::get('/journal-reports/{id}', function () {
        return view('coordinator.journal_view');
    })->name('coordinator.journal_view');
    Route::get('/chat', function () {
        return view('coordinator.chat');
    })->name('coordinator.chat');
    Route::get('/announcement', function () {
        return view('coordinator.announcement');
    })->name('coordinator.announcement');
    Route::get('/evaluation-form', function () {
        return view('coordinator.evaluation-form');
    })->name('coordinator.evaluation-form');
    Route::get('/criteria-questions/{id}', function () {
        return view('coordinator.criteria-questions');
    })->name('coordinator.criteria-questions');
    Route::get('/students-dtr', function () {
        return view('coordinator.students-dtr');
    })->name('coordinator.students-dtr');
    Route::get('/view_attendance/{id}', function () {
        return view('coordinator.view-attendance');
    })->name('coordinator.view_attendance');
    Route::get('/task-accomplishment', function () {
        return view('coordinator.task');
    })->name('coordinator.task');
    Route::get('/view-task/{id}', function () {
        return view('coordinator.view-task');
    })->name('coordinator.view_task');
    Route::get('/coordinator-student-rating/', function () {
        return view('coordinator.student-rating');
    })->name('coordinator.student-rating');
    Route::get('/coordinator-survey-response/{id}', function () {
        return view('coordinator.survey-response');
    })->name('coordinator.survey-response');
    Route::get('/partner', function () {
        return view('coordinator.partner');
    })->name('coordinator.partner');

    Route::get('/user-log', function () {
        return view('coordinator.user-log');
    })->name('coordinator.user-log');
    Route::get('/training-plan', function () {
        return view('coordinator.training-plan');
    })->name('coordinator.training-plan');
    Route::get('/moa', function () {
        return view('coordinator.moa');
    })->name('coordinator.moa');
    Route::get('/intern-evaluation', function () {
        return view('coordinator.intern-evaluation');
    })->name('coordinator.intern-evaluation');
    Route::get('/intern-evaluation/{id}', function () {
        return view('coordinator.student-evaluation');
    })->name('coordinator.student-evaluation');

    Route::get('/supervisor-rating', function () {
        return view('coordinator.supervisor-rating');
    })->name('coordinator.supervisor-rating');
    Route::get('/supervisor-rating/{id}', function () {
        return view('coordinator.supervisor-rating-record');
    })->name('coordinator.supervisor-rating-record');
});

Route::prefix('student')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
    Route::get('/requirement/edited-docs', function () {
        return view('student.requirement.edited-docs');
    })->name('student.requirement.edited-docs');
    Route::get('/requirement/edited-docs/upload/{id}', function () {
        return view('student.requirement.upload');
    })->name('student.requirement.upload');
    Route::get('/tasks', function () {
        return view('student.tasks');
    })->name('student.tasks');
    Route::get('/dtr', function () {
        return view('student.dtr');
    })->name('student.dtr');
    Route::get('/manage-absent', function () {
        return view('student.absent');
    })->name('student.absent');
    Route::get('/journal', function () {
        return view('student.journal');
    })->name('student.journal');
    Route::get('/chat', function () {
        return view('student.chat');
    })->name('student.chat');
    Route::get('/resume', function () {
        return view('student.resume');
    })->name('student.resume');
    Route::get('/company', function () {
        return view('student.company');
    })->name('student.company');
    Route::get('/evaluate', function () {
        return view('student.evaluate');
    })->name('student.evaluate');
    Route::get('/recommendation', function () {
        return view('student.recommendation');
    })->name('student.recommendation');


});

Route::prefix('supervisor')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('supervisor.dashboard');
    })->name('supervisor.dashboard');
    Route::get('/trainee', function () {
        return view('supervisor.trainee');
    })->name('supervisor.trainee');
    Route::get('/application', function () {
        return view('supervisor.application');
    })->name('supervisor.application');
    Route::get('/tasks', function () {
        return view('supervisor.tasks');
    })->name('supervisor.tasks');
    Route::get('/chat', function () {
        return view('supervisor.chat');
    })->name('supervisor.chat');
    Route::get('/attendance', function () {
        return view('supervisor.attendance');
    })->name('supervisor.attendance');
    Route::get('/view_attendance/{id}', function () {
        return view('supervisor.view_attendance');
    })->name('supervisor.view_attendance');
    Route::get('/ratings', function () {
        return view('supervisor.ratings');
    })->name('supervisor.ratings');
    Route::get('/rating/student/{id}', function () {
        return view('supervisor.rate-student');
    })->name('supervisor.rate-student');
    Route::get('/manage-absents', function () {
        return view('supervisor.absents');
    })->name('supervisor.absents');
    Route::get('/moa', function () {
        return view('supervisor.moa');
    })->name('supervisor.moa');
    Route::get('/journal', function () {
        return view('supervisor.journal');
    })->name('supervisor.journal');
    Route::get('/journal/{id}', function () {
        return view('supervisor.student-journal');
    })->name('supervisor.student-journal');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
