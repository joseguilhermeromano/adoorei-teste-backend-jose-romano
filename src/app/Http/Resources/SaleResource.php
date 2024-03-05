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
            "sale_id" => $this->getIdCustom(),
            "amount" => $this->amount,
            "products" => $this->orders
                ->sortBy(function($order){
                    return $order->product_id;
                })
                ->values()
                ->map(function ( $order ) {
                        $price = number_format($order->product->price, 0, '', '.');
                        return [
                            "product_id" => $order->product->id,
                            "name" => $order->product->name,
                            "price" =>  $price,
                            "amount" => $order->quantity
                        ];
                    }
                )
        ];
    }
}
