<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LineItem>
 */
class LineItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit_of_measure' => $this->faker->randomElement(['pcs', 'kg', 'm', 'ltr']),
            'price' => $this->faker->randomFloat(2, 5, 500),
        ];
    }
}
