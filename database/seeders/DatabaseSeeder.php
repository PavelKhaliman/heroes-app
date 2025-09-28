<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\Photo;
use App\Models\User;
use App\Models\ForumSection;
use App\Models\ForumSubsection;
use App\Models\ForumReply;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'member',
            'email' => 'member@mail.ru',
            'password' => 'member',
            'role' => 'member',
            'nickname' => 'member',
        ]);
        
        User::factory()->create([
            'name' => 'moderator',
            'email' => 'moderator@mail.ru',
            'password' => 'moderator',
            'role' => 'moderator',
            'nickname' => 'moderator',
        ]);

        User::factory()->create([
            'name' => 'authorized',
            'email' => 'authorized@mail.ru',
            'password' => 'authorized',
            'role' => 'authorized',
            'nickname' => 'authorized',
        ]);

        // Additional admin account with requested email
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.ru',
            'password' => 'admin',
            'role' => 'admin',
            'nickname' => 'admin2',
        ]);

        User::factory(5)->create();

        Photo::factory(12)->create();
        Guide::factory(10)->create();

        // Forum seed: sections, subsections, replies
        $sections = ForumSection::factory()->count(3)->create();
        foreach ($sections as $section) {
            $subs = ForumSubsection::factory()->count(2)->create([
                'forum_section_id' => $section->id,
            ]);
            foreach ($subs as $sub) {
                ForumReply::factory()->count(4)->create([
                    'forum_subsection_id' => $sub->id,
                ]);
            }
        }
    }
}
