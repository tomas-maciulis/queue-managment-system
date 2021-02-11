<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::all())->id,
            'slug' => $this->faker->regexify('[a-z0-9]{24}'),
            'code' => $this->faker->regexify('[a-z0-9]{5}'),
            'status' => $this->faker->randomElement(['received', 'in progress', 'cancelled', 'finished']),
            'start_at' => $this->faker->dateTimeBetween('now', '+8 hours'),
        ];
    }
}
