<?php

namespace App\Http\Traits;

use App\Models\User;

trait BotUtilsTrait {



    public function getRandom($delay_min, $delay_max = 0)
    {
        // the goal of this function is to not have a fixed delay that is always 
        // exactly the same, but instead, mimick a human behavior with a delay that 
        // is not too precise - we want a delay that changes slightly each time

        if ($delay_max == 0)
        {
            return random_int($delay_min * 0.9, $delay_min * 1.1);
        }
        else
        {
            return random_int($delay_min, $delay_max);
        }
    }
    

}