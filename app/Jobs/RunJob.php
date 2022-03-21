<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;
use App\Models\Error;
use App\Models\CustomerPackage;
use App\Models\DailyCredit;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Http\Traits\BotUtilsTrait;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\ChromeProcess;

use App\Models\User;
use App\Models\Closet;
use App\Models\JobStatus;
use Config;
use App\Http\Traits\Trackable;


class RunJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use BotUtilsTrait, Trackable;

    public $user;
    public $connected_closet;
    public $method; 
    public $args; 
    public $credits_used_for_job;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $connected_closet, $method = null, $args = null) // if $method == null and $args == null, it is a sequence
    {
        $this->user = $user;
        $this->connected_closet = $connected_closet;
        $this->method = $method;
        $this->args = $args;        
        $this->credits_used_for_job = 0;     

        $this->prepareStatus();

        $run_job_description = $this->generateRunJobDescription();

        $this->setRunJobDescription($run_job_description);

        $current = "<span class='font-black'>Please be patient, this might take a little while.</span>";
        $this->setCurrentActionInfo($current);
    }

    public function failed($exception)
    {
        $message = "";

        // je ne sais pas pourquoi mais $this->current_action_info ne retourne pas la dernière valeur
        // mais ça fonctionne quand je vais plutôt chercher $jobStatus->current_action_info
        $jobStatus = JobStatus::findOrFail($this->getJobStatusId());
        if($jobStatus && $jobStatus->completed_actions_info && $jobStatus->completed_actions_info !== "")
        {
            $message = $jobStatus->completed_actions_info;
        }

        $error_name = 'ERR_FAILED_JOB';
        $message .= Error::generateError($this->user, $error_name, $exception->getMessage());

        if($jobStatus && $jobStatus->current_action_info && $jobStatus->current_action_info !== "")
        {
            $message .= '<span class="text-gray-500"><b>- Latest status: </b>'.$jobStatus->current_action_info.'</span>';
        }

        $this->setCompletedActionsInfo($message);
        $this->setCurrentActionInfo("");
        Storage::append($this->user->get_user_trace_file(), "Exception: ".$error_name." - ".$exception->getMessage()."\n");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = "";

        $current = env('APP_NAME')." is starting to process your request... Please be patient, this might take a few minutes.";
        $this->setCurrentActionInfo($current);

        $message = '<p>'.$this->runOneAction($this->method, $this->args).'</p>';
        $this->setCompletedActionsInfo($message);
        $this->setCurrentActionInfo("");

        $message .= "<p class='mt-2 font-bold uppercase'>Credits used: ".$this->credits_used_for_job."</p>";
        $this->setCurrentActionInfo("");
        $this->setCompletedActionsInfo($message);
    }




    public function runOneAction($method_this_time, $args_this_time)
    { 
        $date = date('Y-m-d H:i:s');
        Storage::append($this->user->get_user_trace_file(), "\n------".$date." - ".ucwords(str_replace('_', ' ', $method_this_time))."\n");

        $message = "";
        // on appelle la fonction $action / $action->action_type avec les paramètres contenus dans le tableau $args_this_time
        // (on fait ça parce que les différentes actions prennent des paramètres différents)
        $message_returned_by_this_action = call_user_func_array([$this, $method_this_time], $args_this_time);
        
        return $message_returned_by_this_action;
    }





    /********************************************************/
    /****** FUNCTIONS USED FOR EACH ACTION or SEQUENCE ******/
    /********************************************************/



    /**************************************************************************/
    /**************************************************************************/
    /* MAIN FUNCTIONS: CORRESPONDING TO 'action_type' elements FROM DASHBOARD */
    /**************************************************************************/
    /**************************************************************************/


    public function share_closet($closet_username, $share_to, $type, $availability, $shipping, $condition, $min_price_value = null, $max_price_value = null, $number_items = null)
    {
        $current = "Starting job...";
        $this->setCurrentActionInfo($current);

        $number_listings = 50; 

        $items_shared = 0;
        for ($i = 0; $i < $number_listings; $i++) {

            sleep(1);
            
            $items_shared++;

            $current = "Shared ".$items_shared;
            $current .= ($items_shared > 1) ? " items" : " item";
            $current .= $number_items ? " / ".$number_items : "";
            $this->setCurrentActionInfo($current);
        }

        
        $message = $items_shared .' item'.($items_shared > 1 ? 's' : '').' shared';
        $this->credits_used_for_job++; 
        
        return $message;
    }







    /***********************************/
    /* LOGGING AND DISPLAYING MESSAGES */
    /***********************************/

    public function generateRunJobDescription()
    {
        return "<span class='text-xl'>Job in progress</span>";
    }

}
