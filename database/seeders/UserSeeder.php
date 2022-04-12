<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') === 'local') {
            User::create([
               'name'=>'Silvano',
               'email'=>'silvano.alda@sib.swiss',
               'password'=>Hash::make('password'),
           ]);
        }
    }
}
