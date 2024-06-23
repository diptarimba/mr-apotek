<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTracker extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'quantity_received',
        'quantity_sold',
        'quantity_returned',
        'quantity_expired',
        'buy_price',
        'buy_amount',
        'buy_notes',
        'expired_at',
        'invoice_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, "invoice_id", "id");
    }
}
