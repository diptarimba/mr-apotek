<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $primaryKey = 'id';

    protected $fillable = [
        'supplier_id',
        'invoice_code',
        'publish_date',
        'due_date',
        'updated_by_id',
        'approved_at',
        'tax',
        'total',
    ];

    protected $dates = [
        'approved_at',
        'deleted_at'
    ];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, "supplier_id", "id");
    }

    public function invoice_product()
    {
        return $this->hasMany(ProductTracker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, "updated_by_id", "id");
    }
}
