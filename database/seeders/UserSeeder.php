<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Closet;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
    }
}
