<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductTracker>
 */
class ProductTrackerFactory extends Factory
{
    protected $quantity_received = 0;
    protected $buy_price = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->quantity_received = $this->faker->numberBetween(100,2000);
        $this->buy_price = $this->faker->numberBetween(1,20) * 100;
        return [
            'product_id' => 'redacted',
            'invoice_id' => 'redacted',
            'quantity_received' => $this->quantity_received,
            'buy_price' => $this->buy_price,
            'buy_amount' => $this->buy_price * $this->quantity_received,
            'expired_at' => $this->faker->dateTimeBetween('+5 week', '+10 week'),

        ];
    }
}
