<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable = ['id','amount'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->id)) {
                $model->id = date('Ymd');
            }
        });
    }

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
}
