<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory, HasUuids;
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
