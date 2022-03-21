<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\SendSystemErrorMailJob;

class Error extends Model
{
    public const ERR_BROWSER_CREATION = 100;
    public const ERR_LOGIN = 200;

    public const ERR_GO_TO_CLOSET = 300;
    
    public const ERR_LOADPAGETHENSCROLLBACKTOTOP = 310;
    public const ERR_GETNUMBERLISTINGS = 320;
    public const ERR_GETNUMBERSHARES = 330;
    public const ERR_GETNUMBERFOLLOWERS_ING = 340;

    public const ERR_SHARE_CLOSET = 400;
    public const ERR_SHARE_FEED = 410;
    
    public const ERR_UNFOLLOW_FOLLOW_FOLLOWING = 450;
    public const ERR_FOLLOW_FOLLOWERS = 460;
    public const ERR_FOLLOW_FOLLOWING = 470;

    public const ERR_CAPTCHA_LOGIN = 700;
    public const ERR_CAPTCHA = 710;

    public const ERR_NO_DAILY_CREDIT = 800;
    public const ERR_NO_SUBSCRIPTION = 810;
    public const ERR_NO_ACTIVE_PLAN = 820;

    public const ERR_FAILED_JOB = 900;

    

    public const ERROR_FILE = 'errors.txt';


    public static function generateError($user, $error_name, $description = null)
    {       
        $user_error_file = $user->get_user_error_file();

        $error_code = constant("SELF::$error_name");

        $date = date('Y-m-d H:i:s');
        $new_log_entry = SELF::formatLogEntryWithoutDate($user, $error_code, $error_name, $description);
        Storage::append(SELF::ERROR_FILE, "\n".$date."\t\t".$new_log_entry);
        Storage::append($user_error_file, "\n".$date."\t\t".$new_log_entry);

        SendSystemErrorMailJob::dispatch($date, $new_log_entry);

        $message = "Error ".$error_code." : Something went wrong... Your request could not be completed this time. Please try again. ";    
        if($error_code !== SELF::ERR_FAILED_JOB) 
        {
            $message .= "(No credit used.) ";
        }
        $message = "<span class='text-red-600 font-bold'>".$message."</span>";
        return $message;
    }


    public static function formatLogEntryWithoutDate($user, $error_code, $error_name, $description = null)
    {        
        $user_id = $user->id;

        $log_entry = $error_name." (code: ".$error_code.")"
        .($description ? ": ".$description : "").
        "\t\tUser id: (".$user_id.")";

        return $log_entry;
    }
}
