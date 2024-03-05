<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiSaleTest extends TestCase
{
    use DatabaseTransactions;
    public function test_the_application_will_store_sale():void
    {
        $expectedResponse = [
            "amount" => 376000,
            "products" => [
                [
                    "product_id" => 1,
                    "name" => "Celular 1",
                    "price" => "1.800",
                    "amount" => 10
                ],
                [
                    "product_id" => 2,
                    "name" => "Celular 2",
                    "price" => "3.200",
                    "amount" => 20
                ],
                [
                    "product_id" => 3,
                    "name" => "Celular 3",
                    "price" => "9.800",
                    "amount" => 30
                ],
            ]
        ];


        $newSale = [
            "amount" => 0,
            "products" => [
                [
                    "product_id" => 1,
                    "amount" => 10
                ],
                [
                    "product_id" => 2,
                    "amount" => 20
                ],
                [
                    "product_id" => 3,
                    "amount" => 30
                ],
            ]
        ];

        $response = $this->post('/api/sale', $newSale);

        $response->assertStatus(201);

        $responseData = json_decode($response->content(), true);

        $expectedResponse["sale_id"] = $responseData[0]['sale_id'];

        $responseJson = $response->content();
        $expectedResponseJson = json_encode([$expectedResponse]);

        $this->assertJsonStringEqualsJsonString($expectedResponseJson, $responseJson);
    }

}
