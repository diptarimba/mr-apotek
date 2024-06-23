<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'unit_id',
        'sell_price',
        'image',
        'quantity',
        'branch_code',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function product()
    {
        return $this->hasMany(ProductHistory::class);
    }

    public function product_tracker()
    {
        return $this->hasMany(ProductTracker::class);
    }

    public function order_product()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
