<div wire:poll.5s class="mb-8 px-1 pt-5 pb-4 sm:px-6 bg-{{ $primary_color }}-300 text-gray-700 border-b border-{{ $primary_color }}-500 overflow-hidden shadow-xl rounded-lg" :wire:key='display_progress_job_{{ $jobStatusId }}'>@if($run_job_description !== ''){!! $run_job_description !!}@endif <!-- necessary to leave on same line so that there are no spaces, so that i can test in JobProgressDisplayTest what is displayed !!!! -->
  

    @if($completed_actions_message !== '')
    <div class="mb-3" :wire:key='completed_actions_message_{{ $jobStatusId }}'>
        {!! $completed_actions_message !!}
    </div>
    @endif
    <div class='flex justify-between items-baseline' :wire:key='current_action_message_{{ $jobStatusId }}'>                
        @if($current_action_message !== '')
        <span class='text-yellow-700'>
            {!! $current_action_message !!}
        </span>
        @endif
        
    </div>
</div>
