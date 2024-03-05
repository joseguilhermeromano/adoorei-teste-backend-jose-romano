<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductResource;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return array_merge(
            $this->collection->map(
                function ( $product ) {
                    return new ProductResource($product);
                }
            )->toArray($request)
        );
    }
}
