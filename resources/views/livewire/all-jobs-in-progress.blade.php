<div wire>
    
@if(count($completed_job_status_ids) > 0)
    @foreach($completed_job_status_ids as $completed_job_status_id)
        @livewire('display-info-completed-job', [ 
            'jobStatusId' => $completed_job_status_id 
            ], key('completed'.$completed_job_status_id))
    @endforeach
@endif

@foreach($current_jobStatus_ids as $key => $currentJobStatusId)
    @livewire('display-progress-job', [ 
        'jobStatusId' => $currentJobStatusId,
        'jobStatusJobId' => $current_jobStatus_ids_corresponding_job_ids[$key],
        ], key('currentprogress'.$currentJobStatusId))

    @livewire('check-if-job-completed', [ 
        'jobStatusId' => $currentJobStatusId,
        'jobStatusJobId' => $current_jobStatus_ids_corresponding_job_ids[$key],
        ], key('currentcheck'.$currentJobStatusId))
@endforeach

</div>
