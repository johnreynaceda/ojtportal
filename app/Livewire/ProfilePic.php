<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilePic extends Component
{
    use WithFileUploads;
    public $profile;

    public function updatedProfile()
    {
        // dd($this->profile);
        auth()->user()->update([
            'profile_photo_path' => $this->profile->store('profile-photos', 'public')
        ]);

        sweetalert()->success('Profile picture updated successfully');
    }

    public function render()
    {
        return view('livewire.profile-pic');
    }
}
