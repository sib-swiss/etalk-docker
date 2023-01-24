<?php

namespace Database\Seeders;

use App\Models\Sound;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *,
                    "file_link" => $data['7']
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // delete all fodler for all media
        Sound::all()->each->delete();
        $this->call([
            UserSeeder::class,
            TalkSeeder::class,
            SoundSeeder::class,
        ]);
    }
}
