<?php

namespace App\Livewire;

use App\Models\SupervisorMoa;
use Livewire\Component;

class SupervisorMoaRecord extends Component
{
    public $moa;
    public $remarks;
    public function render()
    {
        $this->moa = SupervisorMoa::where('supervisor_id', auth()->user()->supervisor->id)->first();
        return view('livewire.supervisor-moa-record');
    }

    public function approve()
    {
        $this->moa->update([
            'status' => 'approved',
        ]);
    }
    public function forReview()
    {
        $this->moa->update([
            'status' => 'for-review',
        ]);
    }


    public function requestRevision()
    {
        $this->moa->update([
            'status' => 'request-revision',
            'remarks' => $this->remarks
        ]);
        $this->dispatch('close-modal', id: 'for-revision');
        $this->reset('remarks');
    }
    public function reject()
    {
        $this->moa->update([
            'status' => 'rejected',
            'remarks' => $this->remarks
        ]);
        $this->dispatch('close-modal', id: 'for-reject');
        $this->reset('remarks');
    }
}
