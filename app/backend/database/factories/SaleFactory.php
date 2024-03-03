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
            "id" => $this->generateSaleId(),
            "amount" => 0
        ];
    }

    protected function generateSaleId(){
        $randomDate = GenerateFakerSaleId::createRandomDate(2024, 03);

        return $randomDate->format('Ymd');
    }
}
