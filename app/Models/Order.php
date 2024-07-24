<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'id';

    protected $fillable = [
        'notes',
        'amount',
        'customer_pay',
        'change',
        'updated_by_id'
    ];

    public function order_product()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
