<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Jobs\RunJob; // important ! If not here, no error is thrown, but the 'instanceof' does not work - do i still need this?


class AllJobsInProgress extends Component
{
    public $user;
    public $current_jobStatus_ids = [];
    public $current_jobStatus_ids_corresponding_job_ids = [];
    public $all_newly_started_jobStatus_ids = [];
    public $all_newly_started_jobStatus_ids_corresponding_job_ids = [];
    public $completed_job_status_ids = [];

    protected $listeners = ['refreshDisplay'];

    public function mount($user)
    {
        $this->user = $user;

        $this->get_current_job_statuses_for_user($this->user);

        $this->all_newly_started_jobStatus_ids = $this->current_jobStatus_ids;
        $this->all_newly_started_jobStatus_ids_corresponding_job_ids = $this->current_jobStatus_ids_corresponding_job_ids;

        $this->completed_job_status_ids = [];
    }

    public function render()
    {
        return view('livewire.all-jobs-in-progress');
    }

    public function refreshDisplay()
    {
        $this->get_current_job_statuses_for_user($this->user);

        $this->get_completed_jobs_status_ids();
    }

    public function get_completed_jobs_status_ids()
    {
        $this->completed_job_status_ids = [];

        foreach($this->all_newly_started_jobStatus_ids_corresponding_job_ids as $key => $job_id)
        {
            if(!DB::table('jobs')->where('id', $job_id)->exists()) 
            // si le job correspondant au jobstatus n'existe plus dans la BD = job terminé
            {
                array_push($this->completed_job_status_ids, $this->all_newly_started_jobStatus_ids[$key]);
            }
        }
    }

    public function get_current_job_statuses_for_user()
    {
        // on réinitialise les tableaux
        $this->current_jobStatus_ids = [];
        $this->current_jobStatus_ids_corresponding_job_ids = [];
        
        foreach(DB::table('jobs')->get() as $job) // pour tous les jobs de la BD
        { 
            // à partir du job de la BD, on réussit à récupérer les objets de la classe Job
            $job_object = unserialize(json_decode($job->payload)->data->command);

            // on veut seulement les jobs de type RunJob
            if ($job_object instanceof RunJob)
            {
                $run_job = $job_object;
                // pour chaque RunJob on vérifie s'il "appartient" à l'utilisateur connecté
                // si le RunJob "appartient" à l'utilisateur connecté, on ajoute le statusId du job au tableau $current_jobStatus_ids
                array_push($this->current_jobStatus_ids, $run_job->getJobStatusId());
                array_push($this->current_jobStatus_ids_corresponding_job_ids, $job->id);
            }
        }
    }
}
