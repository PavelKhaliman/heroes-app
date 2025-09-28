<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Guide>
 */
class GuideFactory extends Factory
{
    protected $model = Guide::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'excerpt' => $this->faker->optional()->text(120),
            'body' => $this->faker->paragraphs(3, true),
            'image_path' => null,
            'kind' => $this->faker->randomElement(['east','north','west','central','other']),
            'user_id' => User::factory(),
        ];
    }
}


