<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable = ['amount'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) $model->id = date('Ymd');
        });
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders', 'sale_id', 'id');
    }
}
