<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::factory()->count(5)->create()->each(function ($sale) {
            Order::factory()->count(3)->create([
                'sale_id' => $sale->id
            ]);

            $sale->update(['amount' => $sale->amount()]);
        });
    }
}
