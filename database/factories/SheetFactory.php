<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class SheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'column' => $this->faker->numberBetween(1, 5),
            'row' => $this->faker->randomElement(['a', 'b', 'c']),
        ];
    }
}
