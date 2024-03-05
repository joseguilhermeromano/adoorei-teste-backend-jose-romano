<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;


class ProductRepository implements ProductRepositoryInterface
{

    public function getAll()
    {
        return Product::orderBy('id', 'asc')->get();
    }

    public function getById($id)
    {
        return Product::find($id);
    }

    public function create(array $new)
    {
        return  Product::create($new);
    }

    public function update($id, array $new)
    {
        Product::whereId($id)->update($new);
        return Product::find($id);
    }

    public function delete($id)
    {
        Product::destroy($id);
    }
}
