<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable = ['amount'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = date('Ymd');
        });
    }
}
