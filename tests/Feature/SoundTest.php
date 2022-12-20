<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Sound;
use App\Models\Talk;
use App\Models\User;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class SoundTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testSoundHasCover(): void
    {
        $sound = Sound::factory()->create();

        // attach image as cover
        Storage::makeDirectory('public/testing');

        $image = Http::get('https://via.placeholder.com/640x480.png');
        $filename = 'test.png';
        Storage::put('public/testing/'.$filename, $image->body());

        // $filename = $this->faker->image('public/storage/testing', 640, 480, null, false);
        // this is now failig: https://github.com/FakerPHP/Faker/issues/475
        // static::assertNotFalse($filename);

        $filePath = storage_path('app/public/testing/'.$filename);

        // assert attached
        $toMediaCollection = $sound
            ->addMedia($filePath)
            ->toMediaCollection();
        static::assertSame($filename, $toMediaCollection->file_name);

        // assert url of image
        $urlToFirstListImage = $sound->getFirstMediaUrl();
        static::assertSame(url('storage/'.$sound->id.'/'.$filename), $urlToFirstListImage);

        // clean
        Storage::deleteDirectory('public/testing');
    }

    public function testSoundUploadMp3WillCreateOrUpdateIntoDatabase()
    {
        $talk = Talk::factory()->create(['dir' => 'Mark16_phpunit']);

        $user = User::factory()->create();
        $this->be($user);
        $fileName = '001.mp3';
        $audioFile = UploadedFile::fake()->create(
            $fileName,
            5 * 1024,
            'audio/mpeg'
        );
        $response = $this->post(route('sound.store'), [
            'etalk_id' => $talk->id,
            'audioFile' => $audioFile,
        ]);

        $response->assertStatus(200);
        $sound = Sound::first();
        $this->assertSame(
            $talk->dir.'/'.$fileName,
            $sound->name,
        );
        $this->assertFileExists(
            storage_path('app/public/data/'.$talk->dir.'/'.$fileName)
        );

        Storage::deleteDirectory('public/data/'.$talk->dir);
    }
}
