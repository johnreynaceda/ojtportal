<?php

namespace App\Livewire;

use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Userdropdown extends Component
{
    public function render()
    {
        return view('livewire.userdropdown');
    }

    public function logout()
    {
        if (auth()->check()) {
            UserLog::create([
                'user_type' => auth()->user()->user_type,
                'username' => auth()->user()->name,
                'date' => now(),
                'activity' => 'Logout',
            ]);

            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('login');
        }
    }
}
