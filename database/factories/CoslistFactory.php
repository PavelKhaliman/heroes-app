<?php

namespace Database\Factories;

use App\Models\Coslist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Coslist>
 */
class CoslistFactory extends Factory
{
    protected $model = Coslist::class;

    public function definition(): array
    {
        $isGuild = $this->faker->boolean();
        return [
            'nicname' => $isGuild ? '-' : $this->faker->userName(),
            'guild' => $this->faker->company(),
            'master' => $isGuild ? $this->faker->name() : '-',
            'reason' => $this->faker->sentence(),
            'repayment' => (string)$this->faker->numberBetween(1000, 100000),
        ];
    }
}


