<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'sales';
    protected $fillable = ['id','amount'];

    public function orders():HasMany
    {
        return $this->hasMany(Order::class, 'sale_id', 'id');
    }

    public function amount()
    {
        return $this->orders->sum(function ($order) {
            return $order->quantity * $order->product->price;
        });
    }

    /**
     * Return customized id sale
     *
     * @param  mixed  $value
     * @return string
     */
    public function getIdCustom()
    {
        $date = $this->created_at->format('Ymd');

        return $date . $this->id;
    }
}
