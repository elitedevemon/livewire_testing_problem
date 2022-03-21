<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\JobStatus;
use Illuminate\Support\Facades\DB;
use App\Jobs\RunJob; // important ! If not here, no error is thrown, but the 'instanceof' does not work - do i still need this?
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class DisplayProgressJob extends Component
{
    public $run_job_description;
    public $completed_actions_message;
    public $current_action_message;

    public $text;
    public $jobId;

    //protected $listeners = ['refreshDisplay'];

    public function mount($jobStatusId, $jobStatusJobId)
    {
        $this->jobStatusId = $jobStatusId;
        $this->jobStatusJobId = $jobStatusJobId;
    }

    public function render()
    {  
        $this->jobId = $this->jobStatusJobId;

        // si le job correspondant au jobstatus n'existe plus dans la BD = job terminé
        /*if(!DB::table('jobs')->where('id', $this->jobStatusJobId)->exists()) 
        { 
            //$this->completed_job_status_id = $this->jobStatusId;
            $this->redirectBack();
        }*/
        
        
        $jobStatus = JobStatus::find($this->jobStatusId);

        if($jobStatus)
        {
            $this->run_job_description = $jobStatus->getRunJobDescription();
            $this->completed_actions_message = $jobStatus->getCompletedActionsInfo();
            $this->current_action_message = $jobStatus->getCurrentActionInfo();
        }
        else
        {
            // si le user vient juste de canceller l'action / séquence
            // ce code semble inutile mais il y a un fragment de seconde pdt lequel, sans ce code, ça plante parfois qd je cancelle une RunJob
            // peut-être quand le système est gelé ?
            $this->run_job_description = "";
            $this->completed_actions_message = "<span class='font-black'>This request has been deleted.</span>";
            $this->current_action_message = "";
        }

        return view('livewire.display-progress-job');
    }
}
