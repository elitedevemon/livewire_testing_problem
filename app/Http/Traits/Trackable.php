<?php

namespace App\Http\Traits;

trait Trackable
{
    /** @var int */
    protected $statusId;
    protected $completed_actions_info = "";
    protected $current_action_info = "";
    protected $run_job_description = "";

    protected function setCompletedActionsInfo($value)
    {        
        $this->update(['completed_actions_info' => $value]);
        $this->completed_actions_info = $value;
    }

    protected function setCurrentActionInfo($value)
    {        
        $this->update(['current_action_info' => $value]);
        $this->current_action_info = $value;
    }

    protected function setRunJobDescription($value)
    {        
        $this->update(['run_job_description' => $value]);
        $this->run_job_description = $value;
    }
    
    protected function update(array $data)
    {
        /** @var JobStatusUpdater */
        $updater = app(JobStatusUpdater::class);
        $updater->update($this, $data);
    }

    protected function prepareStatus(array $data = [])
    {
        /** @var JobStatus */
        $entityClass = app(config('job-status.model'));

        $data = array_merge(['type' => $this->getDisplayName()], $data);
        /** @var JobStatus */
        $status = $entityClass::query()->create($data);

        $this->statusId = $status->getKey();
    }

    protected function getDisplayName()
    {
        return method_exists($this, 'displayName') ? $this->displayName() : static::class;
    }

    public function getJobStatusId()
    {
        return $this->statusId;
    }
}
