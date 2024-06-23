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
        'updated_by_id',
        'due_at',
        'approved_at',
        'published_at',
        'tax',
        'total',
    ];

    protected $dates = [
        'published_at',
        'approved_at',
        'deleted_at'
    ];

    protected $dateFormat = 'Y-m-d';
    public function supplier()
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
