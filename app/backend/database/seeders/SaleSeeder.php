<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            $orders = Order::factory()->count(3)->create([
                'sale_id' => $sale->id
            ]);

            $totalAmount = $orders->sum(function ($order) {
                $product = Product::find($order->product_id);
                return $order->quantity * $product->price;
            });

            $sale->amount = $totalAmount;
            $sale->update(['amount' => $sale->amount]);
        });
    }
}
