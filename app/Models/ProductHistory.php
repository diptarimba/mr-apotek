<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    const STATUS_RECEIVED = "RECEIVED";
    const STATUS_SOLD = "SOLD";
    const STATUS_RETURNED = "RETURNED";
    const STATUS_EXPIRED = "EXPIRED";

    use HasFactory, HasUuids;
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'quantity',
        'type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
