<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Talk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sound>
 */
class SoundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dir = 'mark'; // Talk::factory();
        //        dd($dir);

        return [
            'talk_id' => Talk::factory(),
            'name' => $dir.'/Section_'.random_int(0, 20).'.mp3',
            'text' => $this->faker->text(),
            'type' => collect(['explanation', 'quotation'])->random(),
            'entities' => $this->faker->url(),
            'file' => 'H7Wez06hKibP-PtIQdBksw.jpg',     // TODO
            'file_credits' => '', // 'Creative Commons Attribution - Pas dâ€™Utilisation Commerciale - Partage dans les MÃªmes Conditions 3.0 Suisse',
            'file_link' => '',    // ('http://creativecommons.org/licenses/by-nc-sa/3.0/ch/deed.fr'),
            'chaptering' => collect(['continue', 'paragraph', 'section'])->random(),
            'section_title' => $this->faker->title(),
        ];
    }
}
