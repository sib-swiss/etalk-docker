<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Sound;
use App\Models\Talk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Storage;

class SoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fileCsv = storage_path('app/sounds.csv');
        // dd($fileCsv);
        if (! File::exists($fileCsv)) {
            return;
        }

        Sound::truncate();
        $csvFile = fopen($fileCsv, 'r');
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $firstline) {
                $talk = Talk::firstWhere('dir', $data[1]);

                $namePath = explode('/', $data['0']);
                $sound = Sound::create([
                    'name' => $namePath['1'],
                    'talk_id' => $talk->id,
                    'text' => $data['2'],
                    'type' => $data['3'],
                    'entities' => $data['4'],
                    'file' => $data['5'],
                    'file_credits' => $data['6'],
                    'file_link' => $data['7'],
                    'chaptering' => $data['8'],
                    'section_title' => $data['9'],
                ]);

                // cover
                $filePath = storage_path('app/legacy/tmp/'.$data['5']);
                if (trim($data['5']) && File::exists($filePath)) {
                    // echo "\n" . $filePath;
                    $sound->addMedia($filePath)
                        ->preservingOriginal()
                        ->toMediaCollection();
                }

                // audio
                $audioStoragePath = '/legacy/data/'.$data['0'];
                if (Storage::exists($audioStoragePath)) {
                    Storage::copy(
                        $audioStoragePath,
                        "{$talk->storagepath}/{$namePath[1]}"
                    );
                }
            }
            $firstline = false;
        }
    }
}
