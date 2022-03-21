<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Action;
use Illuminate\Support\Facades\Storage;
use App\Models\Error;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Closet;

use App\Jobs\RunJob;

use App\Http\Traits\BotUtilsTrait;


class BotController extends Controller
{
    use BotUtilsTrait;

    public function startJob()
    {               
        $connected_closet = Closet::first();

        $action_type = "share_closet";

        $args = [];
        $args['closet_username'] = 'roxhan';
        $args['share_to'] = 'followers';
        $args['type'] = 'all';
        $args['availability'] = 'all';
        $args['shipping'] = 'all';
        $args['condition'] = 'all';
        $args['min_price_value'] = 0;
        $args['max_price_value'] = 100;
    
        $redirect = $this->dispatchRunJobIfCredits($connected_closet, $action_type, $args);
        return $redirect;

    }

    public function dispatchRunJobIfCredits($connected_closet, $action_type = null, $args = null)
    {
        $job = new RunJob(User::first(), $connected_closet, $action_type, $args);
            
        $this->dispatch($job);

        return redirect()->back();
    }
 
}
