<?php

namespace App\Http\Traits;

use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log;
use App\Jobs\RunJob;

class JobStatusUpdater
{
    public function update($job, array $data)
    {
        $this->updateJob($job, $data);
    }

   

    protected function updateJob($job, array $data)
    {
        if ($jobStatus = $this->getJobStatus($job)) {
            $jobStatus->update($data);
        }
    }

    

    protected function getJobStatusId($job)
    {
        try {
            if ($job instanceof RunJob || method_exists($job, 'getJobStatusId')) {
                return $job->getJobStatusId();
            }
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return null;
        }

        return null;
    }

    protected function getJobStatus($job)
    {
        if ($id = $this->getJobStatusId($job)) {
            /** @var JobStatus $entityClass */
            $entityClass = app(config('job-status.model'));

            return $entityClass::on(config('job-status.database_connection'))->whereKey($id)->first();
        }

        return null;
    }
}
