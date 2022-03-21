<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getCompletedActionsInfo()
    {
        return $this->completed_actions_info;
    }

    public function getCurrentActionInfo()
    {
        return $this->current_action_info;
    }

    public function getRunJobDescription()
    {
        return $this->run_job_description;
    }
  
}
