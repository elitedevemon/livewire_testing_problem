<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JobStatus;
use Barryvdh\Debugbar\Facades\Debugbar;

class DisplayInfoCompletedJob extends Component
{    
    public $run_job_description;
    public $completed_actions_message;

    public function mount($jobStatusId)
    {
        $this->jobStatusId = $jobStatusId;
    }

    public function render()
    {        
        $jobStatus = JobStatus::find($this->jobStatusId);

        if($jobStatus)
        {            
            $this->run_job_description = $jobStatus->getRunJobDescription();
            $this->completed_actions_message = $jobStatus->getCompletedActionsInfo();
        }
        else
        {
            $this->run_job_description = "";
            $this->completed_actions_message = "";
        }
        
        return view('livewire.display-info-completed-job');
    }
}
