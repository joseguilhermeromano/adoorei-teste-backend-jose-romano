<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $price = number_format($this->price, 0, '', '.');
        return [
            "name" => $this->name,
            "price" => $price,
            "description" => $this->description,
        ];
    }
}
