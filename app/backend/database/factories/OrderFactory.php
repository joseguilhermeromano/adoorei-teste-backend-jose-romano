<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'quantity' => rand(1, 10),
            'sale_id' => rand(1, 10),
            'product_id' => rand(1, 10),
        ];
    }
}
