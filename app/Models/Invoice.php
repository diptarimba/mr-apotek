<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'id';

    protected $fillable = [
        'supplier_id',
        'invoice_code',
        'publish_date',
        'due_date',
        'tax',
        'total',
    ];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, "supplier_id", "id");
    }

    public function invoice_product()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
