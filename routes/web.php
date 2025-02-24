<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
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

Route::prefix('coordinator')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/', function(){
        return view('coordinator.dashboard');
    })->name('coordinator.dashboard');
    Route::get('/class-list', function(){
        return view('coordinator.class');
    })->name('coordinator.class');
    Route::get('/requirements', function(){
        return view('coordinator.requirements');
    })->name('coordinator.requirements');
    Route::get('/requirements/{id}', function(){
        return view('coordinator.requirement_view');
    })->name('coordinator.requirements_view');
    Route::get('/users', function(){
        return view('coordinator.users');
    })->name('coordinator.users');
    Route::get('/journal-reports', function(){
        return view('coordinator.journal');
    })->name('coordinator.journal');
    Route::get('/journal-reports/{id}', function(){
        return view('coordinator.journal_view');
    })->name('coordinator.journal_view');
    Route::get('/chat', function(){
        return view('coordinator.chat');
    })->name('coordinator.chat');
    Route::get('/announcement', function(){
        return view('coordinator.announcement');
    })->name('coordinator.announcement');
    Route::get('/evaluation-form', function(){
        return view('coordinator.evaluation-form');
    })->name('coordinator.evaluation-form');
    Route::get('/criteria-questions/{id}', function(){
        return view('coordinator.criteria-questions');
    })->name('coordinator.criteria-questions');
    Route::get('/students-dtr', function(){
        return view('coordinator.students-dtr');
    })->name('coordinator.students-dtr');
    Route::get('/view_attendance/{id}', function(){
        return view('coordinator.view-attendance');
    })->name('coordinator.view_attendance');
    Route::get('/task-accomplishment', function(){
        return view('coordinator.task');
    })->name('coordinator.task');
    Route::get('/view-task/{id}', function(){
        return view('coordinator.view-task');
    })->name('coordinator.view_task');
});

Route::prefix('student')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/', function(){
        return view('student.dashboard');
    })->name('student.dashboard');
    Route::get('/requirement/edited-docs', function(){
        return view('student.requirement.edited-docs');
    })->name('student.requirement.edited-docs');
    Route::get('/requirement/edited-docs/upload/{id}', function(){
        return view('student.requirement.upload');
    })->name('student.requirement.upload');
    Route::get('/tasks', function(){
        return view('student.tasks');
    })->name('student.tasks');
    Route::get('/dtr', function(){
        return view('student.dtr');
    })->name('student.dtr');
    Route::get('/manage-absent', function(){
        return view('student.absent');
    })->name('student.absent');
    Route::get('/journal', function(){
        return view('student.journal');
    })->name('student.journal');
    Route::get('/chat', function(){
        return view('student.chat');
    })->name('student.chat');
    Route::get('/resume', function(){
        return view('student.resume');
    })->name('student.resume');

    
});

Route::prefix('supervisor')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/', function(){
        return view('supervisor.dashboard');
    })->name('supervisor.dashboard');
    Route::get('/trainee', function(){
        return view('supervisor.trainee');
    })->name('supervisor.trainee');
    Route::get('/tasks', function(){
        return view('supervisor.tasks');
    })->name('supervisor.tasks');
    Route::get('/chat', function(){
        return view('supervisor.chat');
    })->name('supervisor.chat');
    Route::get('/attendance', function(){
        return view('supervisor.attendance');
    })->name('supervisor.attendance');
    Route::get('/view_attendance/{id}', function(){
        return view('supervisor.view_attendance');
    })->name('supervisor.view_attendance');
    Route::get('/ratings', function(){
        return view('supervisor.ratings');
    })->name('supervisor.ratings');
    Route::get('/rating/student/{id}', function(){
        return view('supervisor.rate-student');
    })->name('supervisor.rate-student');
   
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
