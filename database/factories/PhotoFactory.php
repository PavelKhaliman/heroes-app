<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    protected $model = Photo::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'image_path' => 'photos/example.jpg',
            'description' => $this->faker->optional()->paragraph(),
            'user_id' => User::factory(),
            'kind' => 'photo',
        ];
    }
}


