<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // hash for word 'password'
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'room' => $this->faker->randomNumber(3),
            'role' => 'specialist',
            'is_available' => $this->faker->randomKey([1,0]),
            'remember_token' => Str::random(10),
        ];
    }
}
