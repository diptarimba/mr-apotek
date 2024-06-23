<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'invoice_id',
        'updated_by_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, "invoice_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "updated_by_id", "id");
    }
}
