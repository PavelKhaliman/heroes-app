<?php

namespace Database\Factories;

use App\Models\ForumSection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ForumSection>
 */
class ForumSectionFactory extends Factory
{
    protected $model = ForumSection::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);
        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title).'-'.Str::random(5),
            'description' => $this->faker->optional()->sentence(8),
            'position' => $this->faker->numberBetween(0, 50),
        ];
    }
}


