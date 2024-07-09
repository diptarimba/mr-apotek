<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function expiredAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
            // set: fn (string $value) => strtolower($value),
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, "invoice_id", "id");
    }

    public function oldest()
    {
        return $this
        ->where('quantity_received', '>', '0')
        ->whereDate('expired_at', '>', now())
        ->whereHas('invoice', function($query){
            $query->whereNotNull('approved_at');
        })
        ->orderBy("created_at", "asc");
    }

    public function sold_all()
    {
        $this->increment("quantity_sold", $this->quantity_received);
        $this->decrement("quantity_received", $this->quantity_received);
    }
}
