<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'telegram' => $this->faker->optional()->userName(),
            'teamspeak' => $this->faker->optional()->domainWord(),
            'officers' => $this->faker->optional()->name(),
        ];
    }
}


