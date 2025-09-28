<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(16, 60),
            'nic_name' => $this->faker->userName(),
            'level' => $this->faker->numberBetween(1, 100),
            'charecter_class' => $this->faker->randomElement(['Warrior','Mage','Rogue']),
            'info' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement(['new','accepted','pending','rejected']),
            'strong' => $this->faker->boolean(),
            'survival' => $this->faker->boolean(),
            'prime_msk' => $this->faker->randomElement(['morning','day','evening','night']),
            'kos_list' => $this->faker->boolean(),
        ];
    }
}


