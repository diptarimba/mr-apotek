<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();
        $supplier = \App\Models\Supplier::inRandomOrder()->get()->take(5);
        $supplier->each(function ($supplier) use ($user){
            \App\Models\Invoice::factory(1)->state(['supplier_id' => $supplier->id, 'updated_by_id' => $user->id])
            ->create()->each(function ($invoice) {
                \App\Models\Product::inRandomOrder()->get()->take(5)->each(function($query) use ($invoice){
                    \App\Models\ProductTracker::factory(1)->state(['invoice_id' => $invoice->id, 'product_id' => $query->id])->create();
                });

                $invoice->increment('total', $invoice->invoice_product()->sum('buy_amount'));
            });
        });
    }
}
