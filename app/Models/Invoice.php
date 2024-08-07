<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'paid_at',
        'paid_by_id',
        'updated_by_id',
        'due_at',
        'approved_at',
        'approved_by_id',
        'published_at',
        'tax',
        'total',
    ];

    protected $dateFormat = 'Y-m-d';

    protected function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
            // set: fn (string $value) => strtolower($value),
        );
    }

    protected function dueAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
            // set: fn (string $value) => strtolower($value),
        );
    }

    // protected $casts = [
    //     'published_at'  => 'date:Y-m-d',
    //     'approved_at' => 'date:Y-m-d',
    // ];

    // protected $dates = [
    //     'published_at',
    //     'approved_at',
    //     'deleted_at'
    // ];

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

    public function approver()
    {
        return $this->belongsTo(User::class, "approved_by_id", "id");
    }

    public function payer()
    {
        return $this->belongsTo(User::class, "paid_by_id", "id");
    }
}
