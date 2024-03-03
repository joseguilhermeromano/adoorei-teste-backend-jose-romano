<?php

namespace App\Repositories;

use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;


class SaleRepository implements SaleRepositoryInterface
{

    public function getAll()
    {
        return Sale::orderBy('amount', 'asc')->get();
    }

    public function getById($id)
    {
        return Sale::find($id);
    }

    public function create(array $new)
    {
        return  Sale::create($new);
    }

    public function update($id, array $new)
    {
        Sale::whereId($id)->update($new);
        return Sale::find($id);
    }

    public function delete($id)
    {
        Sale::destroy($id);
    }
}
