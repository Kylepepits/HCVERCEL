<?php

namespace Database\Seeders;


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\user;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $time = now();
        $date = new Carbon($time);

        $User = [   

            [
               'id' => $date->year . 'A' . 1 ,
               'name' => 'paul',
               'email' => 'paul@gmail.com',
               'password' => bcrypt(123),
               'role' => 'admin', 


               'created_at' => now(),
               'updated_at' => now(),
            ],
            
       ];

       user::insert($User);
    }
}
