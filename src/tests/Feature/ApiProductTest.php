<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiProductTest extends TestCase
{
    public function test_the_application_return_list_products_generated_by_factory_and_seeder():void
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $data = [
            [
                "name" => "Celular 1",
                "price" => "1.800",
                "description" => "Aparelho dual chip na cor branca"
            ],
            [
                "name" => "Celular 2",
                "price" => "3.200",
                "description" => "Aparelho dual chip na cor preta"
            ],
            [
                "name" => "Celular 3",
                "price" => "9.800",
                "description" => "Aparelho dual chip na cor azul"
            ],
            [
                "name" => "Celular 4",
                "price" => "3.000",
                "description" => "Aparelho dual chip na cor vermelha"
            ],
            [
                "name" => "Celular 5",
                "price" => "3.500",
                "description" => "Aparelho dual chip na cor verde"
            ],
            [
                "name" => "Celular 6",
                "price" => "4.000",
                "description" => "Aparelho dual chip na cor amarelo"
            ],
            [
                "name" => "Celular 7",
                "price" => "3.000",
                "description" => "Aparelho dual chip na cor laranja"
            ],
            [
                "name" => "Celular 8",
                "price" => "3.500",
                "description" => "Aparelho dual chip na cor violeta"
            ],
            [
                "name" => "Celular 9",
                "price" => "4.000",
                "description" => "Aparelho dual chip na cor marrom"
            ],
            [
                "name" => "Celular 10",
                "price" => "6.000",
                "description" => "Aparelho dual chip na cor cinza"
            ],
        ];

        $response->assertJson($data);
    }

}
