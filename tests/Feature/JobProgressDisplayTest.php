<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Closet;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Jobs\RunJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Models\JobStatus;
use Livewire\Livewire;
use App\Http\Livewire\AllJobsInProgress;
use App\Http\Livewire\CheckIfJobCompleted;
use Illuminate\Support\Facades\Hash;



class JobProgressDisplayTest extends TestCase
{
    use RefreshDatabase;
    use DispatchesJobs;

    /** @test */
    public function when_there_are_no_jobs_the_dashboard_is_displayed_ok()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('dashboard')); 
        $response->assertStatus(200);
    }

    /** @test */
    public function when_there_is_several_jobs_the_progress_is_displayed_for_each_job()
    {
        $this->withoutExceptionHandling();

        $this->createUserCloset();

        $response = $this->get(route('dashboard')); 
        $response->assertStatus(200);


        // on crée à la main des enregistrements dans la table Job
        // car ils sont nécessaires pour afficher correctement les JobStatuses

        $response = $this->post(route('startJob'));

        DB::table('jobs')->insert([
            'queue' => 'default',
            'attempts' => '0',
            'available_at' => '1642679702',
            'created_at' => '1642679702',
            'payload' => '{"uuid":"6eb13090-803a-4bf2-a918-99a9157c198a","displayName":"App\\\Jobs\\\RunJob","job":"Illuminate\\\Queue\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\Jobs\\\RunJob","command":"O:15:\"App\\\Jobs\\\RunJob\":19:{s:4:\"user\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:15:\"App\\\Models\\\User\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:16:\"connected_closet\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:17:\"App\\\Models\\\Closet\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:6:\"method\";s:12:\"share_closet\";s:4:\"args\";a:8:{s:15:\"closet_username\";s:6:\"roxhan\";s:8:\"share_to\";s:9:\"followers\";s:4:\"type\";s:3:\"all\";s:12:\"availability\";s:3:\"all\";s:8:\"shipping\";s:3:\"all\";s:9:\"condition\";s:3:\"all\";s:15:\"min_price_value\";i:0;s:15:\"max_price_value\";i:100;}s:20:\"credits_used_for_job\";i:0;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}s:11:\"\\u0000*\\u0000statusId\";i:'.JobStatus::first()->id.';s:25:\"\\u0000*\\u0000completed_actions_info\";s:0:\"\";s:22:\"\\u0000*\\u0000current_action_info\";s:63:\"<span>Please be patient, this might take a little while.<\/span>\";s:22:\"\\u0000*\\u0000run_job_description\";s:28:\"<span>Job in progress<\/span>\";}"}}'
        ]);




        $this->assertCount(1, DB::table('jobs')->get()); 
        $this->assertCount(1, DB::table('job_statuses')->get()); 
        $this->assertCount(1, JobStatus::all());

        $this->followRedirects($response)->assertSee(":wire:key='display_progress_job_".JobStatus::first()->id."'><span class='text-xl'>Job in progress</span>", $escaped = false);

        Livewire::test(AllJobsInProgress::class, [ 'user' => User::first() ])
                    ->assertSee('display_progress_job_'.JobStatus::first()->id);

        $response = $this->post(route('startJob'));
        DB::table('jobs')->insert([
            'queue' => 'default',
            'attempts' => '0',
            'available_at' => '1642679702',
            'created_at' => '1642679702',
            'payload' => '{"uuid":"6eb13090-803a-4bf2-a918-99a9157c198b","displayName":"App\\\Jobs\\\RunJob","job":"Illuminate\\\Queue\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\Jobs\\\RunJob","command":"O:15:\"App\\\Jobs\\\RunJob\":19:{s:4:\"user\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:15:\"App\\\Models\\\User\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:16:\"connected_closet\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:17:\"App\\\Models\\\Closet\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:6:\"method\";s:12:\"share_closet\";s:4:\"args\";a:8:{s:15:\"closet_username\";s:6:\"roxhan\";s:8:\"share_to\";s:9:\"followers\";s:4:\"type\";s:3:\"all\";s:12:\"availability\";s:3:\"all\";s:8:\"shipping\";s:3:\"all\";s:9:\"condition\";s:3:\"all\";s:15:\"min_price_value\";i:0;s:15:\"max_price_value\";i:100;}s:20:\"credits_used_for_job\";i:0;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}s:11:\"\\u0000*\\u0000statusId\";i:'.strval(JobStatus::first()->id + 1).';s:25:\"\\u0000*\\u0000completed_actions_info\";s:0:\"\";s:22:\"\\u0000*\\u0000current_action_info\";s:63:\"<span>Please be patient, this might take a little while.<\/span>\";s:22:\"\\u0000*\\u0000run_job_description\";s:28:\"<span>Job in progress<\/span>\";}"}}'
        ]);
        $this->assertCount(2, DB::table('jobs')->get()); 
        $this->assertCount(2, DB::table('job_statuses')->get()); 
        $this->assertCount(2, JobStatus::all());

        $this->followRedirects($response)->assertSee(":wire:key='display_progress_job_".strval((JobStatus::first()->id)+1)."'><span class='text-xl'>Job in progress</span>", $escaped = false);

        Livewire::test(AllJobsInProgress::class, [ 'user' => User::first() ])
                    ->assertSee('display_progress_job_'.strval((JobStatus::first()->id)+1));

        $response = $this->post(route('startJob'));
        DB::table('jobs')->insert([
            'queue' => 'default',
            'attempts' => '0',
            'available_at' => '1642679702',
            'created_at' => '1642679702',
            'payload' => '{"uuid":"6eb13090-803a-4bf2-a918-99a9157c198c","displayName":"App\\\Jobs\\\RunJob","job":"Illuminate\\\Queue\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\Jobs\\\RunJob","command":"O:15:\"App\\\Jobs\\\RunJob\":19:{s:4:\"user\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:15:\"App\\\Models\\\User\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:16:\"connected_closet\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:17:\"App\\\Models\\\Closet\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:6:\"method\";s:12:\"share_closet\";s:4:\"args\";a:8:{s:15:\"closet_username\";s:6:\"roxhan\";s:8:\"share_to\";s:9:\"followers\";s:4:\"type\";s:3:\"all\";s:12:\"availability\";s:3:\"all\";s:8:\"shipping\";s:3:\"all\";s:9:\"condition\";s:3:\"all\";s:15:\"min_price_value\";i:0;s:15:\"max_price_value\";i:100;}s:20:\"credits_used_for_job\";i:0;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}s:11:\"\\u0000*\\u0000statusId\";i:'.strval(JobStatus::first()->id + 2).';s:25:\"\\u0000*\\u0000completed_actions_info\";s:0:\"\";s:22:\"\\u0000*\\u0000current_action_info\";s:63:\"<span>Please be patient, this might take a little while.<\/span>\";s:22:\"\\u0000*\\u0000run_job_description\";s:28:\"<span>Job in progress<\/span>\";}"}}'
        ]);
        $this->assertCount(3, DB::table('jobs')->get()); 
        $this->assertCount(3, DB::table('job_statuses')->get());
        $this->assertCount(3, JobStatus::all()); 

        $this->followRedirects($response)->assertSee(":wire:key='display_progress_job_".strval((JobStatus::first()->id)+2)."'><span class='text-xl'>Job in progress</span>", $escaped = false);

        Livewire::test(AllJobsInProgress::class, [ 'user' => User::first() ])
                    ->assertSee('display_progress_job_'.strval((JobStatus::first()->id)+2));

        $response = $this->get(route('dashboard'));
        $response->assertSee(":wire:key='display_progress_job_".JobStatus::first()->id."'><span class='text-xl'>Job in progress</span>", $escaped = false);
        $response->assertSee(":wire:key='display_progress_job_".strval((JobStatus::first()->id)+1)."'><span class='text-xl'>Job in progress</span>", $escaped = false);
        $response->assertSee(":wire:key='display_progress_job_".strval((JobStatus::first()->id)+2)."'><span class='text-xl'>Job in progress</span>", $escaped = false);
    }

    /** @test */
    public function when_there_is_one_job_the_progress_is_displayed_ok_during_and_after_job()
    {
        $this->withoutExceptionHandling();

        $this->createUserCloset();

        $response = $this->get(route('dashboard')); 
        $response->assertStatus(200);

        $response = $this->post(route('startJob'));
        DB::table('jobs')->insert([
            'queue' => 'default',
            'attempts' => '0',
            'available_at' => '1642679702',
            'created_at' => '1642679702',
            'payload' => '{"uuid":"6eb13090-803a-4bf2-a918-99a9157c198d","displayName":"App\\\Jobs\\\RunJob","job":"Illuminate\\\Queue\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\Jobs\\\RunJob","command":"O:15:\"App\\\Jobs\\\RunJob\":19:{s:4:\"user\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:15:\"App\\\Models\\\User\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:16:\"connected_closet\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:17:\"App\\\Models\\\Closet\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:6:\"method\";s:12:\"share_closet\";s:4:\"args\";a:8:{s:15:\"closet_username\";s:6:\"roxhan\";s:8:\"share_to\";s:9:\"followers\";s:4:\"type\";s:3:\"all\";s:12:\"availability\";s:3:\"all\";s:8:\"shipping\";s:3:\"all\";s:9:\"condition\";s:3:\"all\";s:15:\"min_price_value\";i:0;s:15:\"max_price_value\";i:100;}s:20:\"credits_used_for_job\";i:0;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}s:11:\"\\u0000*\\u0000statusId\";i:'.JobStatus::first()->id.';s:25:\"\\u0000*\\u0000completed_actions_info\";s:0:\"\";s:22:\"\\u0000*\\u0000current_action_info\";s:63:\"<span>Please be patient, this might take a little while.<\/span>\";s:22:\"\\u0000*\\u0000run_job_description\";s:28:\"<span>Job in progress<\/span>\";}"}}'
        ]);
        $this->assertCount(1, DB::table('jobs')->get()); 
        $this->assertCount(1, DB::table('job_statuses')->get()); 
        $this->assertCount(1, JobStatus::all());

        $this->followRedirects($response)->assertSee(":wire:key='display_progress_job_".JobStatus::first()->id."'><span class='text-xl'>Job in progress</span>", $escaped = false);


        $response = $this->get(route('dashboard')); 
        $response->assertSee(":wire:key='display_progress_job_".JobStatus::first()->id."'><span class='text-xl'>Job in progress</span>", $escaped = false);
        
        $component = Livewire::test(AllJobsInProgress::class, [ 'user' => User::first() ]);
        $component->assertSee('display_progress_job_'.JobStatus::first()->id);

        $first_job_id = DB::table('jobs')->first()->id;
        $job = DB::table('jobs')->where('id', '=', $first_job_id)->delete();

        sleep(35);
        
        Livewire::test(CheckIfJobCompleted::class, [ 
            'jobStatusId' => JobStatus::first()->id,
            'jobStatusJobId' => $first_job_id
        ])->assertEmitted('refreshDisplay');

        $component->call('refreshDisplay') // we have a listener that fires this method
                    ->assertSee('display_info_completed_job_'.JobStatus::first()->id);
    }



    /** @test */
    public function when_there_is_several_jobs_the_progress_is_displayed_ok_during_and_after_job()
    {
        $this->withoutExceptionHandling();

        $this->createUserCloset();

        $response = $this->get(route('dashboard')); 
        $response->assertStatus(200);


        $response = $this->post(route('startJob'));
        DB::table('jobs')->insert([
            'queue' => 'default',
            'attempts' => '0',
            'available_at' => '1642679702',
            'created_at' => '1642679702',
            'payload' => '{"uuid":"6eb13090-803a-4bf2-a918-99a9157c198f","displayName":"App\\\Jobs\\\RunJob","job":"Illuminate\\\Queue\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\Jobs\\\RunJob","command":"O:15:\"App\\\Jobs\\\RunJob\":19:{s:4:\"user\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:15:\"App\\\Models\\\User\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:16:\"connected_closet\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:17:\"App\\\Models\\\Closet\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:6:\"method\";s:12:\"share_closet\";s:4:\"args\";a:8:{s:15:\"closet_username\";s:6:\"roxhan\";s:8:\"share_to\";s:9:\"followers\";s:4:\"type\";s:3:\"all\";s:12:\"availability\";s:3:\"all\";s:8:\"shipping\";s:3:\"all\";s:9:\"condition\";s:3:\"all\";s:15:\"min_price_value\";i:0;s:15:\"max_price_value\";i:100;}s:20:\"credits_used_for_job\";i:0;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}s:11:\"\\u0000*\\u0000statusId\";i:'.JobStatus::first()->id.';s:25:\"\\u0000*\\u0000completed_actions_info\";s:0:\"\";s:22:\"\\u0000*\\u0000current_action_info\";s:63:\"<span>Please be patient, this might take a little while.<\/span>\";s:22:\"\\u0000*\\u0000run_job_description\";s:28:\"<span>Job in progress<\/span>\";}"}}'
        ]);
        $this->assertCount(1, DB::table('jobs')->get()); 
        $this->assertCount(1, DB::table('job_statuses')->get()); 
        $this->assertCount(1, JobStatus::all());


        $this->followRedirects($response)->assertSee(":wire:key='display_progress_job_".JobStatus::first()->id."'><span class='text-xl'>Job in progress</span>", $escaped = false);

        $response = $this->post(route('startJob'));
        DB::table('jobs')->insert([
            'queue' => 'default',
            'attempts' => '0',
            'available_at' => '1642679702',
            'created_at' => '1642679702',
            'payload' => '{"uuid":"6eb13090-803a-4bf2-a918-99a9157c198a","displayName":"App\\\Jobs\\\RunJob","job":"Illuminate\\\Queue\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\Jobs\\\RunJob","command":"O:15:\"App\\\Jobs\\\RunJob\":19:{s:4:\"user\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:15:\"App\\\Models\\\User\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:16:\"connected_closet\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:17:\"App\\\Models\\\Closet\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:6:\"method\";s:12:\"share_closet\";s:4:\"args\";a:8:{s:15:\"closet_username\";s:6:\"roxhan\";s:8:\"share_to\";s:9:\"followers\";s:4:\"type\";s:3:\"all\";s:12:\"availability\";s:3:\"all\";s:8:\"shipping\";s:3:\"all\";s:9:\"condition\";s:3:\"all\";s:15:\"min_price_value\";i:0;s:15:\"max_price_value\";i:100;}s:20:\"credits_used_for_job\";i:0;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}s:11:\"\\u0000*\\u0000statusId\";i:'.strval(JobStatus::first()->id + 1).';s:25:\"\\u0000*\\u0000completed_actions_info\";s:0:\"\";s:22:\"\\u0000*\\u0000current_action_info\";s:63:\"<span>Please be patient, this might take a little while.<\/span>\";s:22:\"\\u0000*\\u0000run_job_description\";s:28:\"<span>Job in progress<\/span>\";}"}}'
        ]);
        $this->assertCount(2, DB::table('jobs')->get()); 
        $this->assertCount(2, DB::table('job_statuses')->get()); 
        $this->assertCount(2, JobStatus::all());

        $this->followRedirects($response)->assertSee(":wire:key='display_progress_job_".strval((JobStatus::first()->id)+1)."'><span class='text-xl'>Job in progress</span>", $escaped = false);


        $response = $this->post(route('startJob'));
        DB::table('jobs')->insert([
            'queue' => 'default',
            'attempts' => '0',
            'available_at' => '1642679702',
            'created_at' => '1642679702',
            'payload' => '{"uuid":"6eb13090-803a-4bf2-a918-99a9157c198b","displayName":"App\\\Jobs\\\RunJob","job":"Illuminate\\\Queue\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\Jobs\\\RunJob","command":"O:15:\"App\\\Jobs\\\RunJob\":19:{s:4:\"user\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:15:\"App\\\Models\\\User\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:16:\"connected_closet\";O:45:\"Illuminate\\\Contracts\\\Database\\\ModelIdentifier\":4:{s:5:\"class\";s:17:\"App\\\Models\\\Closet\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";}s:6:\"method\";s:12:\"share_closet\";s:4:\"args\";a:8:{s:15:\"closet_username\";s:6:\"roxhan\";s:8:\"share_to\";s:9:\"followers\";s:4:\"type\";s:3:\"all\";s:12:\"availability\";s:3:\"all\";s:8:\"shipping\";s:3:\"all\";s:9:\"condition\";s:3:\"all\";s:15:\"min_price_value\";i:0;s:15:\"max_price_value\";i:100;}s:20:\"credits_used_for_job\";i:0;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";N;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}s:11:\"\\u0000*\\u0000statusId\";i:'.strval(JobStatus::first()->id + 2).';s:25:\"\\u0000*\\u0000completed_actions_info\";s:0:\"\";s:22:\"\\u0000*\\u0000current_action_info\";s:63:\"<span>Please be patient, this might take a little while.<\/span>\";s:22:\"\\u0000*\\u0000run_job_description\";s:28:\"<span>Job in progress<\/span>\";}"}}'
        ]);
        $this->assertCount(3, DB::table('jobs')->get()); 
        $this->assertCount(3, DB::table('job_statuses')->get());
        $this->assertCount(3, JobStatus::all()); 

        $this->followRedirects($response)->assertSee(":wire:key='display_progress_job_".strval((JobStatus::first()->id)+2)."'><span class='text-xl'>Job in progress</span>", $escaped = false);


        $response = $this->get(route('dashboard'));
        $response->assertSee(":wire:key='display_progress_job_".JobStatus::first()->id."'><span class='text-xl'>Job in progress</span>", $escaped = false);
        $response->assertSee(":wire:key='display_progress_job_".strval((JobStatus::first()->id)+1)."'><span class='text-xl'>Job in progress</span>", $escaped = false);
        $response->assertSee(":wire:key='display_progress_job_".strval((JobStatus::first()->id)+2)."'><span class='text-xl'>Job in progress</span>", $escaped = false);

        $component = Livewire::test(AllJobsInProgress::class, [ 'user' => User::first() ]);
        $component->assertSee('display_progress_job_'.JobStatus::first()->id);
        $component->assertSee('display_progress_job_'.strval((JobStatus::first()->id)+1));
        $component->assertSee('display_progress_job_'.strval((JobStatus::first()->id)+2));

        $first_job_id = DB::table('jobs')->first()->id;
        $this->assertDatabaseHas('jobs', [
            'id' => $first_job_id,
        ]);
        $job = DB::table('jobs')->where('id', '=', $first_job_id)->delete();

        sleep(35);
        
        Livewire::test(CheckIfJobCompleted::class, [ 
            'jobStatusId' => JobStatus::first()->id,
            'jobStatusJobId' => $first_job_id
        ])->assertEmitted('refreshDisplay');

        $component->call('refreshDisplay');
        $component->assertSee('display_info_completed_job_'.JobStatus::first()->id);
        $component->assertSee('display_progress_job_'.strval((JobStatus::first()->id)+1)); //does not work - idk why
        $component->assertSee('display_progress_job_'.strval((JobStatus::first()->id)+2)); //does not work - idk why

    
        $second_job_id = DB::table('jobs')->first()->id;
        $this->assertDatabaseHas('jobs', [
            'id' => $second_job_id,
        ]);
        $job = DB::table('jobs')->where('id', '=', $second_job_id)->delete();

        sleep(35);
        
        Livewire::test(CheckIfJobCompleted::class, [ 
            'jobStatusId' => JobStatus::first()->id + 1,
            'jobStatusJobId' => $second_job_id
        ])->assertEmitted('refreshDisplay');

        $component->call('refreshDisplay');
        $component->assertSee('display_info_completed_job_'.JobStatus::first()->id); //does not work - idk why
        $component->assertSee('display_info_completed_job_'.strval((JobStatus::first()->id)+1));
        $component->assertSee('display_progress_job_'.strval((JobStatus::first()->id)+2)); //does not work - idk why
    }






    protected function createUserCloset()
    {
        DB::table('users')->insert([
            'name' => 'Anna Roche',
            'email' => 'annabelle.roche@hotmail.fr',
            'password' => Hash::make('aaaaaaaa'),
        ]);

        DB::table('closets')->insert([
            'user_id' => DB::table('users')->where([
                ['email', '=', 'annabelle.roche@hotmail.fr'],
            ])->get()->first()->id,

            'email' => 'annabelle.roche@hotmail.fr',
            'username' => 'roxhan',
            'password' => Closet::encryptPassword('aaaaaaaa'),
            'country' => 'CA',
        ]);
        
        $this->assertEquals('aaaaaaaa', Closet::decryptPassword(Closet::first()->password));
        $this->assertEquals('aaaaaaaa', Closet::decryptPassword(User::first()->closets()->first()->password));
        $this->assertEquals('CA', Closet::first()->country);
    }

}
