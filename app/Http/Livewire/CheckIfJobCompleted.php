<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Jobs\RunJob;
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class CheckIfJobCompleted extends Component
{
    public $jobStatusId;
    public $jobStatusJobId;
    public $completed;

    public function mount($jobStatusId, $jobStatusJobId)
    {
        $this->jobStatusId = $jobStatusId;
        $this->jobStatusJobId = $jobStatusJobId;
    }

    public function render()
    {
        if(!DB::table('jobs')->where('id', $this->jobStatusJobId)->exists()) 
        // si le job correspondant au jobstatus n'existe plus dans la BD = job terminé
        {
            $this->completed = true;
            $this->emit('refreshDisplay');
        }
        else
        {
            $this->completed = false;
        }

        return view('livewire.check-if-job-completed');
    }
}
