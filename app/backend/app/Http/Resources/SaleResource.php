<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            "sale_id" => $this->id,
            "amount" => $this->amount,
            "products" => $this->order->products->map(
                function ( $product ) {
                    return [
                        "product_id" => $product->id,
                        "name" => $product->name,
                        "price" => $product->price,
                        "amount" => $this->order->amount
                    ];
                }
            )
        ];
    }
}
