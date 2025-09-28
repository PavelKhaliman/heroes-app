<?php

namespace Database\Factories;

use App\Models\ForumReply;
use App\Models\ForumSubsection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ForumReply>
 */
class ForumReplyFactory extends Factory
{
    protected $model = ForumReply::class;

    public function definition(): array
    {
        return [
            'forum_subsection_id' => ForumSubsection::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(6),
            'body' => $this->faker->paragraphs(2, true),
        ];
    }
}


