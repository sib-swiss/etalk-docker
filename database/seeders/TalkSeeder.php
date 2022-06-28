<?php

namespace Database\Seeders;

use App\Models\Talk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TalkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileCsv = storage_path('app/talks.csv');
        //dd($fileCsv);
        if (! File::exists($fileCsv)) {
            return;
        }

        Talk::truncate();
        $csvFile = fopen($fileCsv, 'r');
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $firstline) {
                Talk::create([
                    'dir' => $data['0'],
                    'title' => $data['1'],
                    'author' => $data['2'],
                    'date' => $data['3'],
                    'theme' => $data['4'],
                    'duration' => $data['5'],
                    'external_id' => $data['6'],
                    'published' => $data['7'],
                ]);
            }
            $firstline = false;
        }
    }
}
