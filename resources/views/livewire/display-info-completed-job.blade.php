<div wire class="my-4 px-1 pt-5 pb-4 sm:px-6 bg-{{ $primary_color }}-300 text-gray-700 border-b border-{{ $primary_color }}-500 overflow-hidden shadow-xl rounded-lg" :wire:key='display_info_completed_job_{{ $jobStatusId }}'>@if($run_job_description !== ''){!! $run_job_description !!}@endif  <!-- necessary to leave on same line so that there are no spaces, so that i can test in JobProgressDisplayTest what is displayed -->                 
    @if($completed_actions_message !== '')
    <div class="mb-3">
        {!! $completed_actions_message !!}
    </div>
    @endif
</div>
