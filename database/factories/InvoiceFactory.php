<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $publishedAt = null;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->publishedAt = Carbon::now()->addDays(rand(7,10));
        return [
            'supplier_id' => 'redacted',
            'invoice_code' => $this->faker->regexify('[A-Z0-9]{15}'),
            'updated_by_id' => 'redacted',
            'published_at' => $this->publishedAt->format('Y-m-d H:i:s'),
            'due_at' => $this->publishedAt->addDays(7)->format('Y-m-d H:i:s'),
            'approved_at' => null,
            'tax' => 0,
            'total' => 0
        ];
    }
}
