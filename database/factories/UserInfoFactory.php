<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'age' => $this->faker->numberBetween(18, 60),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'date' => $this->faker->date(),
        ];
    }
}
