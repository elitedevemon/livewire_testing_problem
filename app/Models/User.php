<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Barryvdh\Debugbar\Facades\Debugbar;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function closets()
    {
        return $this->hasMany(Closet::class);
    }



    public function get_user_log_folder()
    {
        return $this->id.'/';
    }

    public function get_user_action_file()
    {
        return $this->get_user_log_folder().$this->id.'_actions.txt' ;
    }

    public function get_user_error_file()
    {
        return $this->get_user_log_folder().$this->id.'_errors.txt' ;
    }

    public function get_user_trace_file()
    {
        return $this->get_user_log_folder().$this->id.'_investigation.txt' ;
    }


    public function substring_in_screenshot_file_name_indicating_user()
    {
        return '_'.$this->id.'.jpg';
    }
}
