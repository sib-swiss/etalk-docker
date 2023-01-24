<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Metadata;
use App\Models\Talk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class TalkTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_search_into_metadata()
    {
        $talks = Talk::factory(10)->create();
        foreach (Talk::all() as $talk) {
            Metadata::factory(10)->create(['talk_id' => $talk->id]);
        }

        $metadata = Metadata::inRandomOrder()->first();
        $talks = Talk::searchByCriteria($metadata->value)
            ->with('metadatas')
            ->get();
        $this->assertCount(1, $talks);
        $this->assertSame($metadata->talk_id, $talks->first()->id);
    }
}
