<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Sound;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
