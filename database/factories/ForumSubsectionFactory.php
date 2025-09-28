<?php

namespace Database\Factories;

use App\Models\ForumSection;
use App\Models\ForumSubsection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ForumSubsection>
 */
class ForumSubsectionFactory extends Factory
{
    protected $model = ForumSubsection::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);
        return [
            'forum_section_id' => ForumSection::factory(),
            'title' => ucfirst($title),
            'slug' => Str::slug($title).'-'.Str::random(5),
            'description' => $this->faker->optional()->sentence(8),
            'position' => $this->faker->numberBetween(0, 50),
        ];
    }
}


