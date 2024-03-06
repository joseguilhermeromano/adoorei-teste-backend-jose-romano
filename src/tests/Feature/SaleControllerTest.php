<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\SaleController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Requests\SaleRequest;
use App\Models\Order;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Support\Carbon;

class SaleControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexReturnListSalesSuccess()
    {
        $date = Carbon::create(2024, 3, 5, 0, 0, 0);

        $prodsSaleOne = [
            "products" => [
                [
                    "product_id" => 1,
                    "name" => "Celular 1",
                    "price" => "1.800",
                    "amount" => 1
                ],
                [
                    "product_id" => 2,
                    "name" => "Celular 2",
                    "price" => "3.200",
                    "amount" => 1
                ],
                [
                    "product_id" => 3,
                    "name" => "Celular 3",
                    "price" => "9.800",
                    "amount" => 3
                ],
            ]
        ];

        $saleOne = Sale::factory()->create(["amount" => 34400, "created_at" => $date]);

        foreach ($prodsSaleOne['products'] as $prod) {
            $order = new Order([
                "quantity" => $prod["amount"],
                "sale_id" =>  $saleOne->id,
                "product_id" => $prod['product_id']
            ]);
            $saleOne->orders()->save($order);
        }

        $saleTwo = Sale::factory()->create(["amount" => 54400, "created_at" => $date]);

        $prodsSaleTwo = [
            "products" => [
                [
                    "product_id" => 1,
                    "name" => "Celular 1",
                    "price" => "1.800",
                    "amount" => 3
                ],
                [
                    "product_id" => 5,
                    "name" => "Celular 5",
                    "price" => "3.500",
                    "amount" => 8
                ],
                [
                    "product_id" => 7,
                    "name" => "Celular 7",
                    "price" => "3.000",
                    "amount" => 7
                ],
            ]
        ];

        foreach ($prodsSaleTwo['products'] as $prod) {
            $order = new Order([
                "quantity" => $prod["amount"],
                "sale_id" =>  $saleTwo->id,
                "product_id" => $prod['product_id']
            ]);
            $saleTwo->orders()->save($order);
        }


        $saleRepository = $this->getMockBuilder(SaleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();



        $saleRepository->expects($this->once())
            ->method('getAll')
            ->willReturn([$saleOne, $saleTwo]);

        $controller = new SaleController($saleRepository);

        $response = $controller->index();

        $date = $date->format('Ymd');

        $expectedResponse = '[
            {
              "sale_id": "' . $date . $saleOne->id . '",
              "amount": 34400,
              "products": [
                {
                  "product_id": 1,
                  "name": "Celular 1",
                  "price": "1.800",
                  "amount": 1
                },
                {
                  "product_id": 2,
                  "name": "Celular 2",
                  "price": "3.200",
                  "amount": 1
                },
                {
                  "product_id": 3,
                  "name": "Celular 3",
                  "price": "9.800",
                  "amount": 3
                }
              ]
            },
            {
              "sale_id": "' . $date . $saleTwo->id . '",
              "amount": 54400,
              "products": [
                {
                  "product_id": 1,
                  "name": "Celular 1",
                  "price": "1.800",
                  "amount": 3
                },
                {
                  "product_id": 5,
                  "name": "Celular 5",
                  "price": "3.500",
                  "amount": 8
                },
                {
                  "product_id": 7,
                  "name": "Celular 7",
                  "price": "3.000",
                  "amount": 7
                }
              ]
            }]';


        $response = $response->content();

        $this->assertJsonStringEqualsJsonString($expectedResponse, $response);
    }

    public function testStoreNewSaleSuccess(): void
    {
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

        $request = new SaleRequest($newSale);

        $saleRepository = $this->getMockBuilder(SaleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $date = Carbon::create(1978, 3, 5, 0, 0, 0);

        $saleRepository->expects($this->once())
            ->method('create')
            ->willReturn(new Sale(["id" => 1, "amount" => 376000, "created_at" => $date]));

        $controller = new SaleController($saleRepository);

        $response = $controller->store($request);

        $expectedResponse = '[
            {
                "sale_id":"197803051",
                "amount":376000,
                "products":
                [
                    {
                        "product_id":1,
                        "name":"Celular 1",
                        "price":"1.800",
                        "amount":1
                    },
                    {
                        "product_id":1,
                        "name":"Celular 1",
                        "price":"1.800",
                        "amount":10
                    },
                    {
                        "product_id":2,
                        "name":"Celular 2",
                        "price":"3.200",
                        "amount":1
                    },
                    {
                        "product_id":2,
                        "name":"Celular 2",
                        "price":"3.200",
                        "amount":20
                    },
                    {
                        "product_id":3,
                        "name":"Celular 3",
                        "price":"9.800",
                        "amount":3
                    },
                    {
                        "product_id":3,
                        "name":"Celular 3",
                        "price":"9.800",
                        "amount":30
                    }
                ]
            }
        ]';

        $response = $response->content();

        $this->assertJsonStringEqualsJsonString($expectedResponse, $response);
    }

    public function testUpdateSaleSuccess()
    {
        $newSale = [
            "amount" => 376000,
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

        $sale = Sale::factory()->create(["amount" => $newSale['amount']]);

        foreach ($newSale['products'] as $prod) {
            $order = new Order([
                "quantity" => $prod['amount'],
                "sale_id" => $sale->id,
                "product_id" => $prod['product_id']
            ]);

            $sale->orders()->save($order);
        }

        $updatedData = [
            "amount" => 474000,
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
                    "amount" => 40
                ],
            ]
        ];

        $expectedResponse = [
            "sale_id" => $sale->created_at->format('Ymd') . $sale->id,
            "amount" => 474000,
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
                    "amount" => 40
                ],
            ]
        ];


        $response = $this->put("/api/sale/{$sale->id}", $updatedData);

        $response->assertStatus(200);

        $expectedResponse = json_encode([$expectedResponse]);

        $response = $response->content();

        $this->assertJsonStringEqualsJsonString($expectedResponse, $response);
    }

    public function testUpdateException()
    {

        $sale = new Sale();
        $sale->id = 1;
        $sale->orders = collect();

        $request = new SaleRequest(['products' => []]);

        $saleRepository = $this->getMockBuilder(SaleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $saleRepository->expects($this->any())
            ->method('getById')
            ->willReturn($sale);

        $controller = new SaleController($saleRepository);

        $this->expectException(\Exception::class);

        $controller->update(1, $request);
    }

    public function testDestroySaleSuccess()
    {
        $newSale = [
            "amount" => 376000,
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

        $sale = Sale::factory()->create(["amount" => $newSale['amount']]);

        foreach ($newSale['products'] as $prod) {
            $order = new Order([
                "quantity" => $prod['amount'],
                "sale_id" => $sale->id,
                "product_id" => $prod['product_id']
            ]);

            $sale->orders()->save($order);
        }

        $expectedResponse = [
            "sale_id" => $sale->created_at->format('Ymd') . $sale->id,
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


        $response = $this->delete("/api/sale/{$sale->id}");

        $response->assertStatus(200);

        $expectedResponse = json_encode([$expectedResponse]);

        $response = $response->content();

        $this->assertJsonStringEqualsJsonString($expectedResponse, $response);
    }

    public function testAddProductToSaleSuccess()
    {
        $newSale = [
            "amount" => 376000,
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

        $sale = Sale::factory()->create(["amount" => $newSale['amount']]);

        foreach ($newSale['products'] as $prod) {
            $order = new Order([
                "quantity" => $prod['amount'],
                "sale_id" => $sale->id,
                "product_id" => $prod['product_id']
            ]);

            $sale->orders()->save($order);
        }

        $addProductsSale = [
            "products" => [
                [
                    "product_id" => 4,
                    "amount" => 10
                ],
            ]
        ];

        $expectedResponse = [
            "sale_id" => $sale->created_at->format('Ymd') . $sale->id,
            "amount" => 406000,
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
                [
                    "product_id" => 4,
                    "name" => "Celular 4",
                    "price" => "3.000",
                    "amount" => 10
                ],
            ]
        ];


        $response = $this->post("/api/sale/{$sale->id}/products", $addProductsSale);

        $response->assertStatus(200);

        $expectedResponse = json_encode([$expectedResponse]);

        $response = $response->content();

        $this->assertJsonStringEqualsJsonString($expectedResponse, $response);
    }

    public function testShowSaleSuccess()
    {
        $newSale = [
            "amount" => 376000,
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

        $sale = Sale::factory()->create(["amount" => $newSale['amount']]);

        foreach ($newSale['products'] as $prod) {
            $order = new Order([
                "quantity" => $prod['amount'],
                "sale_id" => $sale->id,
                "product_id" => $prod['product_id']
            ]);

            $sale->orders()->save($order);
        }

        $expectedResponse = [
            "sale_id" => $sale->created_at->format('Ymd') . $sale->id,
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


        $response = $this->get("/api/sale/{$sale->id}");

        $response->assertStatus(200);

        $expectedResponse = json_encode([$expectedResponse]);

        $response = $response->content();

        $this->assertJsonStringEqualsJsonString($expectedResponse, $response);
    }

    public function testShowSaleException()
    {
        $saleRepository = $this->getMockBuilder(SaleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $saleRepository->expects($this->any())
            ->method('getById')
            ->willReturn(null);

        $controller = new SaleController($saleRepository);

        $expectedResponse = '{"error":"No sale found"}';

        $response = $controller->show(999999);

        $this->assertJsonStringEqualsJsonString($expectedResponse, $response->content());
    }
}
