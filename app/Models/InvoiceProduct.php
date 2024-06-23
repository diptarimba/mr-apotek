<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'id';

    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'price',
        'notes',
        'amount',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, "invoice_id", "id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
