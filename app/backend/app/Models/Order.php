<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Product;

class Order extends Model{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['quantity', 'sale_id', 'product_id'];

    public function Sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function Products()
    {
        return $this->belongsToMany(Product::class, 'orders', 'sale_id', 'product_id');
    }
}
