<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Example how to use passed parameter to ProductFactory
        return [
            'name' => 'Obat '.$this->faker->name(),
            'sell_price' => $this->faker->numberBetween(1,50) * 100,
            'image' => asset('assets-dashboard/images/not-found.png'),
            'quantity' => $this->faker->numberBetween(100,2000),
            'branch_code' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'unit_id' => 'redacted',
        ];
    }
}
