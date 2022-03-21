<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Closet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function encryptPassword(String $password)
    {
        $inverted_password = Str::reverse($password);

        $each_char_plus_one_password = "";
        for($i = 0; $i < Str::length($inverted_password); $i++)
        {
            $each_char_plus_one_password .= Str::substr($inverted_password, $i, 1);
            $each_char_plus_one_password .= Str::random(1);
        }

        $shifted_password = "";
        $first_char = Str::substr($each_char_plus_one_password, 0, 1);
        for($i = 0; $i < Str::length($each_char_plus_one_password)-1; $i++)
        {
            $shifted_password .= Str::substr($each_char_plus_one_password, $i+1, 1);
        }
        $shifted_password .= $first_char;

        $password_with_extra = Str::random(4).$shifted_password.Str::random(3);
        //return utf8_encode($password_with_extra);
        return $password_with_extra;
    }

    public static function decryptPassword(String $encrypted_password)
    {
        //$password_without_beg_end = utf8_decode(Str::substr($encrypted_password, 4, Str::length($encrypted_password)-7));
        $password_without_beg_end = Str::substr($encrypted_password, 4, Str::length($encrypted_password)-7);
        
        $remove_each_char_plus_one_password = "";
        for($i = 0; $i < Str::length($password_without_beg_end); $i++)
        {
            if($i % 2 !== 0) // every other char must be kept
            {
                $remove_each_char_plus_one_password .= Str::substr($password_without_beg_end, $i, 1);
            }
        }

        $shifted_password = "";
        $last_char = Str::substr($remove_each_char_plus_one_password, Str::length($remove_each_char_plus_one_password)-1, 1);
        $shifted_password .= $last_char;
        for($i = 1; $i < Str::length($remove_each_char_plus_one_password); $i++)
        {
            $shifted_password .= Str::substr($remove_each_char_plus_one_password, $i-1, 1);
        }
        return Str::reverse($shifted_password);
    }
}
