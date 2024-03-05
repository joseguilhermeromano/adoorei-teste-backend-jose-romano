<?php

namespace Database\Factories;

use App\Helpers\GenerateFakerSaleId;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $sale;

    public function definition()
    {
        return [
            "amount" => 0
        ];
    }
}
