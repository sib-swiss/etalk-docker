<?php

namespace Database\Seeders;

use App\Models\Sound;
use App\Models\Talk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileCsv=storage_path('app/sounds.csv');
        //dd($fileCsv);
        if (!File::exists($fileCsv)) {
            return;
        }

        Sound::truncate();
        $csvFile = fopen($fileCsv, "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== false) {
            if (!$firstline) {
                $talk=Talk::firstWhere('dir', $data[1]);
                Sound::create([
                    "name" => $data['0'],
                    "talk_id" => $talk->id,
                    "text" => $data['2'],
                    "type" => $data['3'],
                    "entities" => $data['4'],
                    "file" => $data['5'],
                    "file_credits" => $data['6'],
                    "file_link" => $data['7'],
                    "chaptering" => $data['8'],
                    "section_title" => $data['9']
                ]);
            }
            $firstline = false;
        }
    }
}
